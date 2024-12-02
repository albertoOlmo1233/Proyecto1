<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if($_SESSION['usuario']["rol"] === "Admin"){
?>
<section id="panel-administrador" class="d-flex">
<?php 
    include_once("views/header/header-admin.php");
} else {
    include_once("views/header/header.php");
}
?>
<section id="seccion-menu d-flex">
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
                                        <a href="?controller=producto&action=añadirCarrito&id_producto=<?=$producto->getID()?>" class="neutralButton-white">Añadir al carrito</a>
                                    </div>
                                </div>
                            </div>
                        <?php
                            }
                        ?>
                    </div>
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
    </section>
</section>


<?php 
if($_SESSION['usuario']["rol"] != "Admin"){
    include_once("views/footer/footer.php");
} else {
?>
    </section>
<?php 
}
?>