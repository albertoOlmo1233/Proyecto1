<?php 
include_once("models/Usuario.php");
include_once("config/dataBase.php");

class UsuarioDAO {
    public static function getAll(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM usuario");

        $stmt->execute();
        $result = $stmt->get_result();

        $productos = [];

        while($producto = $result->fetch_object("Camiseta")) {
            $productos[] = $producto;
        }

        $con->close();

        return $productos;
    }

    public static function store($usuario){
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO usuarios (nombre, apellidos, correo, contraseña, rol) VALUES (?,?,?,?,?);");
        $stmt->bind_param("sssss",$usuario->getNombre(),$usuario->getApellido(),$usuario->getCorreo(),$usuario->getContraseña,"Cliente");
        
        $stmt->execute();
        $con->close();
    }
    // Iniciar sesion
    public static function iniciarSesion($correo,$contraseña){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM usuario WHERE correo=? AND contraseña =?");
        $passwordEncriptado = password_hash($contraseña, PASSWORD_BCRYPT);
        $stmt->bind_param("ss",$correo,$contraseña);
        $stmt->execute();
        
        if($stmt->execute()){
            $view="views/cuenta/cuenta.php";
            include_once 'views/main.php';
        }else {
            echo "Error en el registro: " . $stmt->error;
        }
        $con->close();
    }

    // Registrar usuario
    public static function registrarUsuario(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM usuario WHERE correo=? AND contraseña =?");
        $passwordEncriptado = password_hash($contraseña, PASSWORD_BCRYPT);
        $stmt->bind_param("ss",$correo,$contraseña);
        $stmt->execute();
        // Obtener el resultado y contar las filas
        $resultado = $stmt->get_result();
        $numeroFilas = $resultado->num_rows;
        if($numeroFilas == 0){
            $stmt1 = $con->prepare("INSERT INTO usuarios (nombre, apellidos, correo, contraseña, rol) VALUES (?,?,?,?,?);");
            $stmt1->bind_param("sssss",$usuario->getNombre(),$usuario->getApellido(),$usuario->getCorreo(),$usuario->getContraseña,"Cliente");
        
        }else {
            echo "El usuario ya existe: " . $stmt->error;
        }
        $con->close();
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