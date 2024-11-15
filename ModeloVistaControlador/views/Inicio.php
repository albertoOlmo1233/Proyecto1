<!-- Primera seccion: Bienvenida -->
<section id="fondo-primera-seccion">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col col-md-10 col-lg-8 mx-auto">
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
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col col-md-10 col-lg-8 mx-auto">
                <div id="ofertas">
                    <h2 class="h2-fondoNegro">Ofertas</h2>
                    <div id="carousel-container">
                        <button id="prev-btn" class="carousel-btn">&#10094;</button>
                        <div id="lista-ofertas">
                            <?php foreach ($ofertas as $index => $oferta) { ?>
                                <div class="estilo-oferta">
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
        </div>
    </div>
</section>
<script>
    const listaOfertas = document.getElementById('lista-ofertas');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const ofertaWidth = document.querySelector('.estilo-oferta').offsetWidth + 20; // Ancho de cada oferta + gap
    let currentPosition = 0;

    nextBtn.addEventListener('click', () => {
        const maxScrollPosition = listaOfertas.scrollWidth - listaOfertas.clientWidth;
        if (currentPosition < maxScrollPosition) {
            currentPosition += ofertaWidth * 3;
            if (currentPosition > maxScrollPosition) {
                currentPosition = maxScrollPosition; // Limitar al final
            }
            listaOfertas.style.transform = `translateX(-${currentPosition}px)`;
        }
    });

    prevBtn.addEventListener('click', () => {
        if (currentPosition > 0) {
            currentPosition -= ofertaWidth * 3;
            if (currentPosition < 0) {
                currentPosition = 0; // Limitar al inicio
            }
            listaOfertas.style.transform = `translateX(-${currentPosition}px)`;
        }
    });
</script>

<!-- Seccion: Sobre nosotros -->
<section id="seccion-sobreNosotros">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col col-md-10 col-lg-8 mx-auto">
                <div id="contenido-sobreNosotros">
                    <h2>¡Nuestra historia!</h2>
                    <p>Desde 2010, hemos dedicado nuestra pasion a ofrecer hamburgesas que celebran la frescura y los sabores auténticos. Cada plato cuenta una historia y está hecho con los mejores ingredientes...</p>
                    <a href="views/Sobre nosotros.php" class="neutralButton-white">Leer mas</a>
                    <img src="imagenes/Fondos/imagen-sobreNosotros.webp" alt="">
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