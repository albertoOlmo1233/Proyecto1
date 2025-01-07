<?php 
include_once("config/dataBase.php");
include_once("models/admin/Logs/LogDetalle.php");
include_once("models/UsuarioDAO.php");
include_once("models/ProductoGeneral.php");
include_once("models/UsuarioDetalle.php");


class AdminDAO {
    // Logs
    public static function getLogs(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM log");

        $stmt->execute();
        $result = $stmt->get_result();

        $logs = [];

        while($log = $result->fetch_object("LogDetalle")) {
            $logs[] = $log;
        }

        $con->close();

        return $logs;
    }

    // Pedidos
    public static function obtenerPedidos() {
        $con = DataBase::connect();
        
        // Primera consulta: obtener los pedidos con productos
        $stmt = $con->prepare("
        SELECT 
            pedido.id_pedido,
            IFNULL(GROUP_CONCAT(detalle_pedido.id_producto), '') AS productos,
            SUM(detalle_pedido.cantidad) AS cantidad_total,
            pedido.id_usuario,
            pedido.Fecha,
            pedido.total_pedido
        FROM 
            detalle_pedido
        INNER JOIN 
            pedido 
        ON 
            detalle_pedido.id_pedido = pedido.id_pedido
        GROUP BY pedido.id_pedido;");
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        $pedidos = [];
        
        // Preparar la segunda consulta para obtener el correo del usuario
        $stmt1 = $con->prepare("SELECT correo FROM usuario WHERE id_usuario = ?");
        
        while ($pedido = $result->fetch_object()) {
            $id_usuario = $pedido->id_usuario;
            
            // Ejecutar la consulta para obtener el correo
            $stmt1->bind_param("i", $id_usuario);
            $stmt1->execute();
            $resultCorreo = $stmt1->get_result();
            
            if ($correo = $resultCorreo->fetch_object()) {
                $pedido->correo = $correo->correo;
            } else {
                $pedido->correo = null;
            }
            
            // Convertir la cadena de productos en un array
            $pedido->productos = !empty($pedido->productos) ? explode(",", $pedido->productos) : [];
            $pedidos[] = $pedido;
        }
        
        // Cerrar las conexiones
        $stmt->close();
        $stmt1->close();
        $con->close();
        
        return $pedidos;  // Retorna la lista de pedidos con los productos correctamente procesados
        }
    

    public static function obtenerPedido() {
        $con = DataBase::connect();
        $id_usuario = $_SESSION['usuario']['id'];
        // Primera consulta: obtener los pedidos para un usuario específico
        $stmt = $con->prepare("
            SELECT 
                pedido.id_pedido,
                GROUP_CONCAT(detalle_pedido.id_producto) AS productos,
                SUM(detalle_pedido.cantidad) AS cantidad_total,
                pedido.id_usuario,
                pedido.Fecha,
                pedido.total_pedido
            FROM 
                detalle_pedido
            INNER JOIN 
                pedido 
            ON 
                detalle_pedido.id_pedido = pedido.id_pedido
            WHERE pedido.id_usuario = ?
            GROUP BY pedido.id_pedido
        ");

        $stmt->bind_param("i", $id_usuario);
  
        $stmt->execute();
        $result = $stmt->get_result();
        
        $pedidos = [];
        
        // Preparar una sola consulta para obtener los productos de los pedidos
        while ($pedido = $result->fetch_object()) {
            // Convertir la cadena de productos en un array
            $pedido->productos = explode(",", $pedido->productos);
            $pedidos[] = $pedido;
        }
        
        // Cerrar conexiones
        $stmt->close();
        $con->close();
        
        return $pedidos;  // Devolver la lista de pedidos
    }
    public static function eliminarPedido($id_usuario, $id_pedido) {
        // Conexión a la base de datos
        $con = DataBase::connect();
        
        // Iniciar la transacción
        $con->begin_transaction();
    

        // Eliminar los detalles de pedido asociados con los pedidos del usuario
        $detalles_pedidos = $con->prepare(
            "DELETE FROM detalle_pedido
            WHERE id_pedido = ? AND EXISTS (
                SELECT 1 FROM pedido WHERE pedido.id_pedido = detalle_pedido.id_pedido AND pedido.id_usuario = ?
            );"
        );

        $detalles_pedidos->bind_param("ii", $id_pedido, $id_usuario);
        $detalles_pedidos->execute();

        // Verificar si se eliminaron los detalles
        if ($detalles_pedidos->affected_rows == 0) {
            throw new Exception("No se pudieron eliminar los detalles de pedido. Verifica que existan detalles asociados.");
        }

        // Eliminar el pedido del usuario (una vez que los detalles han sido eliminados)
        $pedidos = $con->prepare("DELETE FROM pedido WHERE id_usuario = ? AND id_pedido = ?");
        $pedidos->bind_param("ii", $id_usuario, $id_pedido);
        $pedidos->execute();

        // Verificar si se eliminó el pedido
        if ($pedidos->affected_rows == 0) {
            throw new Exception("No se encontró el pedido o no se pudo eliminar.");
        }
        
        // Reiniciar el AUTO_INCREMENT de las tablas relacionadas
        $queries = [
            "ALTER TABLE detalle_pedido AUTO_INCREMENT = 1;",
            "ALTER TABLE pedido AUTO_INCREMENT = 1;"
        ];

        // Ejecutar todas las consultas de reinicio del AUTO_INCREMENT
        foreach ($queries as $query) {
            $autoIncrement = $con->prepare($query);
            $autoIncrement->execute();
        }

        // Confirmar la transacción si todo salió bien
        $con->commit();

        // Mensaje si se eliminan pedidos y detalles
        $mensaje = "Pedido eliminado correctamente.";

        // Cerrar los statement
        $detalles_pedidos->close();
        $pedidos->close();

        // Cerrar la conexión a la base de datos
        $con->close();

        return $mensaje;
    }
    
    
    
    
    public static function eliminarProductoPedido($id_pedido, $id_producto) {
        // Crear la conexión con la base de datos
        $con = DataBase::connect();
    
        // Obtener el cantidad del producto
        $stmt_cantidad = $con->prepare("SELECT cantidad FROM detalle_pedido WHERE id_pedido = ? AND id_producto = ?");
        $stmt_cantidad->bind_param("ii", $id_pedido, $id_producto);
        $stmt_cantidad->execute();
        $stmt_cantidad->bind_result($cantidad);
        if (!$stmt_cantidad->fetch()) {
            echo json_encode([
                'estado' => 'Fallido',
                'mensaje' => "El producto no existe en el pedido."
            ]);
            $stmt_cantidad->close();
            $con->close();
            return;
        }
        $stmt_cantidad->close();

        // Obtener el precio
        $stmt_precio = $con->prepare("SELECT precio FROM producto WHERE id_producto = ?");
        $stmt_precio->bind_param("i", $id_producto);
        $stmt_precio->execute();
        $stmt_precio->bind_result($precio);
        if (!$stmt_precio->fetch()) {
            echo json_encode([
                'estado' => 'Fallido',
                'mensaje' => "El producto no existe en el pedido."
            ]);
            $stmt_precio->close();
            $con->close();
            return;
        }
        $stmt_precio->close();
    
        // Calcular el costo del producto a eliminar
        $costoProducto = $precio * $cantidad;
    
        // Eliminar el producto del detalle del pedido
        $stmt_eliminarProducto = $con->prepare("DELETE FROM detalle_pedido WHERE id_pedido = ? AND id_producto = ?");
        $stmt_eliminarProducto->bind_param("ii", $id_pedido, $id_producto);
        if (!$stmt_eliminarProducto->execute()) {
            echo json_encode([
                'estado' => 'Fallido',
                'mensaje' => "Error al eliminar el producto del pedido: " . $stmt_eliminarProducto->error
            ]);
            $stmt_eliminarProducto->close();
            $con->close();
            return;
        }
        $stmt_eliminarProducto->close();
    
        // Actualizar el total del pedido en la tabla `pedido`
        $stmt_actualizarTotal = $con->prepare("UPDATE pedido SET total_pedido = total_pedido - ? WHERE id_pedido = ?");
        $stmt_actualizarTotal->bind_param("di", $costoProducto, $id_pedido);
        if (!$stmt_actualizarTotal->execute()) {
            echo json_encode([
                'estado' => 'Fallido',
                'mensaje' => "Error al actualizar el total del pedido: " . $stmt_actualizarTotal->error
            ]);
        }
        $stmt_actualizarTotal->close();
    
        // Cerrar la conexión con la base de datos
        $con->close();
    }
    
    

    public static function crearPedido($id_usuario, $array_productos) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();  // Inicia la sesión si no está iniciada
        }

        // Crear la conexión con la base de datos
        $con = DataBase::connect();

        // Inicializar el total del pedido
        $totalPedido = 0;

        // Recorrer el array de IDs de productos
        foreach ($array_productos as $id_producto => $cantidad) {
            // Preparar la consulta para obtener el precio de cada producto
            $stmt_pedido = $con->prepare("SELECT precio FROM producto WHERE id_producto = ?");
            $stmt_pedido->bind_param("i", $id_producto); // "i" indica que el parámetro es un entero
            $stmt_pedido->execute();
            
            // Obtener el resultado de la consulta
            $stmt_pedido->bind_result($precio);
            $stmt_pedido->fetch(); // Ejecutamos la obtención del precio
            
            // Sumar el precio multiplicado por la cantidad al total
            $totalPedido += $precio * $cantidad;
            
            // Cerrar el statement
            $stmt_pedido->close();
        }

        // Definir la fecha actual
        $fecha = date("Y-m-d H:i:s");
        
        // Insertar pedido en la base de datos
        $stmt_pedido = $con->prepare("INSERT INTO pedido (Fecha, id_usuario, total_pedido) VALUES (?, ?, ?)");
        $stmt_pedido->bind_param("sid", $fecha, $id_usuario, $totalPedido);
        
        // Verificar si la inserción del pedido fue exitosa
        if ($stmt_pedido->execute()) {
            // Obtener el ID del pedido recién insertado
            $id_pedido = $con->insert_id;

            // Verificar si se obtuvo el ID del pedido correctamente
            if ($id_pedido) {
                // Insertar los detalles del pedido
                foreach ($array_productos as $id_producto => $cantidad) {
                    // Preparar la consulta para insertar el detalle del producto
                    $stmt_detalleProducto = $con->prepare("INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad) VALUES (?, ?, ?)");
                    $stmt_detalleProducto->bind_param("iid", $id_pedido, $id_producto, $cantidad);

                    // Ejecutar la inserción de los detalles del producto
                    if (!$stmt_detalleProducto->execute()) {
                        echo json_encode([
                            'estado' => 'Fallido',
                            'mensaje' => "Error al insertar el detalle del pedido para el producto ID: $id_producto."
                        ]);
                        $stmt_detalleProducto->close();
                        continue; // Pasar al siguiente producto en caso de error
                    }
                    $stmt_detalleProducto->close(); // Cerrar el statement después de usarlo
                }

                // Responder con el estado del pedido
                echo json_encode([
                    'estado' => 'Exito',
                    'mensaje' => "Pedido agregado con ID: " . $id_pedido
                ]);
                UsuarioDAO::agregarLog($_SESSION["usuario"]["correo"], $_SESSION["usuario"]["nombre"] . " " . $_SESSION["usuario"]["apellidos"] . " ha tramitado un pedido.");
            } else {
                echo json_encode([
                    'estado' => 'Fallido',
                    'mensaje' => "No se obtuvo un ID válido del pedido."
                ]);
            }
        } else {
            echo json_encode([
                'estado' => 'Fallido',
                'mensaje' => "Error al insertar el pedido: " . $stmt_pedido->error
            ]);
        }

        // Cerrar la conexión a la base de datos
        $con->close();
    }

    public static function agregarProductoPedido($id_pedido, $id_producto, $cantidad) {
        // Crear la conexión con la base de datos
        $con = DataBase::connect();
    
        // Verificar si el pedido existe
        $stmt_verificarPedido = $con->prepare("SELECT id_pedido FROM pedido WHERE id_pedido = ?");
        $stmt_verificarPedido->bind_param("i", $id_pedido);
        $stmt_verificarPedido->execute();
        $stmt_verificarPedido->store_result();
    
        if ($stmt_verificarPedido->num_rows === 0) {
            echo json_encode([
                'estado' => 'Fallido',
                'mensaje' => "El pedido con ID: $id_pedido no existe."
            ]);
            $stmt_verificarPedido->close();
            $con->close();
            return;
        }
        $stmt_verificarPedido->close();
    
        // Verificar si el producto ya está en el pedido
        $stmt_verificarProducto = $con->prepare("SELECT id_producto, cantidad FROM detalle_pedido WHERE id_pedido = ? AND id_producto = ?");
        $stmt_verificarProducto->bind_param("ii", $id_pedido, $id_producto);
        $stmt_verificarProducto->execute();
        $stmt_verificarProducto->store_result();
    
        if ($stmt_verificarProducto->num_rows > 0) {
            // Si el producto ya está en el pedido, actualizar la cantidad
            $stmt_verificarProducto->bind_result($id_producto_existente, $cantidad_existente);
            $stmt_verificarProducto->fetch();
            $nuevaCantidad = $cantidad_existente + $cantidad;
    
            $stmt_actualizarCantidad = $con->prepare("UPDATE detalle_pedido SET cantidad = ? WHERE id_pedido = ? AND id_producto = ?");
            $stmt_actualizarCantidad->bind_param("iii", $nuevaCantidad, $id_pedido, $id_producto);
            if (!$stmt_actualizarCantidad->execute()) {
                echo json_encode([
                    'estado' => 'Fallido',
                    'mensaje' => "Error al actualizar la cantidad del producto en el pedido: " . $stmt_actualizarCantidad->error
                ]);
                $stmt_actualizarCantidad->close();
                $con->close();
                return;
            }
            $stmt_actualizarCantidad->close();
    
            // Obtener el precio del producto
            $stmt_precioProducto = $con->prepare("SELECT precio FROM producto WHERE id_producto = ?");
            $stmt_precioProducto->bind_param("i", $id_producto);
            $stmt_precioProducto->execute();
            $stmt_precioProducto->bind_result($precio);
            if (!$stmt_precioProducto->fetch()) {
                echo json_encode([
                    'estado' => 'Fallido',
                    'mensaje' => "El producto con ID: $id_producto no existe."
                ]);
                $stmt_precioProducto->close();
                $con->close();
                return;
            }
            $stmt_precioProducto->close();
    
            // Calcular el costo total adicional
            $costoProducto = $precio * $cantidad;
    
            // Actualizar el total del pedido en la tabla `pedido`
            $stmt_actualizarTotal = $con->prepare("UPDATE pedido SET total_pedido = total_pedido + ? WHERE id_pedido = ?");
            $stmt_actualizarTotal->bind_param("di", $costoProducto, $id_pedido);
            if (!$stmt_actualizarTotal->execute()) {
                echo json_encode([
                    'estado' => 'Fallido',
                    'mensaje' => "Error al actualizar el total del pedido: " . $stmt_actualizarTotal->error
                ]);
                $stmt_actualizarTotal->close();
                $con->close();
                return;
            }
            $stmt_actualizarTotal->close();
    
        } else {
            // Si el producto no está en el pedido, agregarlo normalmente
            // Obtener el precio del producto
            $stmt_precioProducto = $con->prepare("SELECT precio FROM producto WHERE id_producto = ?");
            $stmt_precioProducto->bind_param("i", $id_producto);
            $stmt_precioProducto->execute();
            $stmt_precioProducto->bind_result($precio);
            if (!$stmt_precioProducto->fetch()) {
                echo json_encode([
                    'estado' => 'Fallido',
                    'mensaje' => "El producto con ID: $id_producto no existe."
                ]);
                $stmt_precioProducto->close();
                $con->close();
                return;
            }
            $stmt_precioProducto->close();
    
            // Calcular el costo total del producto agregado
            $costoProducto = $precio * $cantidad;
    
            // Insertar el detalle del producto en la tabla `detalle_pedido`
            $stmt_insertarDetalle = $con->prepare("INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad) VALUES (?, ?, ?)");
            $stmt_insertarDetalle->bind_param("iid", $id_pedido, $id_producto, $cantidad);
            if (!$stmt_insertarDetalle->execute()) {
                echo json_encode([
                    'estado' => 'Fallido',
                    'mensaje' => "Error al agregar el producto al pedido: " . $stmt_insertarDetalle->error
                ]);
                $stmt_insertarDetalle->close();
                $con->close();
                return;
            }
            $stmt_insertarDetalle->close();
    
            // Actualizar el total del pedido en la tabla `pedido`
            $stmt_actualizarTotal = $con->prepare("UPDATE pedido SET total_pedido = total_pedido + ? WHERE id_pedido = ?");
            $stmt_actualizarTotal->bind_param("di", $costoProducto, $id_pedido);
            if (!$stmt_actualizarTotal->execute()) {
                echo json_encode([
                    'estado' => 'Fallido',
                    'mensaje' => "Error al actualizar el total del pedido: " . $stmt_actualizarTotal->error
                ]);
                $stmt_actualizarTotal->close();
                $con->close();
                return;
            }
            $stmt_actualizarTotal->close();
        }
    
        // Cerrar la conexión con la base de datos
        $con->close();
    }
    

    public static function modificarIdUsuario($id_pedido, $id_usuario) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $con = DataBase::connect();

        // Actualizar el ID del usuario en la base de datos
        $stmt = $con->prepare("UPDATE pedido SET id_usuario = ? WHERE id_pedido = ?");
        $stmt->bind_param("ii", $id_usuario, $id_pedido);
        $stmt->execute();

        echo json_encode([
            'estado' => 'Exito',
            'mensaje' => "El ID del usuario se ha modificado correctamente."
        ]);

        UsuarioDAO::agregarLog(
            $_SESSION["usuario"]["correo"],
            "El administrador ha modificado el ID del usuario para el pedido con ID $id_pedido."
        );

        $stmt->close();
        $con->close();
    }

    public static function modificarFecha($id_pedido, $fecha) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $con = DataBase::connect();

        // Actualizar la fecha
        $stmt = $con->prepare("UPDATE pedido SET fecha = ? WHERE id_pedido = ?");
        $stmt->bind_param("si", $fecha, $id_pedido);
        $stmt->execute();

        echo json_encode([
            'estado' => 'Exito',
            'mensaje' => "La fecha del pedido se ha modificado correctamente."
        ]);

        UsuarioDAO::agregarLog(
            $_SESSION["usuario"]["correo"],
            "El administrador ha modificado la fecha del pedido con ID $id_pedido."
        );

        $stmt->close();
        $con->close();
    }

    public static function modificarCantidadProducto($id_producto, $cantidad) {
        $con = DataBase::connect();

        // Preparar la consulta para obtener la cantidad actual del producto
        $stmt = $con->prepare("SELECT cantidad FROM detalle_pedido WHERE id_producto = ?");
        $stmt->bind_param("i", $id_producto);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar si se encontró el producto
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $cantidad_actual = $row['cantidad'];

            // Comparar la cantidad actual con la nueva cantidad
            if ($cantidad_actual === $cantidad) {
                // Cerrar la conexión y retornar el mensaje
                $stmt->close();
                $con->close();
                echo json_encode([
                    'estado' => 'Fallido',
                    'mensaje' => "La cantidad proporcionada es la misma que la actual. No se realizaron cambios."
                ]);
                return; // Salir sin realizar cambios
            }
        } else {
            // Producto no encontrado
            $stmt->close();
            $con->close();
            echo json_encode([
                'estado' => 'Fallido',
                'mensaje' => "Producto no encontrado."
            ]);
            return;
        }

        // Si las cantidades son diferentes, proceder a actualizar
        $stmt->close(); // Cerrar la declaración anterior

        // Actualizar la cantidad en la base de datos
        $stmt = $con->prepare("UPDATE detalle_pedido SET cantidad = ? WHERE id_producto = ?");
        $stmt->bind_param("ii", $cantidad, $id_producto);
        
        if ($stmt->execute()) {
            // Modificación exitosa
            echo json_encode([
                'estado' => 'Exito',
                'mensaje' => "La cantidad del producto se ha modificado correctamente."
            ]);
        } else {
            // Error al modificar
            echo json_encode([
                'estado' => 'Fallido',
                'mensaje' => "Error al modificar la cantidad del producto."
            ]);
        }

        // Cerrar la conexión
        $stmt->close();
        $con->close();
    }
    

    // Productos
    public static function obtenerProductos(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT 
                producto.*, 
                (producto.precio * (oferta.porcentaje / 100)) as precio_oferta,
                oferta.porcentaje
            FROM producto
            LEFT JOIN oferta oferta ON producto.id_oferta = oferta.id_oferta");

        $stmt->execute();
        $result = $stmt->get_result();

        $productos = [];

        while($producto = $result->fetch_object("ProductoGeneral")) {
            $productos[] = $producto;
        }
        

        $con->close();

        return $productos;
    }
    
    public static function obtenerDetallePedido($id_pedido, $id_producto){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT cantidad FROM detalle_pedido WHERE id_pedido = ? AND id_producto = ?;");
        $stmt->bind_param("ii", $id_pedido, $id_producto);

        $stmt->execute();
        $result = $stmt->get_result();

        $productos = [];

        while($producto = $result->fetch_object("ProductoGeneral")) {
            $productos[] = $producto;
        }
        

        $con->close();

        return $productos;
    }

    // Usuarios

    //  Obtener
    public static function obtenerUsuarios(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM usuario");

        $stmt->execute();
        $result = $stmt->get_result();

        $usuarios = [];

        while($usuario = $result->fetch_object("UsuarioDetalle")) {
            $usuarios[] = $usuario;
        }

        $con->close();

        return $usuarios;
    }
}

?>