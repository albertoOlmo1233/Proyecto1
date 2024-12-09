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

        // Primera consulta: obtener los pedidos
        $stmt = $con->prepare("SELECT 
            detalle_pedido.id_pedido,
            detalle_pedido.cantidad,
            detalle_pedido.id_producto,
            pedido.id_usuario,
            pedido.Fecha,
            pedido.total_pedido
        FROM 
            detalle_pedido
        INNER JOIN 
            pedido 
        ON 
            detalle_pedido.id_pedido = pedido.id_pedido;");

        $stmt->execute();
        $result = $stmt->get_result();

        $pedidos = [];

        // Preparar la segunda consulta por adelantado
        $stmt1 = $con->prepare("SELECT correo FROM usuario WHERE id_usuario = ?");

        while ($pedido = $result->fetch_object()) {
            // Almacenar el id_usuario de la fila actual
            $id_usuario = $pedido->id_usuario;

            // Ejecutar la segunda consulta para obtener el correo del usuario
            $stmt1->bind_param("i", $id_usuario);
            $stmt1->execute();
            $resultCorreo = $stmt1->get_result();

            // Verificar si se obtuvo un correo
            if ($correo = $resultCorreo->fetch_object()) {
                $pedido->correo = $correo->correo; // Agregar el correo al objeto pedido
            } else {
                $pedido->correo = null; // Si no se encontró, asignar null
            }

            // Agregar el pedido al array
            $pedidos[] = $pedido;
        }

        // Cerrar conexiones
        $stmt->close();
        $stmt1->close();
        $con->close();

        return $pedidos;
    }

    // Esta funcion sirve para agrupar en una misma celda los productos de cada pedido.
    public static function productosAgrupados($pedidos){
        // Agrupar pedidos por id_usuario
        $productosAgrupados = [];
        foreach ($pedidos as $pedido) {
            $id_usuario = $pedido->id_usuario;
            if (!isset($productosAgrupados[$id_usuario])) {
                $productosAgrupados[$id_usuario] = [
                    'id_usuario' => $pedido->id_usuario,
                    'correo_usuario' => $pedido->correo,
                    'productos' => [],
                    'cantidad_total' => 0,
                    'total_pedido' => 0,
                    'fecha' => $pedido->Fecha
                ];
            }

            // Acumular datos del pedido
            $productosAgrupados[$id_usuario]['productos'][] = $pedido->id_producto;
            $productosAgrupados[$id_usuario]['cantidad_total'] += $pedido->cantidad;
            $productosAgrupados[$id_usuario]['total_pedido'] += $pedido->total_pedido;
        }
        return $productosAgrupados;
    }

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