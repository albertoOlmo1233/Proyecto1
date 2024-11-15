<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="imagenes/Logo/Logo Letra color.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/General.css">
    <link rel="stylesheet" href="css/Inicio.css">
    <link rel="stylesheet" href="css/Menu.css">
    <link rel="stylesheet" href="css/Contacto.css">
    <link rel="stylesheet" href="css/Sobre nosotros.css">
    <link rel="stylesheet" href="css/Carrito.css">
    <link rel="stylesheet" href="css/Login.css">
    <link rel="stylesheet" href="css/show/showProducto.css">
</head>
<body>
    <header>
        <a href="?controller=producto">
            <div id="Logo" aria-label="Logo del sitio">
                <img src="imagenes/Logo/Logo vertical color.png" alt="Logo color">
            </div>
        </a>
        <nav id="seccion-menu">
            <a href="?controller=producto&action=menu" class="apartado-menu">Menu</a>
            <a href="?controller=producto&action=sobreNosotros" class="apartado-sobreNosotros">Sobre nosotros</a>
            <a href="?controller=producto&action=contacto" class="apartado-contacto">Contacto</a>
            <a href="?controller=user" class="primaryButton-yellow-1">Iniciar sesión</a>
            <!-- <?php if ($isLoggedIn): ?> -->
                <!-- <a href="?controller=user" class="primaryButton-yellow-1">Iniciar sesión</a> -->
            <!-- <?php else: ?> -->

            <!-- <?php endif; ?> -->
        </nav>
    </header>
    <?php include_once($view);?>
    <footer>
        <div class="contenido-footer">
            <div class="primera-seccion">
                <img src="imagenes/Logo/Logo vertical blanco.png" alt="">
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
</body>
</html>