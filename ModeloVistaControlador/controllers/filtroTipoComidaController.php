<?php 
include_once("models/HamburgesasDAO.php");
include_once("models/PatatasDAO.php");
include_once("models/BebidasDAO.php");
include_once("models/PostresDAO.php");

class filtroTipoComidaController {
    public function showPatatas() {
        $productos = ProductoDAO::getType("Patatas");
        $view="views/Menu.php";
        include_once 'views/main.php';
    }

    public function showBebidas(){
        $productos = ProductoDAO::getType("Bebidas");
        $view="views/Menu.php";
        include_once 'views/main.php';
    }

    public function showPostres() {
        $productos = ProductoDAO::getType("Postre");
        $view="views/Menu.php";
        include_once 'views/main.php';
    }

}

?>