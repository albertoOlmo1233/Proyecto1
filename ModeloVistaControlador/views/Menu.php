<div id="seccion-nuestraCarta"> 
    <div id="contenido-descripcionCarta">
        <h2>Nuestra carta</h2>
        <!-- Migas de pan -->
        <div class="migas-de-pan">
            <a href="?controller=producto">Inicio</a>
            <a href="?controller=producto&action=Menu">Menu</a>
        </div>
        <p>Start your website from a selection of beautifully crafted templates and customize it to fit your needs</p>
        <nav id="navegacion-productos">
            <a href="?controller=producto&action=menu" class="neutralButton-white">Hamburgesas</a>
            <a href="?controller=producto&action=showPatatas" class="neutralButton-white">Patatas</a>
            <a href="?controller=producto&action=showBebidas" class="neutralButton-white">Bebidas</a>
            <a href="?controller=producto&action=showPostres" class="neutralButton-white">Postres</a>
        </nav>
    </div>
</div>
<!-- Seccion: Productos -->
<div id="seccion-productos">
    <!-- Div modificable
    Dependiendo que boton presionemos, cambiara a un div o a otro  
    -->
    <div id="apartado-x-producto">
        <h3 class="titulo-carta">Hamburgesas</h3>
        <div id="container">
            <?php
            foreach($productos as $producto) {
            ?>
                <!-- <div class="estilo-producto card">
                    <img src="<?=$producto->getImagen();?>" alt="Hamburgesa 1">
                    <div class="contenido-producto">
                        <h3><?=$producto->getNombre();?></h3>
                        <p><?=$producto->getPrecio();?> €</p>
                        <a href="" class="neutralButton-white">Añadir al carrito</a>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-md-6 col-lg-4 col-xl-4">
                        <div class="card" style="width: 21rem;">
                            <a href="?controller=producto&action=show&id=<?=$producto->getID()?>">
                                <img src="<?=$producto->getImagen();?>" onclick="" class="card-img-top" alt="...">
                            </a>
                            <div class="card-body">
                                <h3 class="card-title"><?=$producto->getNombre();?></h3>
                                <p class="card-text"><?=$producto->getPrecio();?> €</p>
                                <a href="" class="neutralButton-white">Añadir al carrito</a>
                            </div>
                        </div>  
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>