<?php 
include_once("models/ProductoDAO.php");
include_once("models/ProductoDetalle.php");
include_once("models/admin/AdminDAO.php");
include_once("models/admin/Logs/LogDetalle.php");

class adminController {
    public function index() {
        $view="views/admin/panel/panel.php";
        include_once 'views/main.php';
    }
    // Usuario
    public function mostrarUsuarios() {
        $view="models/admin/apiTutorial/api.html";
        include_once 'views/main.php';
    }

    public function crearUsuarios() {
        // $logs = AdminDAO::crearUsuarios();
        $view="views/admin/usuarios/Crear/crearUsuarios.php";
        include_once 'views/main.php';
    }
    public function modificarUsuarios() {
        // $logs = AdminDAO::modificarUsuarios();
        $view="views/admin/usuarios/Modificar/modificarUsuarios.php";
        include_once 'views/main.php';
    }
    public function eliminarUsuarios() {
        // $logs = AdminDAO::eliminarUsuarios();
        $view="views/admin/usuarios/Eliminar/eliminarUsuarios.php";
        include_once 'views/main.php';
    }
    
    // Producto
    public function mostrarProductos() {
        $productos = AdminDAO::obtenerProductos();
        $view="views/admin/productos/Mostrar/mostrarProductos.php";
        include_once 'views/main.php';
    }

    // Pedidos 
    public function mostrarPedidos() {
        $usuarios = AdminDAO::obtenerUsuarios();
        $pedidos = AdminDAO::obtenerPedidos();
        $productosAgrupados = AdminDAO::productosAgrupados($pedidos);
        $view="views/admin/pedidos/Mostrar/mostrarPedidos.php";
        include_once 'views/main.php';
    }

    public function logs() {
        $logs = AdminDAO::getLogs();
        $view="views/admin/logs/logs.php";
        include_once 'views/main.php';
    }
}

?>