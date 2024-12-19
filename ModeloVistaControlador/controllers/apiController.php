<?php 
include_once("config/dataBase.php");
include_once("models/ProductoDAO.php");
include_once("models/UsuarioDAO.php");
include_once("models/ProductoGeneral.php");
include_once("models/admin/AdminDAO.php");
include_once("models/admin/Logs/LogDetalle.php");

class apiController {
    // public function index() {
    //     $view="views/admin/panel/panel.php";
    //     include_once 'views/main.php';
    // }

    // Usuarios

    public function getUsuarios() {
        $users = AdminDAO::obtenerUsuarios();

        if (!$users) {
            http_response_code(500); // Indicar error en el servidor
            echo json_encode([
                'estado' => 'Fallido',
                'data' => 'No se pudo obtener usuarios'
            ]);
            return;
        }

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

    public function createUsuario() {
        $nombre = null;
        $apellidos = null;
        $correo = null;
        $contraseña = null;
        $direccion = null;
        if(isset($_POST['nombre'])&&isset($_POST['apellidos'])&&isset($_POST['correo'])&&isset($_POST['password'])&&isset($_POST['direccion'])){
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $correo = $_POST['correo'];
            $contraseña = $_POST['password'];
            $direccion = $_POST['direccion'];
        }

        var_dump($nombre);
        var_dump($apellidos);
        var_dump($correo);
        var_dump($contraseña);
        var_dump($direccion);

        // Intentamos registrar al usuario
        $registroExitoso = UsuarioDAO::registroSesion($nombre, $apellidos, $correo, $contraseña);

        // Verificamos si la creación fue exitosa o fallida
        if ($registroExitoso) {
            echo json_encode([
                'estado' => 'Exito',
                'mensaje' => '¡Usuario creado exitosamente!'
            ]);
        } else {
            // Si no fue exitoso, devolvemos el error
            echo json_encode([
                'estado' => 'Fallido',
                'mensaje' => 'El usuario ya existe o hubo un error al crear el usuario.'
            ]);
        }

        header("Location: ?controller=admin&action=usuariosConfig&funcion=create");
        exit;
        // echo json_encode([
        //     'estado' => 'Exito',
        //     'data' => $resultado
        // ]);
}
    

    // Productos
    public function getProductos() {
        $productos = AdminDAO::obtenerProductos(); // Cambiar a obtenerProductos
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $producto = null;
            foreach ($productos as $product) {
                if ($product['id'] == $id) { // Cambiar user['id'] a product['id']
                    $producto = $product;
                    break;
                }
            }
            if ($producto) {
                echo json_encode([
                    'estado' => 'Exito',
                    'data' => $producto
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    'estado' => 'Fallido',
                    'data' => 'No se encontró el producto'
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
                // Asociar productos por pedido
                $resultado[] = [
                    'id_pedido' => $pedido->id_pedido,
                    'id_usuario' => $pedido->id_usuario,
                    'cantidad_total' => $pedido->cantidad_total,
                    'correo' => $pedido->correo,
                    'fecha' => $pedido->Fecha,
                    'total_pedido' => $pedido->total_pedido,
                    'productos' => $pedido->productos // Aquí accedes correctamente a la propiedad productos
                ];
            }
    
            echo json_encode([
                'estado' => 'Exito',
                'data' => $resultado
            ]);
        }
    }
    
    
}

?>