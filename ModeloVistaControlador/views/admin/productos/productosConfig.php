
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="../../css/admin/header-admin.css">
    <style>
        #tablaGeneral th, #tablaGeneral td {
            border: 1px solid black;
            text-align: center; /* Centrar el contenido */
            padding: 8px; /* Espaciado interno */
        }
    </style>
    <!-- JS de configuración del usuario -->
    <script src="../../../javascript/admin/productos/productos.js"></script>
</head>
<body>
<!-- Sidebar -->
<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION['usuario']["rol"] === "Admin") {
?>
<section id="panel-administrador" class="d-flex-personalizado">
    <!-- HEADER -->
<?php 
    include_once("views/header/header-admin.php");
} else {
    include_once("views/header/header.php");
}
?>
 <!-- Tabla -->
<div>
    <h2>Lista de Productos</h2>
    <table id="tablaGeneral"></table>
</div>
</section>
<?php 
if($_SESSION['usuario']["rol"] != "Admin"){
    include_once("views/footer/footer.php");
} else {
    include_once("views/footer/footer.php");
}
?>
</body>
</html>
