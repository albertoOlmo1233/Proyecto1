<div class="d-flex flex-column pantallas-pequeñas header-vertical-ajustes-personalizados flex-shrink-0 bg-light vh-100 sticky-top" style="width: 250px">
  <ul class="nav nav-pills nav-flush flex-column mb-auto text-left">
    <a href="#" class="w-100 h1-p" aria-current="page" title="" data-bs-toggle="tooltip" data-bs-placement="right">
    <img src="../../imagenes/Logo/Logo blanco.svg" alt="" width="36px">
    </a><br>
    <a href="?controller=producto&action=panel" class="nav-link w-100 h1-p" aria-current="page" title="" data-bs-toggle="tooltip" data-bs-placement="right">
    Panel
    </a>

    <a href="?controller=producto&action=menu" class="nav-link  w-100 h1-p" title="" data-bs-toggle="tooltip" data-bs-placement="right">
    Menu
    </a>


    <a href="?controller=user&action=carrito" class="nav-link  w-100 h1-p" title="" data-bs-toggle="tooltip" data-bs-placement="right"">
    Carrito
    </a>


    <a href="?controller=user&action=logout" class="nav-link w-100 h1-p" title="" data-bs-toggle="tooltip" data-bs-placement="right">
    Cerrar sesion
    </a>
  </ul>
</div>

<nav class="navbar navbar-expand-lg bg-body-tertiary header-activo">
  <div class="container-fluid">
    <!-- Logo -->
    <a class="navbar-brand" href="#"><img src="../../imagenes/Logo/Logo blanco.svg" alt="" width="36px"></a>
    <!-- Botón para abrir el primer acordeón -->
    <button class="navbar-toggler configuraciones-boton-menu-admin " type="button" data-bs-toggle="collapse" data-bs-target="#accordion1" aria-controls="accordion1" aria-expanded="false" aria-label="Toggle navigation">
      <span><img src="../../imagenes/Iconos/menu-24.svg" alt=""></span>
    </button>
    
    <!-- Primer acordeón -->
    <div class="collapse navbar-collapse" id="accordion1">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- Primer nivel del menú -->
        <li class="nav-item d-flex justify-content-">
          <a class="nav-link" aria-current="page" href="?controller=producto&action=panel">Panel</a>
          <button class="navbar-toggler configuraciones-boton-menu-admin" data-bs-toggle="collapse" data-bs-target="#accordion2" aria-controls="accordion2" aria-expanded="false" aria-label="Toggle navigation">
            <span><img src="../../imagenes/Iconos/arrow-downward-24.svg" alt=""></span>
          </button>
        </li>
        
        <!-- Segundo botón dentro del primer acordeón -->
        <li class="nav-item">
          <!-- Segundo acordeón -->
          <div class="collapse navbar-collapse" id="accordion2">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 bg-light">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="">Ver datos</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="">Crear</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="">Modificar</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="">Eliminar</a>
              </li>
            </ul>
          </div>
        </li>
        
        <!-- Otros enlaces del menú principal -->
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="?controller=producto&action=menu">Menu</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="?controller=user&action=carrito">Carrito</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="?controller=user&action=logout">Cerrar sesión</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


<script>
  // Seleccionamos todos los enlaces con la clase 'nav-link'
  const navLinks = document.querySelectorAll('.nav-link');

  // Al cargar la página, verificamos si hay un enlace activo guardado en localStorage
  const activeLink = localStorage.getItem('activeNavLink');
  if (activeLink) {
    // Buscamos el enlace que coincide con el guardado y le agregamos la clase 'active'
    navLinks.forEach(link => {
      if (link.href === activeLink) {
        link.classList.add('active');
      }
    });
  }

  // Agregamos el evento de clic a cada enlace
  navLinks.forEach(link => {
    link.addEventListener('click', (event) => {
      // Eliminamos la clase 'active' de todos los enlaces
      navLinks.forEach(nav => nav.classList.remove('active'));

      // Agregamos la clase 'active' al enlace clickeado
      event.target.classList.add('active');

      // Guardamos la URL del enlace activo en localStorage
      localStorage.setItem('activeNavLink', event.target.href);
    });
  });
</script>
