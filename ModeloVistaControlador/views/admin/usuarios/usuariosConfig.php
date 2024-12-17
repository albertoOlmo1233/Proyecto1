
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="../../css/admin/header-admin.css">
    <style>
        #tablaGeneral th, #tablaGeneral td {
            border: 1px solid black;
            text-align: center; /* Centrar el contenido */
            padding: 8px; /* Espaciado interno */
        }
    </style>
    <!-- JS de configuración del usuario -->
    <script src="../../../javascript/admin/usuarios/usuarios.js"></script>
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
 <!-- Tabla -->
<div>

    <div class="container cuenta py-5">
        <div class="card cuenta border-0 justify-content-start p-5 position-relative overflow-visible">
            <div class="contenido-cuenta d-flex flex-column h-auto gap-3">
                <h2>Lista de Usuarios</h2>
                <table id="tablaGeneral"></table>
            </div>
        </div>
    </div>
</div>

    </section>
    
</body>
</html>
