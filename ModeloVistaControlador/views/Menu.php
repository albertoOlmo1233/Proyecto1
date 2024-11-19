<?php include_once("views/header/header.php");?>
<section id="seccion-nuestraCarta">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-12 col-sm-9 col-lg-9">
                <div id="contenido-descripcionCarta">
                    <h2>Nuestra carta</h2>
                    <!-- Migas de pan -->
                    <div class="migas-de-pan">
                        <a href="?controller=producto">Inicio</a>
                        <a href="?controller=producto&action=Menu">Menu</a>
                    </div>
                    <p>Start your website from a selection of beautifully crafted templates and customize it to fit your needs</p>
                    <nav id="navegacion-productos">
                        <a href="?controller=producto&action=menu" class="neutralButton-white">Hamburgesas</a>
                        <a href="?controller=producto&action=showPatatas" class="neutralButton-white">Patatas</a>
                        <a href="?controller=producto&action=showBebidas" class="neutralButton-white">Bebidas</a>
                        <a href="?controller=producto&action=showPostres" class="neutralButton-white">Postres</a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- seccion: Productos -->

<section id="seccion-productos">
    <div class="container"> <!-- Usa container-fluid para eliminar los márgenes -->
        <div class="row g-4 d-flex justify-content-center"> <!-- Sin espacio entre columnas -->
            <div class="col-sm-12 col-sm-9 col-lg-9">
                <div class="row">
                <h3 class="titulo-carta"><?=$tituloProducto?></h3>
                    <?php
                        foreach($productos as $producto) {
                    ?>
                        <div class="col-sm-12 col-md-6 col-lg-4 mt-0"> <!-- Sin padding horizontal -->
                            <div class="card h-100" style="width: 100%;"> 
                                <a href="?controller=producto&action=show&id=<?=$producto->getID()?>">
                                    <img src="<?=$producto->getImagen();?>" class="card-img-top" alt="Imagen del producto">
                                </a>
                                <div class="card-body">
                                    <h3 class="card-title"><?=$producto->getNombre();?></h3>
                                    <p class="card-text"><?=$producto->getPrecio();?> €</p>
                                    <a href="" class="neutralButton-white">Añadir al carrito</a>
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


