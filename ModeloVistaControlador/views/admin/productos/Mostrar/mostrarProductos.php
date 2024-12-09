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
    <table border="1" style="border-collapse: collapse; width: 100%;" class="text-center">
        <thead>
            <tr>
                <th style="border: 1px solid black; padding: 8px;">ID</th>
                <th style="border: 1px solid black; padding: 8px;">Nombre</th>
                <th style="border: 1px solid black; padding: 8px;">Descripcion</th>
                <th style="border: 1px solid black; padding: 8px;">Precio</th>
                <th style="border: 1px solid black; padding: 8px;">ID_oferta</th>
                <th style="border: 1px solid black; padding: 8px;">Imagen</th>
                <th style="border: 1px solid black; padding: 8px;">Categoria</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($productos as $producto) {
            ?>
                <tr>
                    <td style="border: 1px solid black; padding: 8px;"><?=$producto->getID();?></td>
                    <td style="border: 1px solid black; padding: 8px;"><?=$producto->getNombre();?></td>
                    <td style="border: 1px solid black; padding: 8px;"><?=$producto->getDescripcion();?></td>
                    <td style="border: 1px solid black; padding: 8px;"><?=$producto->getPrecio();?></td>
                    <td style="border: 1px solid black; padding: 8px;"><?=$producto->getIdOferta();?></td>
                    <td style="border: 1px solid black; padding: 8px;">
                        <img src="<?=$producto->getImagen();?>" alt="Producto" style="max-width: 100px; max-height: 100px;">
                    </td>
                    <td style="border: 1px solid black; padding: 8px;"><?=$producto->getCategoria();?></td>
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
