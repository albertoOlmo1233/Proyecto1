<div class="flex-shrink-0 p-3 bg-white pantallas-pequeñas header-vertical-ajustes-personalizados sticky-top vh-100" style="width: 250px;">
    <a href="/" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
      <svg class="bi me-2" width="30" height="24"><use xlink:href="#bootstrap"/></svg>
      <img src="../../imagenes/Logo/Logo blanco.svg" alt="" width="36px">
      </a>
    </a>
    <ul class="list-unstyled ps-0">
      <li class="mb-1">
        <button class="btn btn-toggle align-items-center rounded collapsed w-100 justify-content-between" data-bs-toggle="collapse" data-bs-target="#panel-collapse" aria-expanded="false">
          <p class="mb-0">Panel</p>
          <i class="bi bi-arrow-down-circle"></i>
          <!-- Si hago hover por el de arriba se muestra el de abajo y el de arriba desaparece -->
          <i class="bi bi-arrow-down-circle-fill hidden"></i>
        </button>
        <div class="collapse fondo-gris" id="panel-collapse">
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <button class="btn btn-toggle align-items-center rounded collapsed link-dark rounded w-100 justify-content-between" data-bs-toggle="collapse" data-bs-target="#usuarios-collapse" aria-expanded="false">
            <p class="mb-0">Usuarios</p>
            <i class="bi bi-arrow-down-circle normal-icon"></i>
            <!-- Si hago hover por el de arriba se muestra el de abajo y el de arriba desaparece -->
            <i class="bi bi-arrow-down-circle-fill hover-icon hidden"></i>
            </button>
            <!-- Ver datos -->
            <div class="collapse" id="usuarios-collapse">
              <li><a href="#" class="link-dark rounded">Ver</a></li>
              <li><a href="#" class="link-dark rounded">Crear</a></li>
              <li><a href="#" class="link-dark rounded">Modificar</a></li>
              <li><a href="#" class="link-dark rounded">Eliminar</a></li>
          </ul>
          <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
            <button class="btn btn-toggle align-items-center rounded collapsed link-dark rounded w-100 justify-content-between" data-bs-toggle="collapse" data-bs-target="#productos-collapse" aria-expanded="false">
              <p class="mb-0">Productos</p>
              <i class="bi bi-arrow-down-circle"></i>
              <!-- Si hago hover por el de arriba se muestra el de abajo y el de arriba desaparece -->
              <i class="bi bi-arrow-down-circle-fill hidden"></i>
            </button>
            <!-- Crear datos -->
            <div class="collapse" id="productos-collapse">
            <li><a href="#" class="link-dark rounded">Ver</a></li>
              <li><a href="#" class="link-dark rounded">Crear</a></li>
              <li><a href="#" class="link-dark rounded">Modificar</a></li>
              <li><a href="#" class="link-dark rounded">Eliminar</a></li>
          </ul>
        </div>
      </li>
      <li class="mb-1">
        <a href="?controller=producto&action=menu" class="btn btn-toggle align-items-center rounded content-none">
          Menu
        </a>
      </li>
      <li class="mb-1">
        <a href="?controller=user&action=cuenta" class="btn btn-toggle align-items-center rounded content-none">
          Cuenta
        </a>
      </li>
      <li class="mb-1">
        <a href="?controller=user&action=carrito" class="btn btn-toggle align-items-center rounded content-none">
          Carrito
        </a>
      </li>
      <li class="mb-1">
        <a href="?controller=user&action=logout" class="btn btn-toggle align-items-center rounded content-none">
          Cerrar sesion
        </a>
      </li>
    </ul>
  </div>

  <script>
    const normal_icon = document.querySelector(".normal-icon");
    const arrow_hover = document.querySelector(".hover-icon");

    normal_icon.addEventListener('click', () => {});
    nextBtn.addEventListener('click', () => {});
  </script>




<style>

main {
  display: flex;
  flex-wrap: nowrap;
  height: 100vh;
  height: -webkit-fill-available;
  max-height: 100vh;
  overflow-x: auto;
  overflow-y: hidden;
}

.fondo-gris {
  background: #f2f4f5;
}
.content-icon {
  content: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='rgba%280,0,0,.5%29' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 14l6-6-6-6'/%3e%3c/svg%3e");
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