<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if($_SESSION['usuario']["rol"] === "Admin"){
?>
<section id="panel-administrador" class="d-flex-personalizado">
<?php 
    include_once("views/header/header-admin.php");
} else {
    include_once("views/header/header.php");
}
?>
<h1>Crear usuarios:</h1>
<?php 
if($_SESSION['usuario']["rol"] != "Admin"){
    include_once("views/footer/footer.php");
} else {
?>
    </section>
<?php 
}
?>