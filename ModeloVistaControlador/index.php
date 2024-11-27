<?php 

// Incluimos los archivos que utilizaremos a continuación
include_once("controllers/productoController.php");
include_once("controllers/userController.php");
include_once("config/parameters.php");

if(!isset($_GET['controller'])){
    // Accedemos a la url por default creada anteriormente y pasarle el controlador
    
    header("Location:". url . "?controller=producto");
}else {
    // En el caso asignamos el controlador a una variable
    $nombre_controller = $_GET['controller']."Controller";
    // Si la clase existe
    if(class_exists($nombre_controller)){
        // Creamos la clase
        $controller = new $nombre_controller();
        // Si 'action' existe en la URL y el metodo dentro de 'productoController' existe
        if(isset($_GET['action']) && method_exists($controller,$_GET['action'])){
            // Crearemos una variable con el valor que le asignemos por url a 'action'
            // EJ: show()
            $action = $_GET['action'];
        }else {
            // En el caso contrario, llamara a una accion por default de 'parameters.php'(index())
            $action=default_action;
        }
        // Llamar al metodo action (Redirigimos al metodo)
        $controller->$action();
    }else {
        echo "No existe el controlador ". $nombre_controller;
    }
}




?>