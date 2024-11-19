<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="imagenes/Logo/Logo Letra color.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/Inicio.css">
    <link rel="stylesheet" href="css/Menu.css">
    <link rel="stylesheet" href="css/Contacto.css">
    <link rel="stylesheet" href="css/Sobre-nosotros.css">
    <link rel="stylesheet" href="css/Carrito.css">
    <link rel="stylesheet" href="css/Login.css">
    <link rel="stylesheet" href="css/show/showProducto.css">
    <link rel="stylesheet" href="css/General.css">
</head>
<body>
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
                    <!-- <div class="iniciarSesion d-flex align-items-center">
                        <a href="?controller=user" class="primaryButton-yellow-1">Iniciar sesión</a>
                    </div>   -->
                    <!-- Por otro lado, si el usuario inicia sesion se mostrara el de abajo -->
                    <a class="iniciadoSesion d-flex align-items-center g-4">
                        <img src="imagenes/Iconos/person-24.svg" alt="">
                        <img src="imagenes/Iconos/shopping-cart-24.svg" alt="">
                    </a>
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
    <?php include_once($view);?>
    <footer>
        <div class="contenido-footer">
            <div class="primera-seccion">
                <img src="imagenes/Logo/Logo entero blanco.svg" alt="">
                <div class="redes-sociales">
                    <img src="imagenes/Iconos/Property 1=X, isDark=True, Tamaño=24px.png" alt="">
                    <img src="imagenes/Iconos/Property 1=Instagram, isDark=True, Tamaño=24px.png" alt="">
                    <img src="imagenes/Iconos/Property 1=YouTube, isDark=True, Tamaño=24px.png" alt="">
                </div>
            </div>
            <div class="segunda-seccion">
                <p>© 2024 Coworking Space Restaurant. Todos los derechos reservados. Disfruta de un espacio único para trabajar y comer.</p>
            </div>
        </div>
    </footer>

    <!-- JS de jQuery y Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="javascript/menu-desplegable.js"></script>
</body>
</html>