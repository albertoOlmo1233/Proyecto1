<?php 
include_once("models/ProductoDAO.php");
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
        $view="views/Menu.php";
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
        $view="views/Menu.php";
        include_once 'views/main.php';
    }

    public function showBebidas(){
        $productos = ProductoDAO::getType("Bebida");
        $view="views/Menu.php";
        include_once 'views/main.php';
    }

    public function showPostres() {
        $productos = ProductoDAO::getType("Postre");
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
    public function show() {
        $id=$_GET["id"];
        $detalleProducto= ProductoDAO::getProducto($id);
        $detalleIngredientes= IngredienteDAO::getIngrediente($id);
        $view="views/productos/show/showProducto.php";
        include_once 'views/main.php';
    }

}

?>