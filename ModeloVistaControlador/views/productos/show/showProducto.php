<?php session_start(); 
include_once("views/header/header.php");?>

<div class="container-fluid">
    <div class="row">
        <!-- Contenedor para el título y las migas de pan -->
        <div class="col-12" id="seccion-titulo-detalleProducto">
            <div id="contenido-titulo-detalleProducto">
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

        <!-- Contenedor para el detalle del producto -->
        <div class="col-12 col-md-7 col-lg-8 mx-auto">
            <div class="container">
                <div class="row g-4">
                    <!-- Apartado del producto -->
                    <div class="col-12 col-md-7 col-lg-6">
                        <div class="apartado-producto">
                            <h2><?=$detalleProducto->getNombre();?></h2>
                            <p class="h2-p"><?=$detalleProducto->getDescripcion();?></p>
                            <h3><?=$detalleProducto->getPrecio();?>€</h3>
                            <img src="<?=$detalleProducto->getImagen();?>" alt="<?=$detalleProducto->getNombre();?>">
                        </div>
                    </div>

                    <!-- Apartado de los ingredientes -->
                    <div class="col-12 col-md-5 col-lg-6">
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
            </div> 
        </div>
    </div>
</div>
