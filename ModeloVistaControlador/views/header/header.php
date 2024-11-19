<header class="sticky-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 col-md-4 contenido-texto d-flex">
                <a href="?controller=producto">
                    <div id="Logo" aria-label="Logo del sitio">
                        <div class="logo-1">
                            <img src="imagenes/Logo/Logo entero color.svg" alt="Logo color">
                        </div>

                        <div class="logo-2">
                            <img src="imagenes/Logo/Logo Letra color.png" alt="Logo color">
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-10 col-md-8 d-flex justify-content-end align-items-center">
                <nav id="seccion-menu">
                    <a href="?controller=producto&action=menu" class="apartado-menu">Menu</a>
                    <a href="?controller=producto&action=sobreNosotros" class="apartado-sobreNosotros">Sobre nosotros</a>
                    <a href="?controller=producto&action=contacto" class="apartado-contacto">Contacto</a>
                    <!-- Si el usuario no esta iniciado sesion se mostrara el div de abajo -->
                    <?
                    
                    if(!isset($_SESSION['usuario'])) {?>
                        <div class="iniciarSesion d-flex align-items-center">
                            <a href="?controller=user" class="primaryButton-yellow-1">Iniciar sesión</a>
                        </div>
                    <?} else {?>
                    <!-- Por otro lado, si el usuario inicia sesion se mostrara el de abajo -->
                    <div class="iniciadoSesion d-flex align-items-center">
                        <img src="imagenes/Iconos/person-24.svg" alt="">
                        <img src="imagenes/Iconos/shopping-cart-24.svg" alt="">
                    </div>
                    <?}?>
                    

                </nav> 
                 <!-- Responsive -->
                 <div class="menu">
                    <div class="dropdown">
                        <button class="dropdown-btn" aria-label="Abrir menú">
                            <img src="imagenes/Iconos/menu-24.svg" class="icono-menu" alt="Menú">
                            <img src="imagenes/Iconos/close-24.svg" class="icono-close" alt="Close">
                        </button>
                        <div class="contenido">
                            <a href="?controller=producto" class="apartado-menu">Inicio</a>
                            <a href="?controller=producto&action=menu" class="apartado-menu">Menu</a>
                            <a href="?controller=producto&action=sobreNosotros" class="apartado-sobreNosotros">Sobre nosotros</a>
                            <a href="?controller=producto&action=contacto" class="apartado-contacto">Contacto</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script src="transparent-header.js"></script>