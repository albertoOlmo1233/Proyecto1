<?php 
session_start();
include_once("views/header/header.php"); ?>

<div class="container-fluid p-0">
    <div class="container-fluid fondo">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12 mx-auto">
                <div class="icono-grupo d-flex justify-content-start w-100">
                    <img src="imagenes/Iconos/custom-groups-24.svg" class="d-flex justify-content-start" alt="sobre nosotros" width="125px">
                </div> 
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7 col-md-7 col-sm-12 mx-auto">
                <div id="contenido-sobre-nosotros col-12">
                    <div class="migas-de-pan ">
                        <!-- Migas de pan -->
                        <a href="?controller=producto">Inicio</a>
                        <p>-</p>
                        <a href="?controller=producto&action=sobreNosotros">Sobre nosotros</a>
                    </div>
                    <h1 class="p-0">Sobre nosotros</h1>
                    <span class="descripcion">
                    Creating with Super is more than just building a website; it's about enabling you to communicate with and connect to your audience. Our automatic optimizations take care of the technicalities, so you can focus on creating engaging content, delivered at unbeatable speeds.
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include_once("views/footer/footer.php");
?>
