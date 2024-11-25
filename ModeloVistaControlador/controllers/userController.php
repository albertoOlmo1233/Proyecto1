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
    
    public function cuenta(){
        UsuarioDAO::comprobarSesion();
        $view="views/cuenta/Cuenta.php";
        include_once 'views/main.php';
    }
    public function carrito(){
        UsuarioDAO::comprobarSesion();
        $view="views/cuenta/Carrito.php";
        include_once 'views/main.php';
    }


public function inicioSesion(){
    $correo= "";
    $password="";
    if (isset($_POST['correo']) && isset($_POST['password'])) {
        $correo = $_POST['correo'];
        $password = $_POST['password'];
    }
    UsuarioDAO::iniciarSesion($correo,$password);
}

public function registroSesion(){
    $nombre= "";
    $apellidos= "";
    $correo= "";
    $password="";
    if(isset($_POST['nombre']) && isset($_POST['apellidos'])&& isset($_POST['correo']) && isset($_POST['password'])){
        $nombre= $_POST['nombre'];
        $apellidos= $_POST['apellidos'];
        $correo= $_POST['correo'];
        $password = $_POST['password'];
    }
    UsuarioDAO::registroSesion($nombre,$apellidos,$correo,$password);
    
}

public static function redireccionCarrito(){
    UsuarioDAO::comprobarSesion();
}

public static function logout(){
    UsuarioDAO::cerrarSesion();
}

// Acciones (Crear, almacenar, borrar)
public function create() {
    $view="views/productos/create.php";
    include_once 'views/main.php';
}
public function store() {
    $correo= $_POST['correo'];
    $password = $_POST['password'];
    
    echo "Nombre: .$correo. Talla: .$password";

    // Creacion camiseta
    $usuario = new Usuario();
    $usuario->setNombre($correo);
    $usuario->setTalla($password);
    $usuario->setPrecio($precio);

    UsuarioDAO::store($producto);
}
}

?>