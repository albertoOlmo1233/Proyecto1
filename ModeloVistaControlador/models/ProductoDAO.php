<?php 
include_once("models/Producto.php");
include_once("models/ProductoGeneral.php");
include_once("models/ProductoDetalle.php");
include_once("config/dataBase.php");

class ProductoDAO {
    public static function getType($categoria){
        $con = DataBase::connect();
        $stmt = $con->prepare("
            SELECT 
                producto.*, 
                producto.precio * (oferta.porcentaje / 100) AS precio_oferta,
                oferta.categoria AS oferta_categoria, 
                oferta.porcentaje
            FROM 
                producto
            LEFT JOIN 
                oferta
            ON 
                producto.id_oferta = oferta.id_oferta
            WHERE 
                producto.categoria = ?;
        ");

        $stmt->bind_param("s", $categoria);

        $stmt->execute();
        $result = $stmt->get_result();

        $productos = [];

        while($producto = $result->fetch_object("ProductoGeneral")) {
            $productos[] = $producto;
        }

        $con->close();

        return $productos;
    }

    public static function getProducto($id) {
    $con = DataBase::connect();
    $stmt = $con->prepare("
        SELECT 
            producto.*, 
            (producto.precio * (oferta.porcentaje / 100)) as precio_oferta,
            oferta.categoria AS categoria, 
            oferta.porcentaje
        FROM producto
        LEFT JOIN oferta oferta ON producto.id_oferta = oferta.id_oferta
        WHERE producto.id_producto = ?
    ");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $detalleProducto = $result->fetch_object("ProductoGeneral");


    $con->close();
    return $detalleProducto;
}


    public static function getOfertas(){
        $con = DataBase::connect();
        $consulta = "
        SELECT producto.id_oferta as id_oferta, producto.nombre, producto.descripcion, producto.imagen, oferta.categoria  as categoria
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


    // Administrador
    public static function store($producto){
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO producto (nombre, categoria, descripcion, precio, imagen) VALUES (?, ?, ?, ?, ?);");
        $stmt->bind_param("sssds", $producto->getNombre(), $producto->getCategoria(), $producto->getDescripcion(), $producto->getPrecio(), $producto->getImagen());
        $stmt->execute();
        $con->close();
    }

    public static function destroy($id){
        $con = DataBase::connect();
        $stmt = $con->prepare("DELETE FROM producto WHERE id_producto = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $con->close();
    }
}
?>
