<div id="seccion-productoDetalle"> 
    <div id="contenido-productoDetalle">
        <h1><?=$detalleProducto->getNombre();?></h1>
        <div class="migas-de-pan">
            <!-- Migas de pan -->
            <a href="?controller=producto">Inicio</a>
            <p>-</p>
            <a href="?controller=producto&action=Menu">Menu</a>
            <p>-</p>
            <a href="?controller=producto&action=Menu"><?=$detalleProducto->getNombre();?></a>
        </div>
    </div>
</div>
<div id="seccion-detalleProducto">
    <div id="contenido-detalleProducto">
        <div class="apartado-producto">
            <h2><?=$detalleProducto->getNombre();?></h2>
            <p><?=$detalleProducto->getDescripcion();?></p>
            <h3><?=$detalleProducto->getPrecio();?>€</h3>
            <img src="<?=$detalleProducto->getImagen();?>" alt="">
        </div>
        <div class="apartado-ingredientes">
            <h3>Extras:</h3>
            <form action="">
                <?php
                    foreach($detalleIngredientes as $ingrediente) {
                ?>
                <div class="ingredientes">
                    <input type="checkbox" class="tamaño-checkbox">
                    <label for=""><?=$ingrediente->getNombre();?> extra (+<?=$ingrediente->getPrecio();?>€)</label>
                </div>
                <?php
                    }
                ?>
                <div class="cantidad-pedido">
                    <input type="text" class="numero-productos" placeholder="1">
                    <input type="submit" value="Añadir al carrito" class="primaryButton-yellow-1">
                </div>
            </form>
        </div>
    </div>
</div>