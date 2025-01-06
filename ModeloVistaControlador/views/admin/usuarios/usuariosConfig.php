

<title>Gestión de Usuarios</title>
<link rel="stylesheet" href="../../css/admin/header-admin.css">
<script src="../../../javascript/cuenta/funciones-configuracion-cuenta.js" defer></script>
<!-- JS de configuración del usuario -->
<script src="../../../javascript/admin/usuarios/usuarios.js" defer></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
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
        <div class="col-sm-12 col-md-9 col-lg-9 mx-auto vh-100 d-flex align-items-center">
            <div class="row d-flex justify-content-around" id="listaUsuarios">
            
            </div>
        </div>
    </div>
</div>

</section>
    
</body>
</html>
