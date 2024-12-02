<?php 
session_start();
include_once("views/header/header.php");?>
<div class="container-fluid p-0">
    <div class="container-fluid p-0 fondo">
        <div class="row banner-style altura-banner">
            <div class="col-lg-6 col-md-11 col-sm-12 mx-auto position-relative p-0">
                <div class="icono-grupo d-flex justify-content-start w-100 position-absolute ajustar-logo-banner padding-personalizado">
                    <img src="imagenes/Iconos/custom-groups-24.svg" class="d-flex justify-content-start" alt="sobre nosotros" width="125px">
                </div> 
            </div>
        </div>
    </div>
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-6 col-md-11 col-sm-12 mx-auto p-0 padding-personalizado">
                <div id="contenido-sobre-nosotros col-12">
                    <div class="migas-de-pan sobreNosotros-padding-migas">
                        <!-- Migas de pan -->
                        <a href="?controller=producto">Inicio</a>
                        <p>-</p>
                        <a href="?controller=producto&action=sobreNosotros">Contacto</a>
                    </div>
                    <h1 class="p-0 sobreNosotros-padding-h1">Contacto</h1>
                    <span class="descripcion">
                    Creating with Super is more than just building a website; it's about enabling you to communicate with and connect to your audience. Our automatic optimizations take care of the technicalities, so you can focus on creating engaging content, delivered at unbeatable speeds.
                    </span>
                    <img src="imagenes/Fondos/sobreNosotros-bienvenida.webp" class="sobreNosotros-imagen" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
include_once("views/footer/footer.php");
?>
