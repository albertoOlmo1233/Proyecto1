<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION['usuario']["rol"] === "Admin") {
?>
<section id="panel-administrador" class="d-flex-personalizado">
<?php 
    include_once("views/header/header-admin.php");
} else {
    include_once("views/header/header.php");
}
?>

<div class="mx-auto d-flex align-items-center vh-50">
    <div class="table-responsive" style="max-height: 800px; overflow-y: auto;"> <!-- Contenedor con scroll -->
        <table border="1" style="border-collapse: collapse;" class="text-center" >
            <thead>
                <tr>
                    <th style="border: 1px solid black; padding: 8px;">Correo</th>
                    <th style="border: 1px solid black; padding: 8px;">Mensaje</th>
                    <th style="border: 1px solid black; padding: 8px;">Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Comprobar si hay logs disponibles
                if (isset($logs) && !empty($logs)) {
                    foreach ($logs as $log) {
                ?>
                    <tr>
                        <td style="border: 1px solid black; padding: 8px;"><?=$log->getCorreo();?></td>
                        <td style="border: 1px solid black; padding: 8px;"><?=$log->getMensaje();?></td>
                        <td style="border: 1px solid black; padding: 8px;"><?=$log->getFecha();?></td>
                    </tr>
                <?php
                    }
                } else {
                    // Mensaje si no hay logs disponibles
                    echo "<tr><td colspan='3' style='border: 1px solid black; padding: 8px;'>No hay registros disponibles.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
if ($_SESSION['usuario']["rol"] != "Admin") {
    include_once("views/footer/footer.php");
} else {
?>
    </section>
<?php 
}
?>
