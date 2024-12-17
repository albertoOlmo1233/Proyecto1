<?php 
include_once("config/dataBase.php");
include_once("models/admin/Logs/LogDetalle.php");

include_once("models/ProductoDetalle.php");
include_once("models/UsuarioDetalle.php");


class AdminDAO {
    // Logs
    public static function getLogs(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM log");

        $stmt->execute();
        $result = $stmt->get_result();

        $logs = [];

        while($log = $result->fetch_object("LogDetalle")) {
            $logs[] = $log;
        }

        $con->close();

        return $logs;
    }

    // Pedidos
    public static function obtenerPedidos() {
        $con = DataBase::connect();
        
        // Primera consulta: obtener los pedidos con productos
        $stmt = $con->prepare("
        SELECT 
            pedido.id_pedido,
            IFNULL(GROUP_CONCAT(detalle_pedido.id_producto), '') AS productos,
            SUM(detalle_pedido.cantidad) AS cantidad_total,
            pedido.id_usuario,
            pedido.Fecha,
            pedido.total_pedido
        FROM 
            detalle_pedido
        INNER JOIN 
            pedido 
        ON 
            detalle_pedido.id_pedido = pedido.id_pedido
        GROUP BY pedido.id_pedido;");
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        $pedidos = [];
        
        // Preparar la segunda consulta para obtener el correo del usuario
        $stmt1 = $con->prepare("SELECT correo FROM usuario WHERE id_usuario = ?");
        
        while ($pedido = $result->fetch_object()) {
            $id_usuario = $pedido->id_usuario;
            
            // Ejecutar la consulta para obtener el correo
            $stmt1->bind_param("i", $id_usuario);
            $stmt1->execute();
            $resultCorreo = $stmt1->get_result();
            
            if ($correo = $resultCorreo->fetch_object()) {
                $pedido->correo = $correo->correo;
            } else {
                $pedido->correo = null;
            }
            
            // Convertir la cadena de productos en un array
            $pedido->productos = !empty($pedido->productos) ? explode(",", $pedido->productos) : [];
            $pedidos[] = $pedido;
        }
        
        // Cerrar las conexiones
        $stmt->close();
        $stmt1->close();
        $con->close();
        
        return $pedidos;  // Retorna la lista de pedidos con los productos correctamente procesados
        }
    

    public static function obtenerPedido() {
        $con = DataBase::connect();
        $id_usuario = $_SESSION['usuario']['id'];
        // Primera consulta: obtener los pedidos para un usuario específico
        $stmt = $con->prepare("
            SELECT 
                pedido.id_pedido,
                GROUP_CONCAT(detalle_pedido.id_producto) AS productos,
                SUM(detalle_pedido.cantidad) AS cantidad_total,
                pedido.id_usuario,
                pedido.Fecha,
                pedido.total_pedido
            FROM 
                detalle_pedido
            INNER JOIN 
                pedido 
            ON 
                detalle_pedido.id_pedido = pedido.id_pedido
            WHERE pedido.id_usuario = ?
            GROUP BY pedido.id_pedido
        ");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $pedidos = [];
        
        // Preparar una sola consulta para obtener los productos de los pedidos
        while ($pedido = $result->fetch_object()) {
            // Convertir la cadena de productos en un array
            $pedido->productos = explode(",", $pedido->productos);
            $pedidos[] = $pedido;
        }
        
        // Cerrar conexiones
        $stmt->close();
        $con->close();
        
        return $pedidos;  // Devolver la lista de pedidos
    }
    
    // // Función auxiliar para obtener los productos por cada pedido
    // public static function productosPorPedido($id_pedido) {
    //     $con = DataBase::connect();
        
    //     // Consulta para obtener los productos de este pedido
    //     $stmt = $con->prepare("SELECT id_producto FROM detalle_pedido WHERE id_pedido = ?");
    //     $stmt->bind_param("i", $id_pedido);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
        
    //     $productos = [];
        
    //     // Recorrer el resultado y agregar los productos al array
    //     while ($producto = $result->fetch_object()) {
    //         $productos[] = $producto;  // Añadir el ID del producto a la lista
    //     }
        
    //     // Cerrar conexiones
    //     $stmt->close();
    //     $con->close();
        
    //     return $productos;  // Devolver el array de productos
    // }

    // Productos
    public static function obtenerProductos(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM producto");

        $stmt->execute();
        $result = $stmt->get_result();

        $productos = [];

        while($producto = $result->fetch_object("ProductoDetalle")) {
            $productos[] = $producto;
        }

        $con->close();

        return $productos;
    }
    
    // Usuarios
    public static function obtenerUsuarios(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM usuario WHERE rol = 'Cliente'");

        $stmt->execute();
        $result = $stmt->get_result();

        $usuarios = [];

        while($usuario = $result->fetch_object("UsuarioDetalle")) {
            $usuarios[] = $usuario;
        }

        $con->close();

        return $usuarios;
    }

}

?>