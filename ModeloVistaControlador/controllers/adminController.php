<?php 
include_once("models/ProductoDAO.php");
include_once("models/ProductoDetalle.php");
include_once("models/admin/AdminDAO.php");
include_once("models/admin/Logs/LogDetalle.php");
include_once("controllers/userController.php");

// Controlador para la administración
class adminController {
    // Muestra la vista principal del administrador
    public function index() {
        UsuarioDAO::comprobarSesion();
        $view = "views/cuenta/Cuenta.php";
        include_once 'views/main.php';
    }

    // Configuración de usuarios
    public function usuariosConfig() {
        UsuarioDAO::comprobarSesion();
        UsuarioDAO::esAdmin();
        $view = "views/admin/usuarios/usuariosConfig.php";
        include_once 'views/main.php';
    }
    
    // Configuración de productos
    public function productosConfig() {
        UsuarioDAO::comprobarSesion();
        UsuarioDAO::esAdmin();
        $view = "views/admin/productos/productosConfig.php";
        include_once 'views/main.php';
    }

    // Configuración de pedidos
    public function pedidosConfig() {
        UsuarioDAO::comprobarSesion();
        UsuarioDAO::esAdmin();
        $detalleProducto = userController::mostrarDetallesProducto();
        $view = "views/admin/pedidos/pedidosConfig.php";
        include_once 'views/main.php';
    }

    // Muestra los logs del sistema
    public function logs() {
        UsuarioDAO::comprobarSesion();
        UsuarioDAO::esAdmin();
        $logs = AdminDAO::getLogs();
        $view = "views/admin/logs/logs.php";
        include_once 'views/main.php';
    }
}
?>