<?php 
include_once("models/Producto.php");
include_once("models/Oferta.php");
include_once("models/OfertaDetalle.php");
include_once("config/dataBase.php");

class OfertaDAO {
    public static function getOfertas(){
        $con = DataBase::connect();
        $consulta = "
        SELECT producto.id_oferta as id_oferta, producto.nombre, producto.descripcion, producto.imagen, oferta.categoria as categoria
        FROM producto
        JOIN oferta ON producto.id_oferta = oferta.id_oferta;
        ";
        $stmt = $con->prepare($consulta);

        $stmt->execute();
        $result = $stmt->get_result();

        $ofertas = [];

        while($oferta = $result->fetch_object("OfertaDetalle")) {
            $ofertas[] = $oferta;
        }

        $con->close();

        return $ofertas;
    }

}
?>
