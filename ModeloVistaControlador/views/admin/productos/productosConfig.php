<style>
    #tablaGeneral th, #tablaGeneral td {
        border: 1px solid black;
        text-align: center; /* Centrar el contenido */
        padding: 8px; /* Espaciado interno */
    }
</style>
<link rel="stylesheet" href="../../css/admin/header-admin.css">
<script src="../../../javascript/admin/productos/productos.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
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

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-9 col-lg-11 mx-auto">
            <h1>Lista de Productos:</h1>
            <div class="row d-flex justify-content-around" id="listaProductos">
            
            </div>
        </div>
    </div>
</div>

</section>