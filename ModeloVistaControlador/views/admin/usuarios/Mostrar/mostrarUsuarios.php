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
<div class="mx-auto d-flex flex-column align-items-center vh-100">
<h1>Mostrar usuarios:</h1>
    <table border="1" style="border-collapse: collapse;" class="text-center h-50">
        <thead>
            <tr>
                <th style="border: 1px solid black; padding: 8px;">ID</th>
                <th style="border: 1px solid black; padding: 8px;">Nombre</th>
                <th style="border: 1px solid black; padding: 8px;">Apellidos</th>
                <th style="border: 1px solid black; padding: 8px;">Correo</th>
                <th style="border: 1px solid black; padding: 8px;">Direccion</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($usuarios as $usuario) {
            ?>
                <tr>
                    <td style="border: 1px solid black; padding: 8px;"><?=$usuario->getID();?></td>
                    <td style="border: 1px solid black; padding: 8px;"><?=$usuario->getNombre();?></td>
                    <td style="border: 1px solid black; padding: 8px;"><?=$usuario->getApellidos();?></td>
                    <td style="border: 1px solid black; padding: 8px;"><?=$usuario->getCorreo();?></td>
                    <td style="border: 1px solid black; padding: 8px;"><?=$usuario->getDireccion();?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<?php 
if($_SESSION['usuario']["rol"] != "Admin"){
    include_once("views/footer/footer.php");
} else {
?>
    </section>
<?php 
}
?>