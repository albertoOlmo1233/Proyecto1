
<?php include_once("views/header/header.php");?>
<!-- Primera seccion: Bienvenida -->
<section id="fondo-primera-seccion">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col col-md-10 col-lg-8 mx-auto d-flex justify-content-center">
                <div id="seccion-bienvenida" class="">
                    <h1 class="h1-small">¡Bienvenido!</h1>
                    <h1>¿Tienes hambre?</h1>
                    <p class="h1-p">Tu hambre, nuestra especialidad. Explora los sabores únicos que tenemos preparados para ti y
                    disfruta de una experiencia gastronómica sin salir del trabajo!</p>
                    <div id="efecto-pressDown">
                        <a href="?controller=producto&action=menu" class="primaryButton-yellow-2">Pide ya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="seccion-ofertas">
    <!-- <div id="ofertas"> -->
        <div class="container">
            <div class="row pt-5 pb-5">
                <h2 class="h2-fondoNegro text-center">Ofertas</h2>
                <div id="carousel-container">
                    <button id="prev-btn" class="carousel-btn">&#10094;</button>
                    <div id="lista-ofertas">
                        <?php foreach ($ofertas as $index => $oferta) { ?>
                            <div class="estilo-oferta col col-4">
                                <div class="imagenes-compuestas">
                                    <div class="img-oferta">
                                        <img src="<?= $oferta->getImagen(); ?>" class="card-img-top" alt="oferta<?= $oferta->getID(); ?>-productos">
                                    </div>
                                    <div class="img-icono-oferta">
                                        <img src="imagenes/Iconos/Descuento.png" alt="Oferta">
                                    </div>
                                </div>
                                <p class="h3-p-fondoNegro-variante-1 separacion-oferta"><?= $oferta->getCategoria(); ?></p>
                                <h3 class="h3-fondoNegro"><?= $oferta->getNombre(); ?></h3>
                                <p class="h3-p-fondoNegro"><?= $oferta->getDescripcion(); ?></p>
                            </div>
                        <?php } ?>
                    </div>
                    <button id="next-btn" class="carousel-btn">&#10095;</button>
                </div>
            </div>
        </div>
    <!-- </div> -->
</section>

<script src="javascript/inicio-carrousel.js"></script>

<!-- Seccion: Sobre nosotros -->
<section id="seccion-sobreNosotros">
    <div class="container">
        <div class="row">
            <div class="col-12 contenido-texto">
                <div id="contenido-sobreNosotros">
                    <h2>¡Nuestra historia!</h2>
                    <p>Desde 2010, hemos dedicado nuestra pasion a ofrecer hamburgesas que celebran la frescura y los sabores auténticos. Cada plato cuenta una historia y está hecho con los mejores ingredientes...</p>
                    <a href="views/Sobre nosotros.php" class="neutralButton-white">Leer mas</a>
                    <img src="imagenes/Fondos/imagen-sobreNosotros.webp" class="w-100" alt="">
                </div> 
            </div>
        </div>
    </div>
</section>

<!-- Seccion: Contacto -->

<section id="seccion-contacto">
<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 contenido-texto">
            <h2 class="h2-fondoNegro">¿Tienes alguna duda?</h2>
            <p class="h2-p-fondoNegro">We think Super is the best way to publish content online which is why we use it for all our sites. The content for this site (the one you are reading now), is all coming from Notion.</p>
            <a href="views/Contacto.php" class="neutralButton-white">Contactanos!</a>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <img src="imagenes/Fondos/imagen-contacto.webp" class="w-100" alt="">
        </div>
    </div>
</div>
</section>