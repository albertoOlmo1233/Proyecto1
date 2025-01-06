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
                    <div class="migas-de-pan sobreNosotros-padding-migas">
                        <a href="?controller=producto">Inicio</a>
                        <p>-</p>
                        <a href="?controller=producto&action=sobreNosotros">Contacto</a>
                    </div>
                    <h1 class="p-0 sobreNosotros-padding-h1">Contacto</h1>
                    <span class="descripcion">
                    Creando con Super es más que solo construir un sitio web; se trata de permitirte comunicarte y conectar con tu audiencia. Nuestras optimizaciones automáticas se encargan de las cuestiones técnicas, para que puedas centrarte en crear contenido atractivo, entregado a velocidades inigualables.
                    </span>
                    <h2>Ponte en contacto con Work and Taste</h2>
                    <p>Para consultas, reservas o cualquier pregunta, no dudes en ponerte en contacto con nosotros:</p>
                    <ul>
                        <li><strong>Correo Electrónico:</strong> <a href="mailto:info@workandtaste.com">info@workandtaste.com</a></li>
                        <li><strong>Teléfono:</strong> <a href="tel:+1234567890">+1 (234) 567-890</a></li>
                        <li><strong>Dirección:</strong> 123 Culinary Lane, Food City, FL 12345</li>
                    </ul>
                    <img src="imagenes/Fondos/contacto-bienvenida.webp" class="sobreNosotros-imagen" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
include_once("views/footer/footer.php");
?>
