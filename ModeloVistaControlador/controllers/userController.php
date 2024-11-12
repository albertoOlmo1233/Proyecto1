<?php 
include_once("models/UsuarioDAO.php");
class userController {
    public function index() {
        $view="views/login/Login.php";
        include_once 'views/main.php';
    }

    public function register() {
        $view="views/login/Register.php";
        include_once 'views/main.php';
    }
    

    // Acciones (Crear, almacenar, borrar)
    public function create() {
        $view="views/productos/create.php";
        include_once 'views/main.php';
    }
    public function store() {
        $nombre = $_POST['nombre'];
        $talla = $_POST['talla'];
        $precio = $_POST['precio'];
        
        echo "Nombre: .$nombre. Talla: .$talla. Precio: .$precio.";

        // Creacion camiseta
        $producto = new Camiseta();
        $producto->setNombre($nombre);
        $producto->setTalla($talla);
        $producto->setPrecio($precio);

        CamisetaDAO::store($producto);
    }
    public function destroy() {
        CamisetaDAO::destroy($_GET['id']);
        header('Location:?controller=producto');
    }
    public function show() {
        $view="views/productos/show.php";
        include_once 'views/main.php';
    }

}

?>