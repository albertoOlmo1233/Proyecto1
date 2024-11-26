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

    public static function getUsuario($correo){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM usuario WHERE correo = ?");
        $stmt->bind_param("s",$correo);

        $stmt->execute();
        $result = $stmt->get_result();

        $detalleUsuario = null;

        while($usuario = $result->fetch_object("UsuarioDetalle")) {
            $detalleUsuario = $usuario;
        }

        $con->close();

        return $detalleUsuario;
    }


    public static function store($usuario){
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO usuarios (nombre, apellidos, correo, contraseña, rol) VALUES (?,?,?,?,?);");
        $stmt->bind_param("sssss",$usuario->getNombre(),$usuario->getApellido(),$usuario->getCorreo(),$usuario->getContraseña,"Cliente");
        
        $stmt->execute();
        $con->close();
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
                "id" => $usuario->getId(),       // Asumiendo que tienes un método getId()
                "nombre" => $usuario->getNombre() // Asumiendo que tienes un método getNombre()
            ];
        
            $confirmacion = "Inicio de sesión exitoso. Serás redirigido en breve.";
        
            if (isset($confirmacion)) {
                $view = "views/login/Login.php";
                include_once 'views/main.php';
            }
        }else {
            // La contraseña no existe
            $error = "La contraseña es incorrecta, pruebe de nuevo.";
        }
    } else {
        // El correo no existe
        $error = "No hay ninguna cuenta asociada con este correo.";
    }
    if(isset($error)) {
        $view = "views/login/Login.php";
        include_once 'views/main.php';
    }
    if(isset($confirmacion)){
        $view = "views/login/Login.php";
        include_once 'views/main.php';
    }
    $con->close();
}

   // Registrar usuario
public static function registroSesion($nombre, $apellidos, $correo, $password){
    // Validar que la contraseña tenga 8 caracteres o más
    if (strlen($password) < 8) {
        $error = "La contraseña no puede tener menos de 8 caracteres.";
    }
    // Validar que la contraseña no tenga más de 18 caracteres
    if (strlen($password) > 18) {
        $error = "La contraseña no puede tener más de 18 caracteres.";
    }

    // Verificar que no haya error en la contraseña
    if (!isset($error)) {
        $con = DataBase::connect();

        // Verificamos que el correo no exista en la base de datos
        $stmt = $con->prepare("SELECT * FROM usuario WHERE correo=?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_object("UsuarioDetalle");

        // Si ya existe un usuario con el mismo correo, mostramos el error
        if ($usuario) {
            $error = "Ya existe una cuenta con este correo asociado.";
        } else {
            //  Verificamos si el nombre y apellidos ya están registrados
            $stmt1 = $con->prepare("SELECT * FROM usuario WHERE nombre=? AND apellidos=?");
            $stmt1->bind_param("ss", $nombre, $apellidos);
            $stmt1->execute();
            $result1 = $stmt1->get_result();
            $usuarioExistente = $result1->fetch_object("UsuarioDetalle");

            // Si ya existe un usuario con el mismo nombre y apellidos, mostramos el error
            if ($usuarioExistente) {
                $error = "Ya existe una cuenta con este nombre y apellidos.";
            }
        }

        // Si no hubo error, encriptamos la contraseña y guardamos el nuevo usuario
        if (!isset($error)) {
            $passwordEncriptado = password_hash($password, PASSWORD_BCRYPT);

            // Insertamos los datos en la base de datos
            $stmt2 = $con->prepare("INSERT INTO usuario (nombre, apellidos, correo, contraseña, rol) VALUES (?, ?, ?, ?, 'Cliente')");
            $stmt2->bind_param("ssss", $nombre, $apellidos, $correo, $passwordEncriptado);

            // Si la ejecución es exitosa, redirigimos a la página de login
            if ($stmt2->execute()) {
                $view = "views/login/Login.php";
                include_once 'views/main.php';
            } else {
                echo "Ha habido un error en el servidor";
                return;
            }
        }
    }

    // Si hay un error, mostramos el mensaje
    if (isset($error)) {
        $view = "views/login/Register.php";
        include_once "views/main.php";
    }

    $con->close();
}
    

public static function comprobarSesion(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if(!isset($_SESSION["usuario"])){
        header("Location: ?controller=user");
    }
    
}

public static function modificarNombre($id,$nombre){
    $con = DataBase::connect();
    $stmt = $con->prepare("INSERT INTO usuarios (nombre, apellidos, correo, contraseña, rol) VALUES (?,?,?,?,?);");
    $stmt->bind_param("sssss",$usuario->getNombre(),$usuario->getApellido(),$usuario->getCorreo(),$usuario->getContraseña,"Cliente");
    
    $stmt->execute();
    $con->close();
}
public static function modificarContraseña($id,$contraseña){
    $con = DataBase::connect();
    $stmt = $con->prepare("INSERT INTO usuarios (nombre, apellidos, correo, contraseña, rol) VALUES (?,?,?,?,?);");
    $stmt->bind_param("sssss",$usuario->getNombre(),$usuario->getApellido(),$usuario->getCorreo(),$usuario->getContraseña,"Cliente");
    
    $stmt->execute();
    $con->close();
}
public static function modificarDireccion($id,$direccion){
    $con = DataBase::connect();
    $stmt = $con->prepare("SELECT * FROM usuario WHERE id_usuario=?");
    $stmt1->bind_param("i",$id);
    
    $stmt1 = $con->prepare("INSERT INTO usuarios (nombre, apellidos, correo, contraseña, rol) VALUES (?,?,?,?,?);");
    $stmt1->bind_param("sssss",$usuario->getNombre(),$usuario->getApellido(),$usuario->getCorreo(),$usuario->getContraseña,"Cliente");
    
    $stmt->execute();
    $con->close();
}

public static function cerrarSesion() {
    // Iniciar la sesión
    session_start();

    // Eliminar todas las variables de sesión
    session_unset();
    // Destruir la sesión
    session_destroy();

    header("Location: ?controller=producto");
    exit();
}


public static function destroy($id){
    $con = DataBase::connect();
    $stmt = $con->prepare("DELETE FROM camisetas WHERE ID =?");
    // Le pasamos un argumento numero entero, por lo tanto el bind_param sera 'i' de Integer
    $stmt->bind_param("i",$id);
    
    $stmt->execute();
    $con->close();
}
}

?>