<?php session_start(); 
include_once("views/header/header.php");
?>

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
                            <?php if ($detalleProducto->getPrecioOferta()){ ?>
                                <div class="d-flex flex-row gap-3">
                                    <h3 class="card-text text-decoration-line-through"><?=$detalleProducto->getPrecio();?> €</h3>
                                    <h3 class="card-text"><?=$detalleProducto->getPrecioOferta();?> €</h3>
                                </div>
                            <?php } else { ?>
                                <h3><?=$detalleProducto->getPrecio();?>€</h3>
                            <?php } ?>
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
                                    <a href="?controller=producto&action=añadirCarrito&id_producto=<?=$detalleProducto->getID()?>" class="primaryButton-yellow-1">Añadir al carrito</a>
                                </div>
                            </form>
                            <!-- Aqui quiero un div flotante invisible, que cuando al agregar un producto, aparezca por unos segundos ocupando toda la pantalla para mostrar el aviso. -->
                            <div id="contenedor" class="hidden">
                                    <div class="contenido-contenedor">
                                        <?php if (isset($_SESSION['error']) && $_SESSION['error'] != ""): ?>
                                            <div class="alert alert-danger mt-3 w-100 h-100 text-center d-flex flex-column justify-content-center" id="alert-error">
                                                <?php echo $_SESSION['error']; ?>
                                            </div>
                                            <?php unset($_SESSION['error']); ?>
                                        <?php elseif (isset($_SESSION['confirmacion']) && $_SESSION['confirmacion'] != ""): ?>
                                            <div class="alert alert-success mt-3 w-100 h-100 text-center d-flex flex-column justify-content-center" id="alert-confirmacion">
                                                <?php echo $_SESSION['confirmacion']; ?>
                                            </div>
                                            <?php unset($_SESSION['confirmacion']); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                    const contenedor = document.getElementById('contenedor');
                                    const alertError = document.getElementById('alert-error');
                                    const alertConfirmacion = document.getElementById('alert-confirmacion');

                                    // Mostrar el contenedor si hay un mensaje
                                    if (alertError || alertConfirmacion) {
                                        contenedor.classList.remove('hidden'); // Mostrar el contenedor
                                        contenedor.style.animation = "fadeIn 0.5s forwards";

                                        // Desaparecer después de 3 segundos
                                        setTimeout(() => {
                                            contenedor.style.animation = "fadeOut 0.5s forwards";
                                            setTimeout(() => {
                                                contenedor.classList.add('hidden'); // Ocultar después de la animación
                                            }, 500); // Tiempo de la animación de fadeOut
                                        }, 1000); // Tiempo antes de desaparecer
                                    }
                                });
                                </script>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
