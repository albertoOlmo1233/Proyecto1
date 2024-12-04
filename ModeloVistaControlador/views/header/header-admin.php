<div class="flex-shrink-0 p-3 bg-white pantallas-pequeñas header-vertical-ajustes-personalizados" style="width: 250px;">
    <a href="/" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
      <svg class="bi me-2" width="30" height="24"><use xlink:href="#bootstrap"/></svg>
      <img src="../../imagenes/Logo/Logo blanco.svg" alt="" width="36px">
      </a>
    </a>
    <ul class="list-unstyled ps-0">
      <li class="mb-1">
        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#panel-collapse" aria-expanded="false">
          Panel
        </button>
        <div class="collapse" id="panel-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <button class="btn btn-toggle align-items-center rounded collapsed link-dark rounded" data-bs-toggle="collapse" data-bs-target="#verDatos-collapse" aria-expanded="false">
              Ver datos
            </button>
            <!-- Ver datos -->
            <div class="collapse" id="verDatos-collapse">
              <li><a href="#" class="link-dark rounded">Productos</a></li>
              <li><a href="#" class="link-dark rounded">Usuarios</a></li>
          </ul>
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <button class="btn btn-toggle align-items-center rounded collapsed link-dark rounded" data-bs-toggle="collapse" data-bs-target="#crearDatos-collapse" aria-expanded="false">
              Crear
            </button>
            <!-- Crear datos -->
            <div class="collapse" id="crearDatos-collapse">
              <li><a href="#" class="link-dark rounded">Productos</a></li>
              <li><a href="#" class="link-dark rounded">Usuarios</a></li>
          </ul>
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <button class="btn btn-toggle align-items-center rounded collapsed link-dark rounded" data-bs-toggle="collapse" data-bs-target="#modificarDatos-collapse" aria-expanded="false">
              Modificar
            </button>
            <!-- Crear datos -->
            <div class="collapse" id="modificarDatos-collapse">
              <li><a href="#" class="link-dark rounded">Productos</a></li>
              <li><a href="#" class="link-dark rounded">Usuarios</a></li>
          </ul>
        </div>
      </li>
      <li class="mb-1">
        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
          Menu
        </button>
      </li>
      <li class="mb-1">
        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
          Cuenta
        </button>
      </li>
      <li class="mb-1">
        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
          Carrito
        </button>
      </li>
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




  <style>
    body {
  min-height: 100vh;
  min-height: -webkit-fill-available;
}

html {
  height: -webkit-fill-available;
}

main {
  display: flex;
  flex-wrap: nowrap;
  height: 100vh;
  height: -webkit-fill-available;
  max-height: 100vh;
  overflow-x: auto;
  overflow-y: hidden;
}

.b-example-divider {
  flex-shrink: 0;
  width: 1.5rem;
  height: 100vh;
  background-color: rgba(0, 0, 0, .1);
  border: solid rgba(0, 0, 0, .15);
  border-width: 1px 0;
  box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
}

.bi {
  vertical-align: -.125em;
  pointer-events: none;
  fill: currentColor;
}

.dropdown-toggle { outline: 0; }

.nav-flush .nav-link {
  border-radius: 0;
}

.btn-toggle {
  display: inline-flex;
  align-items: center;
  padding: .25rem .5rem;
  font-weight: 600;
  color: rgba(0, 0, 0, .65);
  background-color: transparent;
  border: 0 !important;
}
.btn-toggle:hover,
.btn-toggle:focus {
  color: rgba(0, 0, 0, .85);
}

.btn-toggle::before {
  width: 1.25em;
  line-height: 0;
  content: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='rgba%280,0,0,.5%29' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 14l6-6-6-6'/%3e%3c/svg%3e");
  transition: transform .35s ease;
  transform-origin: .5em 50%;
}

.btn-toggle[aria-expanded="true"] {
  color: rgba(0, 0, 0, .85);
}
.btn-toggle[aria-expanded="true"]::before {
  transform: rotate(90deg);
}

.btn-toggle-nav a {
  display: inline-flex;
  padding: .1875rem .5rem;
  margin-top: .125rem;
  margin-left: 1.25rem;
  text-decoration: none;
}
.btn-toggle-nav a:hover,
.btn-toggle-nav a:focus {
  background: #f2f4f5;
}

.scrollarea {
  overflow-y: auto;
}

.fw-semibold { font-weight: 600; }
.lh-tight { line-height: 1.25; }

</style>