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

public static function modificarNombre(){
    $id = null;
    $nombre = null;
    if(isset($_GET['id']) && isset($_GET['nombre'])){
        $id = $_GET['id'];
        $nombre = $_GET['nombre'];
    }
    UsuarioDAO::modificarNombre($id,$nombre);
}
public static function modificarContraseña(){
    $id = null;
    $contraseña = null;
    if(isset($_GET['id']) && isset($_GET['contraseña'])){
        $id = $_GET['id'];
        $contraseña = $_GET['contraseña'];
    }
    UsuarioDAO::modificarContraseña($id,$contraseña);
}
public static function modificarDireccion(){
    $id = null;
    $direccion = null;
    if(isset($_GET['id']) && isset($_GET['direccion'])){
        $id = $_GET['id'];
        $direccion = $_GET['direccion'];
    }
    UsuarioDAO::modificarDireccion($id,$direccion);
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