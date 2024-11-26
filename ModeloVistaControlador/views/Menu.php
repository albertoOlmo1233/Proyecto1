<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("views/header/header.php");?>
<section id="seccion-nuestraCarta">
    <div class="container-fluid">
        <div class="row">
            <!-- Columna centrada con mx-auto -->
            <div class="col-12 col-sm-9 col-lg-9 mx-auto">
                <div id="contenido-descripcionCarta">
                    <h2>Nuestra carta</h2>
                    <!-- Migas de pan -->
                    <div class="migas-de-pan">
                        <a href="?controller=producto">Inicio</a>
                        <a href="?controller=producto&action=Menu">Menú</a>
                    </div>
                    <p class="h2-p">Start your website from a selection of beautifully crafted templates and customize it to fit your needs</p>
                    <nav id="navegacion-productos">
                        <a href="?controller=producto&action=menu" class="neutralButton-white h2-p opacity-100">Hamburguesas</a>
                        <a href="?controller=producto&action=showPatatas" class="neutralButton-white h2-p">Patatas</a>
                        <a href="?controller=producto&action=showBebidas" class="neutralButton-white h2-p">Bebidas</a>
                        <a href="?controller=producto&action=showPostres" class="neutralButton-white h2-p">Postres</a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Seccion: Productos -->

<section id="seccion-productos">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-9 col-lg-9 mx-auto">
                <div class="row g-5">
                <h3 class="titulo-carta"><?=$tituloProducto?></h3>
                    <?php
                        foreach($productos as $producto) {
                    ?>
                        <div class="col-xm-12 col-sm-6 col-md-6 col-lg-4 mt-0 mb-5">
                            <div class="card h-100 w-100" id="producto-<?=$producto->getID();?>"> 
                                <a href="?controller=producto&action=show&id=<?=$producto->getID()?>">
                                    <img src="<?=$producto->getImagen();?>" class="card-img-top" alt="<?=$producto->getNombre();?>">
                                </a>
                                <div class="card-body">
                                    <h3 class="card-title"><?=$producto->getNombre();?></h3>
                                    <p class="card-text h3-p"><?=$producto->getPrecio();?> €</p>
                                    <a href="?controller=producto&action=añadirCarrito&id=<?=$producto->getID()?>" class="neutralButton-white">Añadir al carrito</a>
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>


<?php 
include_once("views/footer/footer.php");
?>