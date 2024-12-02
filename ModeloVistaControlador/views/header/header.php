<?php 
    if (!isset($_SESSION['usuario'])) { 
        $texto_login_cuenta= "Iniciar sesión";
    } else { 
        $texto_login_cuenta= "Cuenta";
    }
?>
<header class="sticky-top">
    <div class="container-fluid px-0 h-100">
        <div class="row">
            <div class="col-8 col-sm-6 col-md-4 d-flex">
                <a href="?controller=producto">
                    <div id="Logo" aria-label="Logo del sitio">
                        <div class="logo-1">
                            <img src="imagenes/Logo/Logo entero color.svg" alt="Logo entero color">
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-4 col-sm-6 col-md-8 d-flex justify-content-end align-items-center">
                <nav id="seccion-menu">
                    <a href="?controller=producto&action=menu" class="apartado-menu">Menu</a>
                    <a href="?controller=producto&action=sobreNosotros" class="apartado-sobreNosotros">Sobre nosotros</a>
                    <a href="?controller=producto&action=contacto" class="apartado-contacto">Contacto</a>
                    <?php if (!isset($_SESSION['usuario'])) { ?>
                        <a href="?controller=user" class="primaryButton-yellow-1 opacity-100">Iniciar sesión</a>
                    <?php } else { ?>
                        <a href="?controller=user&action=cuenta" class="opacity-100 p-0">
                            <img src="imagenes/Iconos/person-24.svg" alt="icon-person-24">
                        </a>
                        <a href="?controller=user&action=carrito" class="opacity-100 p-0">
                            <img src="imagenes/Iconos/shopping-cart-24.svg" alt="icon-shopping-cart-24">
                        </a>
                        <a href="?controller=user&action=logout" class="opacity-100 p-0">
                            <img src="imagenes/Iconos/logout-24.svg" alt="icon-logout-24">
                        </a>
                    <?php } ?>
                </nav>
                <div class="menu">
                    <div class="dropdown">
                        <button class="dropdown-btn" aria-label="Abrir menú">
                            <img src="imagenes/Iconos/menu-24.svg" class="icono-menu" alt="icon-menu-24.svg">
                            <img src="imagenes/Iconos/close-24.svg" class="icono-close" alt="icon-close-24">
                        </button>
                        <div class="contenido">
                            <a href="?controller=producto" class="apartado-menu">Inicio</a>
                            <a href="?controller=producto&action=menu" class="apartado-menu">Menu</a>
                            <a href="?controller=producto&action=sobreNosotros" class="apartado-sobreNosotros">Sobre nosotros</a>
                            <a href="?controller=producto&action=contacto" class="apartado-contacto">Contacto</a>
                            <a href="?controller=user"><?=$texto_login_cuenta?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

