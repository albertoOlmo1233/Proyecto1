<?php 

include_once("config/dataBase.php");
include_once("models/ProductoDAO.php");
include_once("models/UsuarioDAO.php");
include_once("models/ProductoGeneral.php");
include_once("models/ProductoDetalle.php");
include_once("models/admin/AdminDAO.php");
include_once("models/admin/Logs/LogDetalle.php");


class apiController {
    // public function index() {
    //     $view="views/admin/panel/panel.php";
    //     include_once 'views/main.php';
    // }

    // Agregar LOG desde el admin
    public static function agregarLog() {
        session_start();
        UsuarioDAO::agregarLog($_SESSION['usuario']['correo'], $_SESSION['usuario']['nombre'] . ' ' . $_SESSION['usuario']['apellidos'] . ' se ha registrado.');
    
    }

    // Usuarios

    public function getUsuarios() {  // Esta funcion si recibe un ID pasara la informacion de ese usuario, si no recibe todos los usuarios
        $users = AdminDAO::obtenerUsuarios();

        if (!$users) {
            http_response_code(500); // Indicar error en el servidor
            echo json_encode([
                'estado' => 'Fallido',
                'data' => 'No se pudo obtener usuarios'
            ]);
            return;
        }

        if (isset($_GET['id'])) { // Si se pasa un ID específico para buscar un producto
            $id = $_GET['id'];
            $usuarioEncontrado = null;
    
            // Buscar el producto con el ID especificado
            foreach ($users as $user) {
                if ($user->getID() == $id) { // Comparar con el id del producto
                    $usuarioEncontrado = $user;
                    break;
                }
            }
    
            if ($usuarioEncontrado) {
                // Devolver el producto encontrado
                echo json_encode([
                    'estado' => 'Exito',
                    'data' => [
                        'id' => $user->getID(),
                        'nombre' => $user->getNombre(),
                        'apellidos' => $user->getApellidos(),
                        'correo' => $user->getCorreo(),
                        'direccion' => $user->getDireccion()
                    ]
                ]);
            } else {
                // Si no se encuentra el producto
                http_response_code(404);
                echo json_encode([
                    'estado' => 'Fallido',
                    'data' => 'No se encontró el producto con el ID especificado'
                ]);
            }
        }else {
            $resultado = [];
            foreach ($users as $user) {
                $resultado[] = [
                    'id' => $user->getID(),
                    'nombre' => $user->getNombre(),
                    'apellidos' => $user->getApellidos(),
                    'correo' => $user->getCorreo(),
                    'direccion' => $user->getDireccion()
                ];
            }

            echo json_encode([
                'estado' => 'Exito',
                'data' => $resultado
            ]);
        }
    }

    public function createUsuarios() { // Esta funcion recibira por PHP la informacion del usuario y lo creara
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        
        $exist = false;
        // Leer el cuerpo de la solicitud y decodificar como un array asociativo
        $input = json_decode(file_get_contents("php://input"), true);
        
        // Verificar que se han enviado todos los campos necesarios
        if (isset($input['nombre'], $input['apellidos'], $input['correo'], $input['contraseña'], $input['direccion'])) {
            $nombre = $input['nombre'];
            $apellidos = $input['apellidos'];
            $correo = $input['correo'];
            $password = $input['contraseña'];
            $direccion = $input['direccion'];
            $exist = true;
            // Llamar a la función de registro
            UsuarioDAO::registroSesion($nombre, $apellidos, $correo, $password, $direccion);
        } 
        
        if($exist === false) {
            // Faltan datos en el formulario
            echo json_encode([
                'estado' => 'Fallido',
                'mensaje' => 'Faltan datos en el formulario.'
            ]);
        }
    }

    public function modifyUsuarios() {  
        // Encabezados de respuesta
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
        $input = json_decode(file_get_contents('php://input'), true); 
    
        // Verifica si se proporciona el ID
        if (!isset($input['userId'])) {
            echo json_encode(['estado' => 'Fallido', 'mensaje' => 'ID de usuario no proporcionado.']);
            return; 
        }
        
        $id = $input['userId'];
        // Verifica y modifica cada campo proporcionado
        $exist = false;
        if (!empty($input['datos']['nombre'])) {
            $result = UsuarioDAO::modificarNombre($id, $input['datos']['nombre']);
            if ($result) $exist = true;
        }
        if (!empty($input['datos']['apellidos'])) {
            $result = UsuarioDAO::modificarApellidos($id, $input['datos']['apellidos']);
            if ($result) $exist = true;
        }
        if (!empty($input['datos']['contraseña'])) {
            $result = UsuarioDAO::modificarContraseña($id, $input['datos']['contraseña']);
            if ($result) $exist = true;
        }
        if (!empty($input['datos']['correo'])) {
            $result = UsuarioDAO::modificarCorreo($id, $input['datos']['correo']);
            if ($result) $exist = true;
        }
        if (!empty($input['datos']['direccion'])) {
            $result = UsuarioDAO::modificarDireccion($id, $input['datos']['direccion']);
            if ($result) $exist = true;
        }
    
        // Si no se realizaron cambios, se añade un mensaje
        if (!$exist) {
            echo json_encode(['estado' => 'Fallido', 'mensaje' => 'No se proporcionaron datos para modificar el usuario.']);
        } else {
            echo json_encode(['estado' => 'Exito', 'mensaje' => "Usuario modificado correctamente"]);
        }

    }
    
    
    public function eraseUsuarios() { // Esta funcion recibira por PHP la informacion del usuario a eliminar
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
    
        if (!isset($_GET['id'])) {
            echo json_encode(["estado" => "Error", "mensaje" => "ID de usuario no válido o faltante."]);
            return;
        }
    
        $id_usuario = (int)$_GET['id']; // Convertir a entero para mayor seguridad
        error_log("ID recibido para eliminación: " . $id_usuario); // Registro para depuración
    
        $resultado = UsuarioDAO::eliminarUsuario($id_usuario);
    
        $estado = ($resultado === "Usuario eliminado correctamente.") ? "Exito" : "Error";
        echo json_encode(["estado" => $estado, "mensaje" => $resultado]);
    
        session_start();
        $log = $_SESSION['usuario']['nombre'] . " " . $_SESSION['usuario']['apellidos'] . " ha " . ($estado === "Exito" ? "eliminado" : "intentado eliminar") . " el usuario con id $id_usuario";
        UsuarioDAO::agregarLog($_SESSION['usuario']['correo'], $log);
    }
    


    // Productos
    public function getProductos() {
        header('Content-Type: application/json');
        $productos = AdminDAO::obtenerProductos(); // Cambiar a obtenerProductos

        if (isset($_GET['id'])) { // Si se pasa un ID específico para buscar un producto
            $id = $_GET['id'];
            $productoEncontrado = null;
    
            // Buscar el producto con el ID especificado
            foreach ($productos as $producto) {
                if ($producto->getID() == $id) { // Comparar con el id del producto
                    $productoEncontrado = $producto;
                    break;
                }
            }
    
            if ($productoEncontrado) {
                // Devolver el producto encontrado
                echo json_encode([
                    'estado' => 'Exito',
                    'data' => [
                        'id' => $productoEncontrado->getID(),
                        'nombre' => $productoEncontrado->getNombre(),
                        'descripcion' => $productoEncontrado->getDescripcion(),
                        'precio' => $productoEncontrado->getPrecio(),
                        'precioOferta' => $productoEncontrado->getPrecioOferta(),
                        'id_oferta' => $productoEncontrado->getIdOferta(),
                        'imagen' => $productoEncontrado->getImagen(),
                        'categoria' => $productoEncontrado->getCategoria()
                    ]
                ]);
            } else {
                // Si no se encuentra el producto
                http_response_code(404);
                echo json_encode([
                    'estado' => 'Fallido',
                    'data' => 'No se encontró el producto con el ID especificado'
                ]);
            }
        } else {
            $resultado = [];
            foreach ($productos as $producto) {
                $resultado[] = [
                    'id' => $producto->getID(),
                    'nombre' => $producto->getNombre(),
                    'descripcion' => $producto->getDescripcion(),
                    'precio' => $producto->getPrecio(),
                    'precioOferta' => $producto->getPrecioOferta(),
                    'id_oferta' => $producto->getIdOferta(),
                    'imagen' => $producto->getImagen(),
                    'categoria' => $producto->getCategoria()
                ];
            }
            echo json_encode([
                'estado' => 'Exito',
                'data' => $resultado
            ]);
        }
        
    }

    public function getDetallePedido() {
        header('Content-Type: application/json');
        
        // Leer los datos enviados en la solicitud POST
        $input = json_decode(file_get_contents('php://input'), true);
        
        // Verificar que los datos necesarios estén presentes
        if (!isset($input['id_producto']) || !isset($input['id_pedido'])) {
            echo json_encode([
                'estado' => 'Fallido',
                'data' => 'Faltan parámetros requeridos'
            ]);
            return;
        }
    
        // Obtener los valores de los parámetros enviados
        $id_producto = $input['id_producto'];
        $id_pedido = $input['id_pedido'];
    
        // Obtener el detalle del pedido usando los parámetros
        $detalle_pedido = AdminDAO::obtenerDetallePedido($id_pedido, $id_producto); // Llamar al método de la base de datos
    
        // Verificar si se encontraron resultados
        if (empty($detalle_pedido)) {
            echo json_encode([
                'estado' => 'Fallido',
                'data' => 'No se encontró el detalle para este pedido y producto'
            ]);
            return;
        }
    
        // Asumimos que $detalle_pedido es un objeto, no un array
        $producto = $detalle_pedido[0];  // Ya que es un solo producto, lo accedemos directamente
    
        // Verifica que el objeto tenga la propiedad 'cantidad'
        if (isset($producto->cantidad)) {
            echo json_encode([
                'estado' => 'Exito',
                'data' => [
                    'cantidad' => $producto->cantidad,  // Accede directamente a la propiedad cantidad
                ]
            ]);
        } else {
            echo json_encode([
                'estado' => 'Fallido',
                'data' => 'No se encontró la cantidad del producto'
            ]);
        }
    }
    
    
    public static function uploadImagen() {
        // Verificar si se ha enviado una imagen
        if (!isset($_FILES['imagen'])) {
            echo json_encode(['estado' => 'Fallido', 'mensaje' => 'No se ha recibido una imagen.']);
            return;
        }

        $imagen = $_FILES['imagen'];
        $categoria = $_POST['categoria'] ?? 'default'; // Usar 'default' si no se ha enviado categoría

        // Convertir la categoría a minúsculas y agregar la 's' al final
        $categoriaConS = strtolower($categoria) . 's';

        // Definir la carpeta de destino para la imagen
        $directorioDestino = "imagenes/Productos/" . $categoriaConS;

        // Verificar si el directorio existe, si no, crearlo
        if (!is_dir($directorioDestino)) {
            mkdir($directorioDestino, 0777, true); // Crear el directorio con permisos de lectura/escritura
        }

        // Definir la ruta final para guardar la imagen
        $nombreImagen = basename($imagen['name']);
        $rutaImagenFinal = $directorioDestino . '/' . $nombreImagen;

        // Mover la imagen al servidor
        if (move_uploaded_file($imagen['tmp_name'], $rutaImagenFinal)) {
            // Retornar la URL de la imagen
            $urlImagen = "/Proyecto1/ModeloVistaControlador/" . $rutaImagenFinal; // Ruta completa de la imagen
            echo json_encode(['estado' => 'Exito', 'url' => $urlImagen]);
        } else {
            echo json_encode(['estado' => 'Fallido', 'mensaje' => 'Error al subir la imagen al servidor.']);
        }
    }



    public function createProductos() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        // Definir las variables
        $nombre = null;
        $descripcion = null;
        $precio = null;
        $imagen = null;
        $categoria = null;
        $exist = false;

        // Recibir los datos en formato JSON
        $input = json_decode(file_get_contents('php://input'), true); 

        // Verificar si los datos requeridos están presentes
        if (isset($input['nombre'], $input['descripcion'], $input['precio'], $input['imagen'], $input['categoria'])) {
            $nombre = $input['nombre'];
            $descripcion = $input['descripcion'];
            $precio = $input['precio'];
            $imagen = $input['imagen'];
            $categoria = $input['categoria'];
            $exist = true;

            // Llamar a la función para crear el producto en la base de datos
            ProductoDAO::createProducto($nombre, $descripcion, $precio, $imagen, $categoria);
        }

        if($exist === false) {
            // Faltan datos en el formulario
            echo json_encode([
                'estado' => 'Fallido',
                'mensaje' => 'Faltan datos en el formulario.'
            ]);
        }
    }
    public function eraseProductos() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
    
        // Comprobar si se proporciona el ID del producto
        if (!isset($_GET['id'])) {
            echo json_encode(["estado" => "Error", "mensaje" => "ID de producto no válido o faltante."]);
            return;
        }
    
        $id_producto = (int)$_GET['id']; // Convertir a entero para mayor seguridad
    
        // Llamar al método de eliminación del DAO
        $resultado = ProductoDAO::eliminarProducto($id_producto);
    
        // Comprobar el resultado de la eliminación
        $estado = ($resultado === "Producto eliminado correctamente.") ? "Exito" : "Error";
        echo json_encode(["estado" => $estado, "mensaje" => $resultado]);
    
        // Aplicar LOG
        session_start();
        $log = $_SESSION['usuario']['nombre'] . " " . $_SESSION['usuario']['apellidos'] . " ha " . ($estado === "Exito" ? "eliminado" : "intentado eliminar") . " el producto con id $id_producto";
        UsuarioDAO::agregarLog($_SESSION['usuario']['correo'], $log);
    }
    


    public function removeProductoPedido() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
        // Obtener los datos enviados por el cliente
        $input = json_decode(file_get_contents('php://input'), true); 
    
        // Inicializar el ID del pedido y producto
        $id_pedido = $input['id_pedido'];
        $id_producto = $input['id_producto'];
    
        // Validar si se recibieron los datos correctamente
        if (empty($id_pedido) || empty($id_producto)) {
            echo json_encode([
                'estado' => 'Fallido',
                'mensaje' => 'Faltan datos para eliminar el producto del pedido.'
            ]);
            return;
        }
    
        // Llamamos a la función de DAO para eliminar el producto y actualizar el total del pedido
        AdminDAO::eliminarProductoPedido($id_pedido, $id_producto);
    
        // Respuesta de éxito
        echo json_encode([
            'estado' => 'Exito',
            'mensaje' => 'Producto eliminado correctamente del pedido.'
        ]);
    }
    
    public function modifyProductos() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
        // Obtener los datos enviados por el cliente
        $input = json_decode(file_get_contents('php://input'), true); 
    
        // Inicializa el ID del producto
        $id = null;
    
        // Verificar si se proporcionó el ID del producto
        if (isset($input['productoId'])) {
            $id = $input['productoId'];
        } else {
            // Si no se proporciona el ID, devuelve un mensaje de error
            echo json_encode([
                'estado' => 'Fallido',
                'mensaje' => 'ID de producto no proporcionado.'
            ]);
            return; // Salir de la función si no hay ID
        }
    
        // Inicializa un flag para saber si se realizó alguna modificación
        $exist = false;
    
        // Validación de cada campo dentro de 'datos', solo modificar si no está vacío o nulo
        if (isset($input['datos']['nombre']) && !empty($input['datos']['nombre'])) {
            $resultado = ProductoDAO::modificarNombre($id, $input['datos']['nombre']);
            if ($resultado) $exist = true;
        }
    
        if (isset($input['datos']['descripcion']) && !empty($input['datos']['descripcion'])) {
            $resultado = ProductoDAO::modificarDescripcion($id, $input['datos']['descripcion']);
            if ($resultado) $exist = true;
        }
    
        if (isset($input['datos']['precio']) && !empty($input['datos']['precio'])) {
            $resultado = ProductoDAO::modificarPrecio($id, $input['datos']['precio']);
            if ($resultado) $exist = true;
        }
    
        if (isset($input['datos']['imagen']) && $input['datos']['imagen'] !== null) {
            $resultado = ProductoDAO::modificarImagen($id, $input['datos']['imagen']);
            if ($resultado) $exist = true;
        }
    
        if (isset($input['datos']['categoria']) && !empty($input['datos']['categoria'])) {
            $resultado = ProductoDAO::modificarCategoria($id, $input['datos']['categoria']);
            if ($resultado) $exist = true;
        }
    
        // Si no se realizaron modificaciones, devolver un mensaje de error
        if (!$exist) {
            echo json_encode([
                'estado' => 'Fallido',
                'mensaje' => 'No se proporcionaron datos válidos para modificar el producto.'
            ]);
        } else {
            echo json_encode([
                'estado' => 'Exito',
                'mensaje' => 'Producto modificado correctamente.'
            ]);
        }
    }
    

    // Pedidos
    public function getPedidos() {
        // Obtener pedidos
        $pedidos = AdminDAO::obtenerPedidos();
        if (isset($_GET['id'])) { // Si se pasa un ID específico para buscar un pedido
            $id = $_GET['id'];
            $pedidoEncontrado = null;
    
            // Buscar el pedido con el ID especificado
            foreach ($pedidos as $pedido) {
                if ($pedido->id_pedido == $id) { // Comparar con el id del pedido
                    $pedidoEncontrado = $pedido;
                    break;
                }
            }
            if ($pedidoEncontrado) {
                echo json_encode([
                    'estado' => 'Exito',
                    'data' => $pedidoEncontrado
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    'estado' => 'Fallido',
                    'data' => 'No se encontró el pedido con el ID especificado'
                ]);
            }
        } else {
            // Generar el JSON para todos los pedidos
            $resultado = [];
            foreach ($pedidos as $pedido) {
                $resultado[] = [
                    'id_pedido' => $pedido->id_pedido,
                    'id_usuario' => $pedido->id_usuario,
                    'cantidad_total' => $pedido->cantidad_total,
                    'fecha' => $pedido->Fecha,
                    'total_pedido' => $pedido->total_pedido,
                    'productos' => $pedido->productos
                ];
            }
    
            echo json_encode([
                'estado' => 'Exito',
                'data' => $resultado
            ]);
        }
    }


    public function createPedido() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        
        // Inicializar variables
        $id_usuario = null;
        $array_productos = [];
        $exist = false;
    
        // Obtener los datos de la entrada JSON
        $input = json_decode(file_get_contents('php://input'), true);
    
        // Comprobar si se recibieron los datos necesarios
        if (isset($input['id_usuario'], $input['productos'])) {
            $id_usuario = $input['id_usuario'];
            $array_productos = $input['productos']; // Se espera que esto sea un array con los IDs de productos y cantidades
            $exist = true;
            
            // Llamar a la función del DAO para crear el pedido
            AdminDAO::crearPedido($id_usuario, $array_productos);

        }
    
        // Manejo de errores si faltan datos
        if ($exist === false) {
            echo json_encode([
                'estado' => 'Fallido',
                'mensaje' => 'Faltan datos en el formulario.'
            ]);
        }
    }
    
    public function modifyPedido() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
        // Obtener los datos enviados por el cliente
        $input = json_decode(file_get_contents('php://input'), true);
    
        // Verificar si se proporcionó el ID del pedido
        if (!isset($input['id_pedido']) || empty($input['id_pedido'])) {
            echo json_encode([
                'estado' => 'Fallido',
                'mensaje' => 'ID de pedido no proporcionado o inválido.'
            ]);
            return;
        }
    
        $id_pedido = $input['id_pedido'];
        $exist = false; // Bandera para verificar si se realizaron modificaciones
    
        // Validación y modificación de campos
        if (isset($input['id_usuario']) && !empty($input['id_usuario'])) {
            AdminDAO::modificarIdUsuario($id_pedido, $input['id_usuario']);
            $exist = true;
        }
        
        if (isset($input['fecha']) && !empty($input['fecha'])) {
            AdminDAO::modificarFecha($id_pedido, $input['fecha']);
            $exist = true;
        }
    
        // Si no se realizaron modificaciones, devolver un mensaje de error
        if (!$exist) {
            echo json_encode([
                'estado' => 'Fallido',
                'mensaje' => 'No se proporcionaron datos válidos para modificar el pedido.'
            ]);
            return;
        }
    }
    
    

    public function modifyCantidadProducto() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
        // Obtener los datos enviados por el cliente
        $input = json_decode(file_get_contents('php://input'), true);
    
        // Verificar si se proporcionó el ID del producto y la nueva cantidad
        if (!isset($input['id_producto']) || empty($input['id_producto']) || !isset($input['cantidad'])) {
            echo json_encode([
                'estado' => 'Fallido',
                'mensaje' => 'ID de producto o cantidad no proporcionados.'
            ]);
            return;
        }
    
        $id_producto = $input['id_producto'];
        $cantidad = $input['cantidad'];
    
        // Llamar a la función del DAO para modificar la cantidad
        AdminDAO::modificarCantidadProducto($id_producto, $cantidad);
    }

    public function addProductoPedido() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        // Obtener los datos enviados por el cliente
        $input = json_decode(file_get_contents('php://input'), true); 

        // Inicializar el ID del pedido y producto
        $id_pedido = $input['pedido'];
        $id_producto = $input['producto'];
        $cantidad = $input['cantidad'];

        // Validar si se recibieron los datos correctamente
        if (empty($id_pedido) || empty($id_producto) || empty($cantidad)) {
            echo json_encode([
                'estado' => 'Fallido',
                'mensaje' => 'Faltan datos para agregar el producto al pedido.'
            ]);
            return;
        }

        // Llamamos a la función de DAO para agregar el producto y actualizar el total del pedido
        AdminDAO::agregarProductoPedido($id_pedido, $id_producto, $cantidad);

        // Respuesta de éxito
        echo json_encode([
            'estado' => 'Exito',
            'mensaje' => 'Producto agregado correctamente al pedido.'
        ]);
    }

    public function erasePedidos() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
    
        if (!isset($_GET['id_usuario']) || !isset($_GET['id_pedido'])) {
            echo json_encode(["estado" => "Error", "mensaje" => "ID de usuario o pedido no válido o faltante."]);
            return;
        }
    
        $id_usuario = (int)$_GET['id_usuario']; // Convertir a entero para mayor seguridad
        $id_pedido = (int)$_GET['id_pedido'];

        $resultado = AdminDAO::eliminarPedido($id_usuario, $id_pedido);
    
        $estado = ($resultado === "Pedido eliminado correctamente.") ? "Exito" : "Error";
        echo json_encode(["estado" => $estado, "mensaje" => $resultado]);
        
        // Aplicar LOG
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $log = $_SESSION['usuario']['nombre'] . " " . $_SESSION['usuario']['apellidos'] . " ha " . ($estado === "Exito" ? "eliminado" : "intentado eliminar") . " el pedido de $id_usuario con id $id_pedido";
        UsuarioDAO::agregarLog($_SESSION['usuario']['correo'], $log);
    }
    
    
}

?>