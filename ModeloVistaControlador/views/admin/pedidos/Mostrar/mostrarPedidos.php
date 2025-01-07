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

<?php if (!empty($pedidos)) { ?>
    <div class="mx-auto d-flex flex-column align-items-center justify-content-center" style="max-height: 70vh; max-width: 90vw; overflow: auto;">
        <h1>Mostrar pedidos:</h1>

        <table border="1" style="border-collapse: collapse; width: 100%;" class="text-center">
            <thead>
                <tr>
                    <th style="border: 1px solid black; padding: 8px;">ID Usuario</th>
                    <th style="border: 1px solid black; padding: 8px;">Correo Usuario</th>
                    <th style="border: 1px solid black; padding: 8px;">ID Productos</th>
                    <th style="border: 1px solid black; padding: 8px;">Cantidad Total</th>
                    <th style="border: 1px solid black; padding: 8px;">Total Pedido</th>
                    <th style="border: 1px solid black; padding: 8px;">Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    
                    // Mostrar los pedidos agrupados
                    foreach ($productosAgrupados as $usuario) {
                ?>
                    <tr>
                        <td style="border: 1px solid black; padding: 8px;">
                            <?= htmlspecialchars($usuario['id_usuario']); ?>
                        </td>
                        <td style="border: 1px solid black; padding: 8px;">
                            <?= htmlspecialchars($usuario['correo_usuario']); ?> <!-- Aquí accedemos a 'correo' -->
                        </td>
                        <td style="border: 1px solid black; padding: 8px;">
                            <?php 
                                // Crear enlaces para cada producto
                                $productoLinks = array_map(function($producto) {
                                    return "<a href='producto.php?id=" . htmlspecialchars($producto) . "' target='_blank'>" . htmlspecialchars($producto) . "</a>";
                                }, $usuario['productos']);
                                echo implode(", ", $productoLinks); // Mostrar enlaces separados por comas
                            ?>
                        </td>
                        <td style="border: 1px solid black; padding: 8px;">
                            <?= htmlspecialchars($usuario['cantidad_total']); ?>
                        </td>
                        <td style="border: 1px solid black; padding: 8px;">
                            <?= htmlspecialchars($usuario['total_pedido']); ?>
                        </td>
                        <td style="border: 1px solid black; padding: 8px;">
                            <?= htmlspecialchars($usuario['fecha']); ?>
                        </td>
                    </tr>
                <?php 
                    }
                ?>
            </tbody>
        </table>
    </div>
<?php } else { ?>
    <p>No hay pedidos disponibles.</p>
<?php } ?>

<?php 
if ($_SESSION['usuario']["rol"] != "Admin") {
    include_once("views/footer/footer.php");
} else {
?>
    </section>
<?php 
}
?>
