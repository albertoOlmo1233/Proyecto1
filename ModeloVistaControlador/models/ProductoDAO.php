<?php 
include_once("models/Producto.php");
include_once("models/ProductoGeneral.php");
include_once("models/ProductoDetalle.php");
include_once("config/dataBase.php");

class ProductoDAO {
    public static function getType($categoria){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM producto WHERE categoria=?");
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

    public static function getProducto($id){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM producto WHERE id_producto=?");
        $stmt->bind_param("i", $id);

        $stmt->execute();
        $result = $stmt->get_result();

        $detalleProducto = "";

        while($producto = $result->fetch_object("ProductoDetalle")) {
            $detalleProducto = $producto;
        }

        $con->close();

        return $detalleProducto;
    }

    public static function getProductoArray($id) {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM producto WHERE id_producto=?");
        $stmt->bind_param("i", $id);
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        $detalleProducto = [];  // Definir como un array para almacenar varios productos.
    
        while ($producto = $result->fetch_object("ProductoArrayDetalle")) {
            $detalleProducto[] = $producto;  // Agregar al array
        }
    
        $con->close();
    
        return $detalleProducto;  // Devuelve el array con todos los productos encontrados.
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
