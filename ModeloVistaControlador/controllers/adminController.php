<?php 
include_once("models/ProductoDAO.php");
include_once("models/ProductoDetalle.php");
include_once("models/admin/AdminDAO.php");
include_once("models/admin/Logs/LogDetalle.php");
include_once("controllers/userController.php");

class adminController {
    public function index() {
        UsuarioDAO::comprobarSesion();
        $view="views/admin/panel/panel.php";
        include_once 'views/main.php';
    }

    // Usuario
    // Redirigir
    public function usuariosConfig() {
        UsuarioDAO::comprobarSesion();
        $view="views/admin/usuarios/usuariosConfig.php";
        include_once 'views/main.php';
    }
    
    // Producto
    public function productosConfig() {
        UsuarioDAO::comprobarSesion();
        $view="views/admin/productos/productosConfig.php";
        include_once 'views/main.php';
    }

    public function pedidosConfig() {
        UsuarioDAO::comprobarSesion();
        $detalleProducto = userController::mostrarDetallesProducto();
        $view="views/admin/pedidos/pedidosConfig.php";
        include_once 'views/main.php';
    }

    public function logs() {
        UsuarioDAO::comprobarSesion();
        $logs = AdminDAO::getLogs();
        $view="views/admin/logs/logs.php";
        include_once 'views/main.php';
    }
}

?>