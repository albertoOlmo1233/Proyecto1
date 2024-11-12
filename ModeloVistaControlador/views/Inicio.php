<!-- Primera seccion: Bienvenida -->
<section id="fondo-primera-seccion">
    <div id="seccion-bienvenida">
        <h1 class="h1-small">¡Bienvenido!</h1>
        <h1>¿Tienes hambre?</h1>
        <p class="h1-p">Tu hambre, nuestra especialidad. Explora los sabores únicos que tenemos preparados para ti y
            disfruta de una experiencia gastronómica sin salir del trabajo!</p>
        <div id="efecto-pressDown">
            <a href="?controller=producto&action=menu" class="primaryButton-yellow-2">Pide ya</a>
        </div>
    </div>
</section>

<!-- Seccion oferta -->
<section id="seccion-ofertas">
    <div id="ofertas">
        <h2 class="h2-fondoNegro">Ofertas</h2>
        <div id="lista-ofertas">
        <?php
            $first = true;
            foreach ($ofertas as $oferta) {
                var_dump($oferta);
            ?>
        <div class="carousel-itemm <?= $first ? 'active' : '' ?>">
            <div class="col-md-4">
                <div class="card">
                    <div class="img-wrapper">
                        <img src="<?= $oferta->getImagen(); ?>" class="d-block w-100" alt="...">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $oferta->getCategoria(); ?></h5>
                        <h3 class="card-title"><?= $oferta->getNombre(); ?></h3>
                        <p class="card-text"><?= $oferta->getDescripcion(); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php
            $first = false;
            }
            ?>
                    
            
        </div>
    </div>
</section>

<script>
    // Selecciona el carrusel
    document.addEventListener('DOMContentLoaded', function () {
        const carouselElement = document.querySelector('#miCarrusel'); // Cambia #miCarrusel por el id real del carrusel

        if (carouselElement) {
            const carousel = new bootstrap.Carousel(carouselElement, {
                interval: 2000,
                wrap: true
            });

            // Añade un evento al carrusel para manejar el movimiento de tres elementos
            carouselElement.addEventListener('slide.bs.carousel', function (e) {
                const itemsPerSlide = 3;
                const totalItems = document.querySelectorAll('.carousel-item').length;
                const items = document.querySelectorAll('.carousel-item');

                // Comprueba si el índice actual está alcanzando el final del carrusel
                if (e.to >= totalItems - (itemsPerSlide - 1)) {
                    for (let i = 0; i < itemsPerSlide; i++) {
                        // Mueve los elementos del principio al final
                        if (e.direction === 'left') {
                            items[0].parentNode.append(items[0]);
                        } else {
                            items[totalItems - 1].parentNode.prepend(items[totalItems - 1]);
                        }
                    }
                }
            });
        }
    });
</script>

<!-- Seccion: Sobre nosotros -->
<section id="seccion-sobreNosotros">
    <div id="contenido-sobreNosotros">
        <h2>¡Nuestra historia!</h2>
        <p>Desde 2010, hemos dedicado nuestra pasion a ofrecer hamburgesas que celebran la frescura y los sabores auténticos. Cada plato cuenta una historia y está hecho con los mejores ingredientes...</p>
        <a href="views/Sobre nosotros.php" class="neutralButton-white">Leer mas</a>
        <img src="imagenes/Fondos/imagen-sobreNosotros.png" alt="">
    </div>
</section>

<!-- Seccion: Contacto -->
<section id="seccion-contacto">
    <div id="contenido-contacto">
        <div class="contenido-texto">
            <h2 class="h2-fondoNegro">¿Tienes alguna duda?</h2>
            <p class="h2-p-fondoNegro">We think Super is the best way to publish content online which is why we use it for all our sites. The content for this site (the one you are reading now), is all coming from Notion.</p>
            <a href="views/Contacto.php" class="neutralButton-white">Contactanos!</a>
        </div>
        <div class="contenido-imagen">
            <img src="imagenes/Fondos/imagen-contacto.png" alt="">
        </div>
    </div>
</section>