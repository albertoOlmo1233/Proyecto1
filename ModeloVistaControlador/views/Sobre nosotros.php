<?php 
session_start();
include_once("views/header/header.php"); ?>

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
                    <div class="migas-de-pan sobreNosotros-padding-migas mb-4">
                        <a href="?controller=producto">Inicio</a>
                        <p>-</p>
                        <a href="?controller=producto&action=sobreNosotros">Sobre nosotros</a>
                    </div>
                    <h1 class="p-0 sobreNosotros-padding-h1 mb-3">Sobre nosotros</h1>
                    <span class="descripcion mb-4">
                    En Work and Taste, creemos en crear un entorno inspirador que reúna a entusiastas de la gastronomía y profesionales. Nuestro espacio de coworking único no solo ofrece un escritorio, sino una comunidad donde la creatividad florece. Proporcionamos desde internet de alta velocidad hasta instalaciones de cocina de última generación, permitiéndote trabajar, colaborar e innovar en las artes culinarias.
                    </span>
                    <h2 class="mb-2">Nuestra Misión</h2>
                    <p class="mb-4">Fomentar una comunidad vibrante de amantes de la comida y emprendedores, permitiéndoles conectar, crear y hacer crecer sus negocios.</p>
                    <h2 class="mb-2">Nuestra Visión</h2>
                    <p class="mb-4">Convertirnos en el espacio de coworking de restaurante líder que inspire la creatividad y la colaboración entre los innovadores culinarios.</p>
                    <img src="imagenes/Fondos/sobreNosotros-bienvenida.webp" class="sobreNosotros-imagen" alt="">
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include_once("views/footer/footer.php");
?>
