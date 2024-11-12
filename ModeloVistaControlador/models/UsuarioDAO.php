<?php 
include_once("models/Usuario.php");
include_once("config/dataBase.php");

class UserDAO {
    public static function getAll(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM producto");

        $stmt->execute();
        $result = $stmt->get_result();

        $productos = [];

        while($producto = $result->fetch_object("Camiseta")) {
            $productos[] = $producto;
        }

        $con->close();

        return $productos;
    }

    public static function store($producto){
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO productos (nombre, talla, precio) VALUES (?,?,?);");
        $stmt->bind_param("ssd",$producto->getNombre(),$producto->getTalla(),$producto->getPrecio());
        
        $stmt->execute();
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