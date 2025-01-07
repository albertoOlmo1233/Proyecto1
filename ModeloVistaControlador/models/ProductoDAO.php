<?php 
include_once("models/Producto.php");
include_once("models/UsuarioDAO.php");
include_once("models/ProductoGeneral.php");
include_once("models/ProductoDetalle.php");
include_once("config/dataBase.php");

class ProductoDAO {
    public static function getAll(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT id_producto, nombre FROM producto;");

        $stmt->execute();
        $result = $stmt->get_result();

        $productos = [];

        while($producto = $result->fetch_object("ProductoGeneral")) {
            $productos[] = $producto;
        }

        $con->close();

        return $productos;
    }

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
    
    public static function createProducto($nombre, $descripcion, $precio, $imagen, $categoria) {
        $con = DataBase::connect();
        
        $stmt = $con->prepare("INSERT INTO producto (nombre, descripcion, precio, imagen, categoria) VALUES (?, ?, ?, ?, ?);");

        $stmt->bind_param(
            "ssdss", 
            $nombre,
            $descripcion,
            $precio,
            $imagen,
            $categoria,
        );
        
        
        if ($stmt->execute()) {
            // Log de éxito
            session_start();
            UsuarioDAO::agregarLog($_SESSION['usuario']['correo'], "El administrador ha creado un producto");
            echo json_encode(['estado' => 'Exito', 'mensaje' => 'Producto creado exitosamente.']);
        } else {
            echo json_encode(['estado' => 'Fallido', 'mensaje' => 'Error al crear un producto.']);
        }
        $con->close();
    }


    public static function eliminarProducto($id_producto){
        $con = DataBase::connect();

        // Eliminar los detalles de pedido asociados con los pedidos del usuario
        $detalles_pedidos = $con->prepare(
            "DELETE detalle_pedido
            FROM detalle_pedido
            WHERE id_producto = ?;"
        );
        $detalles_pedidos->bind_param("i", $id_producto);
        $detalles_pedidos->execute();
        $detalles_pedidos->close(); 

        $producto = $con->prepare("DELETE FROM producto WHERE id_producto = ?");
        $producto->bind_param("i", $id_producto);
        $producto->execute();

        $autoIncrementoDetalle_Pedido = $con->prepare("ALTER TABLE detalle_pedido AUTO_INCREMENT = 1;");
        $autoIncrementoDetalle_Pedido->execute();
        $autoIncrementoProducto = $con->prepare("ALTER TABLE producto AUTO_INCREMENT = 1;");
        $autoIncrementoProducto->execute();

        $mensaje = "";
        if ($producto->affected_rows > 0) {
            $mensaje = "Producto eliminado correctamente.";
        } else {
            $mensaje = "No se encontró ningún producto con el ID proporcionado.";
        }

        $autoIncrementoProducto->close();
        $autoIncrementoDetalle_Pedido->close();
        $producto->close();
        $con->close();
        return $mensaje;
    }

    // Administrador
    public static function modificarNombre($id, $nombre) {
        // Asegúrate de que la sesión esté iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();  // Inicia la sesión si no está iniciada
        }
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT nombre FROM producto WHERE id_producto=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultNombre = $stmt->get_result();
        $row = $resultNombre->fetch_array();
        $nombre_resultado = $row['nombre'];
    
        if ($nombre_resultado && $nombre_resultado === $nombre) {
            return false;  // Indica que no se realizó la modificación
        } else {
            // Actualizar nombre en la base de datos
            $stmt1 = $con->prepare("UPDATE producto SET nombre = ? WHERE id_producto = ?;");
            $stmt1->bind_param("si", $nombre, $id);
            $stmt1->execute();
    
            UsuarioDAO::agregarLog(
                $_SESSION["usuario"]["correo"],
                "El administrador ha modificado correctamente el nombre del producto con el id $id."
            );
    
            return true;  // Indica que la modificación fue exitosa
        }
        $stmt->close();
        $con->close();
    }
    
    public static function modificarDescripcion($id, $descripcion) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT descripcion FROM producto WHERE id_producto=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultDescripcion = $stmt->get_result();
        $row = $resultDescripcion->fetch_array();
        $descripcion_resultado = $row['descripcion'];
    
        if ($descripcion_resultado && $descripcion_resultado === $descripcion) {
            return false;  // No se realizó la modificación
        } else {
            $stmt1 = $con->prepare("UPDATE producto SET descripcion = ? WHERE id_producto = ?");
            $stmt1->bind_param("si", $descripcion, $id);
            $stmt1->execute();
    
            UsuarioDAO::agregarLog(
                $_SESSION["usuario"]["correo"],
                "El administrador ha modificado correctamente la descripción del producto con el id $id."
            );
    
            return true;  // Modificación exitosa
        }
        $stmt->close();
        $con->close();
    }
    
    public static function modificarPrecio($id, $precio) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT precio FROM producto WHERE id_producto=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultPrecio = $stmt->get_result();
        $row = $resultPrecio->fetch_array();
        $precio_resultado = $row['precio'];
    
        if ($precio_resultado && $precio_resultado == $precio) {
            return false;  // No se realizó la modificación
        } else {
            $stmt1 = $con->prepare("UPDATE producto SET precio = ? WHERE id_producto = ?");
            $stmt1->bind_param("di", $precio, $id);
            $stmt1->execute();
    
            UsuarioDAO::agregarLog(
                $_SESSION["usuario"]["correo"],
                "El administrador ha modificado correctamente el precio del producto con el id $id."
            );
    
            return true;  // Modificación exitosa
        }
        $stmt->close();
        $con->close();
    }
    
    public static function modificarImagen($id, $imagen) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT imagen FROM producto WHERE id_producto=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultImagen = $stmt->get_result();
        $row = $resultImagen->fetch_array();
        $imagen_resultado = $row['imagen'];
    
        if ($imagen_resultado && $imagen_resultado === $imagen) {
            return false;  // No se realizó la modificación
        } else {
            $stmt1 = $con->prepare("UPDATE producto SET imagen = ? WHERE id_producto = ?");
            $stmt1->bind_param("si", $imagen, $id);
            $stmt1->execute();
    
            UsuarioDAO::agregarLog(
                $_SESSION["usuario"]["correo"],
                "El administrador ha modificado correctamente la imagen del producto con el id $id."
            );
    
            return true;  // Modificación exitosa
        }
        $stmt->close();
        $con->close();
    }
    
    public static function modificarCategoria($id, $categoria) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT categoria FROM producto WHERE id_producto=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultCategoria = $stmt->get_result();
        $row = $resultCategoria->fetch_array();
        $categoria_resultado = $row['categoria'];
    
        if ($categoria_resultado && $categoria_resultado === $categoria) {
            return false;  // No se realizó la modificación
        } else {
            $stmt1 = $con->prepare("UPDATE producto SET categoria = ? WHERE id_producto = ?");
            $stmt1->bind_param("si", $categoria, $id);
            $stmt1->execute();
    
            UsuarioDAO::agregarLog(
                $_SESSION["usuario"]["correo"],
                "El administrador ha modificado correctamente la categoría del producto con el id $id."
            );
    
            return true;  // Modificación exitosa
        }
        $stmt->close();
        $con->close();
    }
    
    


}
?>
