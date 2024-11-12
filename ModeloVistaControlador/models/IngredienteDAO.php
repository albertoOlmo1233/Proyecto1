<?php 
include_once("models/Producto.php");
include_once("models/Ingrediente.php");
include_once("models/IngredienteDetalle.php");
include_once("config/dataBase.php");

class IngredienteDAO {
    public static function getIngrediente($id_producto){
        $con = DataBase::connect();
        $consulta = "
        SELECT ingrediente.nombre, ingrediente.precio, cantidad_ingredientes.cantidad
        FROM producto
        JOIN cantidad_ingredientes ON producto.id_producto = cantidad_ingredientes.id_producto
        JOIN ingrediente ON cantidad_ingredientes.id_ingrediente = ingrediente.id_ingrediente
        WHERE producto.id_producto = ?;
        ";
        $stmt = $con->prepare($consulta);
        $stmt->bind_param("i", $id_producto);

        $stmt->execute();
        $result = $stmt->get_result();

        $ingredientes = [];

        while($ingrediente = $result->fetch_object("IngredienteDetalle")) {
            $ingredientes[] = $ingrediente;
        }

        $con->close();

        return $ingredientes;
    }

}
?>
