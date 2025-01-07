<?php 
include_once("models/ProductoDAO.php");
include_once("models/ProductoDetalle.php");
include_once("models/IngredienteDAO.php");
include_once("models/OfertaDAO.php");

class productoController {
    public function index() {
        $ofertas = OfertaDAO::getOfertas();
        $view="views/Inicio.php";
        include_once 'views/main.php';
    }

    public function menu() {
        $productos = ProductoDAO::getType("Hamburguesa");
        $tituloProducto = "Hamburguesas";
        $view="views/Menu.php";
        include_once 'views/main.php';
    }

    // Filtros
    public function showPatatas() {
        $productos = ProductoDAO::getType("Patata");
        $tituloProducto = "Patatas"; 
        $view="views/Menu.php";
        include_once 'views/main.php';
    }

    public function showBebidas(){
        $productos = ProductoDAO::getType("Bebida");
        $tituloProducto = "Bebidas"; 
        $view="views/Menu.php";
        include_once 'views/main.php';
    }

    public function showPostres() {
        $productos = ProductoDAO::getType("Postre");
        $tituloProducto = "Postres";
        $view="views/Menu.php";
        include_once 'views/main.php';
    }
    

    public function añadirCarrito() {
        session_start();
    
        if (!isset($_SESSION['usuario'])) {
            $_SESSION['error'] = "Usuario no autenticado.";
            header("Location: ?controller=producto&action=menu");
            exit();
        }
    
        $id_usuario = $_SESSION['usuario']['id'];
    
        if (isset($_GET["id_producto"])) {
            $id_producto = intval($_GET["id_producto"]);
    
            $producto = ProductoDAO::getProducto($id_producto);
            if ($producto) {
                if (!isset($_SESSION['carrito'][$id_usuario])) {
                    $_SESSION['carrito'][$id_usuario] = [];
                }
    
                if (isset($_SESSION['carrito'][$id_usuario][$id_producto])) {
                    $_SESSION['carrito'][$id_usuario][$id_producto]['cantidad'] += 1;
                } else {
                    $_SESSION['carrito'][$id_usuario][$id_producto] = [
                        'producto' => $producto,
                        'cantidad' => 1
                    ];
                }
                $_SESSION['confirmacion'] = "Se ha añadido el producto al carrito.";
            } else {
                $_SESSION['error'] = "Producto no encontrado.";
            }
        } else {
            $_SESSION['error'] = "ID de producto no especificado.";
        }
    
        // Redirigir al menú después de procesar
        header("Location: ?controller=producto&action=menu");
        exit();
    }
    
    
    public function sumar() {
        session_start();
        if (isset($_GET["id_producto"])) {
            $id_producto = $_GET["id_producto"];  // Obtenemos el ID del producto
            
            $id_usuario = $_SESSION['usuario']['id'];
            // Verificar si el carrito está en la sesión
            if (isset($_SESSION['carrito'][$id_usuario][$id_producto])) {
                // Cantidad actual
                $cantidadActual = $_SESSION['carrito'][$id_usuario][$id_producto]['cantidad']; 
     
                // Verificamos que la cantidad sea mayor a 1 antes de restar
                if ($cantidadActual < 999) {
                    $_SESSION['carrito'][$id_usuario][$id_producto]['cantidad'] = $cantidadActual + 1;  // Decrementamos la cantidad
                    // Mostramos el valor actualizado
                    // echo "Cantidad actualizada: " . $_SESSION['carrito'][$id]['cantidad'];
                }
            } else {
                echo "El producto no está en el carrito.";
            }
            // Redirigimos al carrito
            header("Location: ?controller=user&action=carrito#pedido-$id_producto");
            exit();
        }
    }
    
    public function restar() {
        session_start();
        if (isset($_GET["id_producto"])) {
            $id_producto = $_GET["id_producto"];  // Obtenemos el ID del producto
            
            $id_usuario = $_SESSION['usuario']['id'];
            // Verificar si el carrito está en la sesión
            if (isset($_SESSION['carrito'][$id_usuario][$id_producto])) {
                 // Cantidad actual
                $cantidadActual = $_SESSION['carrito'][$id_usuario][$id_producto]['cantidad'];
     
                // Verificamos que la cantidad sea mayor a 1 antes de restar
                if ($cantidadActual > 1) {
                    $_SESSION['carrito'][$id_usuario][$id_producto]['cantidad'] = $cantidadActual - 1;  // Decrementamos la cantidad
                    // Mostramos el valor actualizado
                    // echo "Cantidad actualizada: " . $_SESSION['carrito'][$id]['cantidad'];
                } else {
                    unset($_SESSION['carrito'][$id_usuario][$id_producto]); 
                }

            }

            // Redirigimos al carrito
            header("Location: ?controller=user&action=carrito#pedido-$id_producto");
            exit();
        }
    }

    public function tramitacion_pedidos() {
        if(isset($_GET['totalPedido'])){
            $totalPedido = $_GET['totalPedido'];
        }
       UsuarioDAO::tramitar_pedido($totalPedido);
    }

    // Mostrar producto
    public function show() {
        $id = null;
        if(isset($_GET["id"])) {
            $id=$_GET["id"];
        }
        $detalleProducto= ProductoDAO::getProducto($id);
        $view="views/productos/show/showProducto.php";
        include_once 'views/main.php';
    }

    public function sobreNosotros() {
        $view="views/Sobre nosotros.php";
        include_once 'views/main.php';
    }

    public function contacto() {
        $view="views/Contacto.php";
        include_once 'views/main.php';
    }

    public function login() {
        $view="views/login/Login.php";
        include_once 'views/main.php';
    }

    public function registrarse() {
        $view="views/login/Register.php";
        include_once 'views/main.php';
    }
    

}

?>