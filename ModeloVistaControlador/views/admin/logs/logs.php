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

<div class="mx-auto d-flex align-items-center vh-100">
    <table border="1" style="border-collapse: collapse;" class="text-center h-50">
        <thead>
            <tr>
                <th style="border: 1px solid black; padding: 8px;">Correo</th>
                <th style="border: 1px solid black; padding: 8px;">Mensaje</th>
                <th style="border: 1px solid black; padding: 8px;">Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($logs as $log) {
            ?>
                <tr>
                    <td style="border: 1px solid black; padding: 8px;"><?=$log->getCorreo();?></td>
                    <td style="border: 1px solid black; padding: 8px;"><?=$log->getMensaje();?></td>
                    <td style="border: 1px solid black; padding: 8px;"><?=$log->getFecha();?></td>
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
