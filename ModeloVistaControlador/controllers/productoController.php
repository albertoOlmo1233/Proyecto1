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

    public function añadirCarrito() {
        session_start(); // Iniciar la sesión para manejar el carrito
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
    
            // Obtener el producto usando ProductoDAO
            $producto = ProductoDAO::getProducto($id);
            if ($producto) {
                // Inicializar el carrito si no existe
                if (!isset($_SESSION['carrito'])) {
                    $_SESSION['carrito'] = [];
                }
    
                // Verificar si el producto ya está en el carrito
                if (isset($_SESSION['carrito'][$id])) {
                    // Si el producto ya está, incrementar la cantidad
                    $_SESSION['carrito'][$id]['cantidad'] += 1;
                } else {
                    // Si no está, agregarlo con una cantidad inicial de 1
                    $_SESSION['carrito'][$id] = [
                        'producto' => $producto, // Almacenar detalles del producto
                        'cantidad' => 1
                    ];
                }
            } else {
                echo "Producto no encontrado.";
            }
        } else {
            echo "ID de producto no especificado.";
        }
        // Redirigimos al carrito
        header("Location: ?controller=producto&action=menu#producto-$id");
        exit();
    
    }
    
    public function sumar() {
        session_start();
        if (isset($_GET["id"])) {
            $id = $_GET["id"];  // Obtenemos el ID del producto
     
            // Verificar si el carrito está en la sesión
            if (isset($_SESSION['carrito'])) {
                $cantidadActual = $_SESSION['carrito'][$id]['cantidad'];  // Cantidad actual
     
                // Verificamos que la cantidad sea mayor a 1 antes de restar
                if ($cantidadActual < 999) {
                    $_SESSION['carrito'][$id]['cantidad'] = $cantidadActual + 1;  // Decrementamos la cantidad
                    // Mostramos el valor actualizado
                    // echo "Cantidad actualizada: " . $_SESSION['carrito'][$id]['cantidad'];
                }
            } else {
                echo "El producto no está en el carrito.";
            }
            // Redirigimos al carrito
            header("Location: ?controller=user&action=carrito#pedido-$id");
            exit();
        }
    }
    
    public function restar() {
        session_start();
        if (isset($_GET["id"])) {
            $id = $_GET["id"];  // Obtenemos el ID del producto
     
            // Verificar si el carrito está en la sesión
            if (isset($_SESSION['carrito'])) {
                $cantidadActual = $_SESSION['carrito'][$id]['cantidad'];  // Cantidad actual
     
                // Verificamos que la cantidad sea mayor a 1 antes de restar
                if ($cantidadActual > 1) {
                    $_SESSION['carrito'][$id]['cantidad'] = $cantidadActual - 1;  // Decrementamos la cantidad
                    // Mostramos el valor actualizado
                    // echo "Cantidad actualizada: " . $_SESSION['carrito'][$id]['cantidad'];
                } else {
                    unset($_SESSION['carrito'][$id]); 
                }

            }

            // Redirigimos al carrito
            header("Location: ?controller=user&action=carrito#pedido-$id");
            exit();
        }
    }

    // Mostrar producto
    public function show() {
        $id=$_GET["id"];
        $detalleProducto= ProductoDAO::getProducto($id);
        $detalleIngredientes= IngredienteDAO::getIngrediente($id);
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
    

    // Acciones (Crear, almacenar, borrar)
    public function create() {
        $view="views/productos/create.php";
        include_once 'views/main.php';
    }
    public function store() {
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $imagen = $_POST['imagen'];
        
        echo "Nombre: .$nombre. Talla: .$talla. Precio: .$precio.";

        // Creacion camiseta
        $producto = new Producto();
        $producto->setNombre($nombre);
        $producto->setCategoria($categoria);
        $producto->setDescripcion($descripcion);
        $producto->setPrecio($precio);
        $producto->setImagen($imagen);

        ProductoDAO::store($producto);
    }
    public function destroy() {
        ProductoDAO::destroy($_GET['id']);
        header('Location:?controller=producto');
    }

}

?>