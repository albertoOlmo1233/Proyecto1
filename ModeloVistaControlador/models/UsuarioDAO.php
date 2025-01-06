<?php 
include_once("models/Producto.php");
include_once("models/ProductoDetalle.php");
include_once("models/Usuario.php");
include_once("config/dataBase.php");
include_once("models/UsuarioDetalle.php");

class UsuarioDAO {
public static function getAll(){
    $con = DataBase::connect();
    $stmt = $con->prepare("SELECT * FROM usuario");

    $stmt->execute();
    $result = $stmt->get_result();

    $usuarios = [];

    while($producto = $result->fetch_object("UsuarioDetalle")) {
        $usuarios [] = $usuario;
    }

    $con->close();

    return $usuarios ;
}

public static function getUsuario($id){
    $con = DataBase::connect();
    $stmt = $con->prepare("SELECT * FROM usuario WHERE id_usuario = ?");
    $stmt->bind_param("i",$id);

    $stmt->execute();
    $result = $stmt->get_result();

    $detalleUsuario = null;

    while($usuario = $result->fetch_object("UsuarioDetalle")) {
        $detalleUsuario = $usuario;
    }

    $con->close();

    return $detalleUsuario;
}

// Iniciar sesion
public static function iniciarSesion($identificador,$contraseña){
    $con = DataBase::connect();
    $stmt = $con->prepare("SELECT * FROM usuario WHERE correo=?");
    $stmt->bind_param("s",$identificador);
    $stmt->execute();

    // Obtenemo el resultado de la query
    $result = $stmt->get_result();
    $usuario = $result->fetch_object("UsuarioDetalle");
    
    if($usuario){
        if (password_verify($contraseña, $usuario->getContraseña())) {
            // Iniciamos la sesión
            session_start();

            // Guardamos el ID y el nombre del usuario en la sesión
            $_SESSION["usuario"] = [
                "id" => $usuario->getID(),
                "correo" => $usuario->getCorreo(),
                "nombre" => $usuario->getNombre(),
                "apellidos" => $usuario->getApellidos(),
                "direccion" => $usuario->getDireccion(),
                "rol" =>  $usuario->getRol()
            ];
            $_SESSION['confirmacion'] = "Inicio de sesión exitoso. Serás redirigido en breve.";
            self::agregarLog($_SESSION["usuario"]["correo"],$_SESSION["usuario"]["nombre"] . " " . $_SESSION["usuario"]["apellidos"] . " ha iniciado sesión.");
        }else {
            // La contraseña no existe
            $_SESSION['error'] = "La contraseña es incorrecta, pruebe de nuevo.";
            self::agregarLog($usuario->getCorreo(), $usuario->getNombre() . " " . $usuario->getApellidos() . " ha intentado iniciar sesión");
        }
        $view="views/login/Login.php";
        include_once 'views/main.php';
    } else {
        // El correo no existe
        $_SESSION['error'] = "No hay ninguna cuenta asociada con este correo.";
        $view="views/login/Login.php";
        include_once 'views/main.php';
    }
    $con->close();
}

public static function cerrarSesion() {
    // Iniciar la sesión
    session_start();
    if($_SESSION["usuario"]["rol"] === "Admin") {
        header("Location: ?controller=user");
    } else {
        header("Location: ?controller=producto");
    }
    self::agregarLog($_SESSION["usuario"]["correo"],$_SESSION["usuario"]["nombre"] . " " . $_SESSION["usuario"]["apellidos"] . " ha cerrado sesion.");
    unset($_SESSION['usuario']);
    exit();
}

// Parte mixta Usuario / Administrador

public static function registroSesion($nombre, $apellidos, $correo, $password, $direccion = null) {
    session_start();

     // Validación de la contraseña (menos de 8 o más de 18 caracteres)
     if (strlen($password) < 8 || strlen($password) > 18) {
        $mensaje = (strlen($password) < 8) ? 'La contraseña no puede tener menos de 8 caracteres.' : 'La contraseña no puede tener más de 18 caracteres.';
        if ($_SESSION['usuario']['rol'] === "Admin") {
            echo json_encode(['estado' => 'Fallido', 'mensaje' => $mensaje]);
        } else {
            $_SESSION['error'] = $mensaje;
            $view = "views/login/Register.php";
            include_once 'views/main.php';
            exit();
        }
    }

    // Normalizar nombres y correo
    $nombre = ucfirst(strtolower($nombre));
    $apellidos = ucfirst(strtolower($apellidos));
    $correo = strtolower($correo);

    // Conexión a la base de datos
    $con = DataBase::connect();

    // Verificar si el correo ya está registrado
    $stmt = $con->prepare("SELECT * FROM usuario WHERE correo=?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_object();

    // Si el usuario existe, retornar error
    if ($usuario) {
        if ($_SESSION['usuario']['rol'] === "Admin") {
            echo json_encode(['estado' => 'Fallido', 'mensaje' => 'El correo ya está registrado.']);
        } else {
            $_SESSION['error'] = "Ya existe una cuenta con este correo asociado.";
            $view = "views/login/Register.php";
            include_once 'views/main.php';
            exit();
        }
    }
    
    // Si el usuario es administrador y se ha pasado un valor de dirección, lo usamos
    if ($direccion === null && $_SESSION['usuario']['rol'] === "Admin") {
        // Si no se pasa dirección, no se puede insertar. Dependiendo de tu lógica de negocio, podrías decidir qué hacer con ello.
        $direccion = ''; // O simplemente no insertar la dirección (dejarla vacía)
    }

    // Crear nueva contraseña encriptada
    $passwordEncriptado = password_hash($password, PASSWORD_DEFAULT);

    // Insertar nuevo usuario
    $stmt2 = $con->prepare("INSERT INTO usuario (nombre, apellidos, correo, contraseña, rol, direccion) VALUES (?, ?, ?, ?, 'Cliente', ?)");
    $stmt2->bind_param("sssss", $nombre, $apellidos, $correo, $passwordEncriptado, $direccion);

    if ($stmt2->execute()) {
        $mensaje = "";
        if ($_SESSION['usuario']['rol'] === "Admin") {
            echo json_encode(['estado' => 'Exito', 'mensaje' => 'Usuario creado exitosamente.']);
            $mensaje = "El administrador ha creado un usuario";
        } else {
            $_SESSION['confirmacion'] = "Registro de sesión exitoso. Serás redirigido en breve.";
            $view = "views/login/Register.php";
            include_once 'views/main.php';
            $mensaje = "$nombre $apellidos se ha registrado";
        }
        // Log de éxito
        self::agregarLog($correo, $mensaje);
    } else {
        // Error al registrar el usuario
        if ($_SESSION['usuario']['rol'] === "Admin") {
            echo json_encode(['estado' => 'Fallido', 'mensaje' => 'Error al registrar el usuario.']);
        } else {
            $_SESSION['error'] = "Ha habido un error en el servidor. Intenta de nuevo.";
            $view = "views/login/Register.php";
            include_once 'views/main.php';
        }
    }

    // Cerrar conexiones
    $stmt->close();
    $stmt2->close();
    $con->close();
}

public static function agregarLog($correo,$mensaje) {
    $correo_usuario = $correo ?? null;
    $mensaje_usuario = $mensaje ?? null;

    // Conexión a la base de datos
    $con = DataBase::connect();
    $stmt = $con->prepare("INSERT INTO log (correo, mensaje) VALUES (?, ?)");
    $stmt->bind_param("ss", $correo_usuario, $mensaje_usuario);
    $stmt->execute();
}

public static function comprobarSesion(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if(!isset($_SESSION["usuario"])){
        header("Location: ?controller=user");
    }
    
}

public static function esAdmin(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if($_SESSION["usuario"]['rol'] && $_SESSION["usuario"]['rol'] === 'Cliente'){
        header("Location: ?controller=user");
    }
    
}

public static function tramitar_pedido($totalPedido) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();  // Inicia la sesión si no está iniciada
    }

    // Verificar que el usuario está logueado
    if (isset($_SESSION['usuario']['id'])) {
        $id_usuario = $_SESSION['usuario']['id'];
        if (empty($_SESSION['usuario']['direccion'])) {
            $_SESSION['error'] = "Necesitas configurar una direccion a la que enviar tu pedido.";
            header("Location: ?controller=user&action=carrito");
            exit();
        }else {
            // Crear la conexión con la base de datos
            $con = DataBase::connect();

            // Definir la fecha actual
            $fecha = date("Y-m-d H:i:s");

            // Insertar pedido en la base de datos
            $stmt_pedido = $con->prepare("INSERT INTO pedido (Fecha, id_usuario, total_pedido) VALUES (?,?,?)");
            $stmt_pedido->bind_param("sid", $fecha, $id_usuario, $totalPedido);


            // Verificar si la inserción del pedido fue exitosa
            if ($stmt_pedido->execute()) {
                // Obtener el ID del pedido recién insertado
                $id_pedido = $con->insert_id;

                // Verificar si se obtuvo el ID del pedido correctamente
                if ($id_pedido) {
                    echo "Pedido agregado con ID: " . $id_pedido;
                } else {
                    echo "Error: No se obtuvo un ID válido del pedido.";
                    $con->close();
                    return; // Detener la ejecución si no se obtuvo el ID
                }
            } else {
                echo "Error al insertar el pedido: " . $stmt_pedido->error;
                $con->close();
                return; // Detener la ejecución si hay un error al insertar el pedido
            }

            // Verificar si el carrito del usuario tiene productos
            if (isset($_SESSION['carrito'][$id_usuario]) && !empty($_SESSION['carrito'][$id_usuario])) {
                // Insertar los detalles del pedido
                foreach ($_SESSION['carrito'][$id_usuario] as $id_producto => $pedido) {
                    $producto = $pedido['producto'];
                    $id_producto = $producto->getID();
                    $cantidad = $pedido['cantidad'];

                    // Asegurarse de que $id_pedido sea válido antes de insertar en detalle_producto
                    if ($id_pedido) {
                        // Preparar la consulta para insertar el detalle del producto
                        $stmt_detalleProducto = $con->prepare("INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad) VALUES (?, ?, ?)");
                        $stmt_detalleProducto->bind_param("iid", $id_pedido, $id_producto, $cantidad);

                        // Ejecutar la inserción de los detalles del producto
                        if ($stmt_detalleProducto->execute()) {
                            $_SESSION['confirmacion'] = "Pedido tramitado correctamente, gracias por contar con nosotros, para comprar tu comida!";
                        } else {
                            $_SESSION['error'] = "Error al insertar el detalle del pedido, contacta con un administrador";
                        }
                    } else {
                        echo "Error: El ID del pedido es nulo, no se puede insertar el detalle del pedido.<br>";
                    }
                }
                self::agregarLog($_SESSION["usuario"]["correo"],$_SESSION["usuario"]["nombre"] . " " . $_SESSION["usuario"]["apellidos"] . " ha tramitado un pedido.");
            }

            unset($_SESSION['carrito'][$id_usuario]);
            // Redirigir a la página que muestra la confirmación de compra (confirmacion)
            header("Location: ?controller=user&action=carrito");
            exit();
            // Cerrar la conexión
            $con->close();
        }

    } else {
        echo "No hay datos de usuario en la sesión.";
    }
}

// Usuario - Administrador

public static function modificarNombre($id, $nombre) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $con = DataBase::connect();
    
    // Validar existencia previa
    $stmt = $con->prepare("SELECT nombre FROM usuario WHERE id_usuario = ?;");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultNombre = $stmt->get_result();
    $row = $resultNombre->fetch_assoc();
    $nombre_resultado = $row['nombre'] ?? null;

    

    // Cerrar sentencia SELECT
    $stmt->close();

    // Verificar acción desde GET
    $action = $_GET['action'] ?? null;

    // Validar rol de usuario y acción
    if (isset($_SESSION['usuario']['rol']) && $_SESSION['usuario']['rol'] === "Admin" && $action !== "cuenta") {
        if ($nombre_resultado !== $nombre) {
            $stmt1 = $con->prepare("UPDATE usuario SET nombre = ? WHERE id_usuario = ?;");
            $stmt1->bind_param("si", $nombre, $id);

            
            if ($stmt1->execute()) {
                echo json_encode([
                    "estado" => "Exito",
                    "mensaje" => "El nombre del usuario se actualizó con éxito."
                ]);
            } else {
                echo json_encode([
                    "estado" => "Fallido",
                    "mensaje" => "Ha habido un error al actualizar el nombre."
                ]);
            }
            // Cerrar sentencia UPDATE
            $stmt1->close();
        } else {
            echo json_encode([
                "estado" => "Fallido",
                "mensaje" => "El nombre de usuario no puede ser igual al que tiene el usuario."
            ]);
        }
    } else {
        if ($nombre_resultado !== $nombre) {
            $stmt1 = $con->prepare("UPDATE usuario SET nombre = ? WHERE id_usuario = ?;");
            $stmt1->bind_param("si", $nombre, $id);
            if ($stmt1->execute()) {
                $_SESSION['confirmacion'] = "El nombre se actualizó correctamente.";
                $_SESSION['usuario']['nombre'] = $nombre;
                $view = "views/cuenta/Cuenta.php";
                include_once 'views/main.php';
            }
            // Cerrar sentencia UPDATE
            $stmt1->close();
        } else {
            $_SESSION['error'] = "El nombre de usuario no puede ser igual al que tienes.";
            $view = "views/cuenta/Cuenta.php";
            include_once 'views/main.php';
        }
    }

    // Cerrar la conexión a la base de datos
    $con->close();
}


public static function modificarApellidos($id, $apellidos) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $con = DataBase::connect();
    
    // Validar existencia previa
    $stmt = $con->prepare("SELECT apellidos FROM usuario WHERE id_usuario = ?;");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultApellidos = $stmt->get_result();
    $row = $resultApellidos->fetch_assoc();
    $apellidos_resultado = $row['apellidos'] ?? null;

    // Cerrar sentencia SELECT
    $stmt->close();

    // Verificar acción desde GET
    $action = $_GET['action'] ?? null;

    // Validar rol de usuario y acción
    if (isset($_SESSION['usuario']['rol']) && $_SESSION['usuario']['rol'] === "Admin" && $action !== "cuenta") {
        if ($apellidos_resultado !== $apellidos) {
            $stmt1 = $con->prepare("UPDATE usuario SET apellidos = ? WHERE id_usuario = ?;");
            $stmt1->bind_param("si", $apellidos, $id);
            
            if ($stmt1->execute()) {
                echo json_encode([
                    "estado" => "Exito",
                    "mensaje" => "Los apellidos del usuario se actualizaron con éxito."
                ]);
            } else {
                echo json_encode([
                    "estado" => "Fallido",
                    "mensaje" => "Ha habido un error al actualizar los apellidos."
                ]);
            }
            // Cerrar sentencia UPDATE
            $stmt1->close();
        } else {
            echo json_encode([
                "estado" => "Fallido",
                "mensaje" => "El apellido de usuario no puede ser igual al que tiene el usuario."
            ]);
        }
    } else {
        if ($apellidos_resultado !== $apellidos) {
            $stmt1 = $con->prepare("UPDATE usuario SET apellidos = ? WHERE id_usuario = ?;");
            $stmt1->bind_param("si", $apellidos, $id);
            if ($stmt1->execute()) {
                $_SESSION['confirmacion'] = "Los apellidos se actualizaron correctamente.";
                $_SESSION['usuario']['apellidos'] = $apellidos;
                $view = "views/cuenta/Cuenta.php";
                include_once 'views/main.php';
            }
            // Cerrar sentencia UPDATE
            $stmt1->close();
        } else {
            $_SESSION['error'] = "El apellido de usuario no puede ser igual al que tienes.";
            $view = "views/cuenta/Cuenta.php";
            include_once 'views/main.php';
        }
    }

    // Cerrar la conexión a la base de datos
    $con->close();
}

public static function modificarContraseña($id, $contraseña) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $con = DataBase::connect();
    
    // Establecer la codificación utf8mb4 para la conexión
    $con->set_charset("utf8mb4");
    
    // Validar existencia previa
    $stmt = $con->prepare("SELECT password FROM usuario WHERE id_usuario = ?;");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultContraseña = $stmt->get_result();
    $row = $resultContraseña->fetch_assoc();
    $contraseña_resultado = $row['password'] ?? null;

    // Cerrar sentencia SELECT
    $stmt->close();

    // Verificar acción desde GET
    $action = $_GET['action'] ?? null;

    // Validar rol de usuario y acción
    if (isset($_SESSION['usuario']['rol']) && $_SESSION['usuario']['rol'] === "Admin" && $action !== "cuenta") {
        // Verificar si la contraseña no es igual a la actual
        if ($contraseña_resultado && !password_verify($contraseña, $contraseña_resultado)) {
            // Encriptar nueva contraseña
            $passwordEncriptado = password_hash($contraseña, PASSWORD_BCRYPT);
            $stmt1 = $con->prepare("UPDATE usuario SET contraseña = ? WHERE id_usuario = ?;");
            $stmt1->bind_param("si", $passwordEncriptado, $id);
            
            if ($stmt1->execute()) {
                echo json_encode([
                    "estado" => "Exito",
                    "mensaje" => "La contraseña del usuario se actualizó con éxito."
                ]);
            } 
            // Cerrar sentencia UPDATE
            $stmt1->close();
        } else {
            echo json_encode([
                "estado" => "Fallido",
                "mensaje" => "La contraseña no puede ser igual a la actual."
            ]);
        }
    } else {
        // Verificar si la contraseña no es igual a la actual
        if ($contraseña_resultado && !password_verify($contraseña, $contraseña_resultado)) {
            // Encriptar nueva contraseña
            $passwordEncriptado = password_hash($contraseña, PASSWORD_BCRYPT);
            $stmt1 = $con->prepare("UPDATE usuario SET password = ? WHERE id_usuario = ?;");
            $stmt1->bind_param("si", $passwordEncriptado, $id);
            if ($stmt1->execute()) {
                $_SESSION['confirmacion'] = "La contraseña se actualizó correctamente.";
                $view = "views/cuenta/Cuenta.php";
                include_once 'views/main.php';
            }
            // Cerrar sentencia UPDATE
            $stmt1->close();
        } else {
            $_SESSION['error'] = "La contraseña no puede ser igual a la anterior.";
            $view = "views/cuenta/Cuenta.php";
            include_once 'views/main.php';
        }
    }

    // Cerrar la conexión a la base de datos
    $con->close();
}




public static function modificarDireccion($id, $direccion) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $con = DataBase::connect();
    
    // Validar existencia previa
    $stmt = $con->prepare("SELECT direccion FROM usuario WHERE id_usuario = ?;");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultDireccion = $stmt->get_result();
    $row = $resultDireccion->fetch_assoc();
    $direccion_resultado = $row['direccion'] ?? null;

    // Cerrar sentencia SELECT
    $stmt->close();

    // Verificar acción desde GET
    $action = $_GET['action'] ?? null;

    // Validar rol de usuario y acción
    if (isset($_SESSION['usuario']['rol']) && $_SESSION['usuario']['rol'] === "Admin" && $action !== "cuenta") {
        if ($direccion_resultado !== $direccion) {
            $stmt1 = $con->prepare("UPDATE usuario SET direccion = ? WHERE id_usuario = ?;");
            $stmt1->bind_param("si", $direccion, $id);
            
            if ($stmt1->execute()) {
                echo json_encode([
                    "estado" => "Exito",
                    "mensaje" => "La dirección del usuario se actualizó con éxito."
                ]);
            } else {
                echo json_encode([
                    "estado" => "Fallido",
                    "mensaje" => "Ha habido un error al actualizar la dirección."
                ]);
            }
            // Cerrar sentencia UPDATE
            $stmt1->close();
        } else {
            echo json_encode([
                "estado" => "Fallido",
                "mensaje" => "La dirección no puede ser igual a la actual."
            ]);
        }
    } else {
        if ($direccion_resultado !== $direccion) {
            $stmt1 = $con->prepare("UPDATE usuario SET direccion = ? WHERE id_usuario = ?;");
            $stmt1->bind_param("si", $direccion, $id);
            if ($stmt1->execute()) {
                $_SESSION['confirmacion'] = "La dirección se actualizó correctamente.";
                $_SESSION['usuario']['direccion'] = $direccion;
                $view = "views/cuenta/Cuenta.php";
                include_once 'views/main.php';
            } else {
                $_SESSION['error'] = "Error al actualizar la dirección.";
                $view = "views/cuenta/Cuenta.php";
                include_once 'views/main.php';
            }
            // Cerrar sentencia UPDATE
            $stmt1->close();
        } else {
            $_SESSION['error'] = "La dirección no puede ser igual a la anterior.";
            $view = "views/cuenta/Cuenta.php";
            include_once 'views/main.php';
        }
    }

    // Cerrar la conexión a la base de datos
    $con->close();
}

public static function modificarCorreo($id, $correo) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $con = DataBase::connect();
    
    // Validar existencia previa
    $stmt = $con->prepare("SELECT correo FROM usuario WHERE id_usuario=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultCorreo = $stmt->get_result();
    $row = $resultCorreo->fetch_array();
    $correo_resultado = $row['correo'];

    // Validar correo existente
    if ($correo_resultado !== $correo) {
        $stmt1 = $con->prepare("UPDATE usuario SET correo = ? WHERE id_usuario = ?;");
        $stmt1->bind_param("si", $correo, $id);
        $stmt1->execute();
        return true; // Modificación exitosa
    }
    
    return false; // No se realizó la modificación
}


//  Eliminar
public static function eliminarUsuario($id) {
    $con = DataBase::connect();

    // Eliminar los detalles de pedido asociados con los pedidos del usuario
    $detalles_pedidos = $con->prepare(
        "DELETE detalle_pedido
        FROM detalle_pedido
        INNER JOIN pedido ON detalle_pedido.id_pedido = pedido.id_pedido
        WHERE pedido.id_usuario = ?;"
    );

    $detalles_pedidos->bind_param("i", $id);
    $detalles_pedidos->execute();
    $detalles_pedidos->close(); // Cierra el statement después de usarlo

    // Eliminar los pedidos del usuario
    $pedidos = $con->prepare("DELETE FROM pedido WHERE id_usuario = ?");
    $pedidos->bind_param("i", $id);
    $pedidos->execute();
    $pedidos->close(); // Cierra el statement después de usarlo

    // Eliminar el usuario
    $usuario = $con->prepare("DELETE FROM usuario WHERE id_usuario = ?");
    $usuario->bind_param("i", $id);
    $usuario->execute();
    
    // Reiniciar el AUTO_INCREMENT de las tablas relacionadas
    // Para que cuando volvamos a crear un usuario, el ID se reinicie y empiece desde el ultimo ID existente
    $queries = [
        "ALTER TABLE detalle_pedido AUTO_INCREMENT = 1;",
        "ALTER TABLE pedido AUTO_INCREMENT = 1;",
        "ALTER TABLE usuario AUTO_INCREMENT = 1;"
    ];

    // Ejecutar todas las consultas de reinicio del AUTO_INCREMENT
    foreach ($queries as $query) {
        $autoIncrement = $con->prepare($query);
        $autoIncrement->execute();
    }

    // Confirmar la transacción si todo salió bien
    $con->commit();

    $mensaje = "";
    if ($usuario->affected_rows > 0) {
        $mensaje = "Usuario eliminado correctamente.";
    } else {
        $mensaje = "No se encontró ningún usuario con el ID proporcionado.";
    }

    // Cierra el statement para el usuario
    $usuario->close();

    // Cierra la conexión a la base de datos
    $con->close();
    
    return $mensaje;
}


}

?>