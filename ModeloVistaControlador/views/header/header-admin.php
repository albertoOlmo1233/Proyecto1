<link rel="stylesheet" href="../../css/admin/header-admin.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<div class="sticky-top flex-shrink-0 p-3 bg-white pantallas-pequeñas header-vertical-ajustes-personalizados vh-100" style="width: 250px;">
    <a href="/" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
      <svg class="bi me-2" width="30" height="24"><use xlink:href="#bootstrap"/></svg>
      <img src="../../imagenes/Logo/Logo blanco.svg" alt="" width="36px">
      </a>
    </a>
    <ul class="list-unstyled ps-0">
      <li class="mb-1">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
          <button class="btn btn-toggle align-items-center rounded collapsed w-100 justify-content-between btn-enter" data-bs-toggle="collapse" data-bs-target="#panel-collapse" aria-expanded="false">
            <p class="mb-0">Panel</p>
            <i class="bi bi-arrow-down-circle normal-icon"></i>
            <!-- Si hago hover por el de arriba se muestra el de abajo y el de arriba desaparece -->
            <i class="bi bi-arrow-down-circle-fill hover-icon hidden"></i>
          </button>
          <!-- Usuarios -->
          <div class="collapse fondo-gris" id="panel-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <button class="btn btn-toggle align-items-center rounded collapsed link-dark rounded w-100 justify-content-between btn-enter" data-bs-toggle="collapse" data-bs-target="#usuarios-collapse" aria-expanded="false">
              <p class="mb-0">Usuarios</p>
              <i class="bi bi-arrow-down-circle normal-icon"></i>
              <!-- Si hago hover por el de arriba se muestra el de abajo y el de arriba desaparece -->
              <i class="bi bi-arrow-down-circle-fill hover-icon hidden"></i>
              </button>
              <!-- Ver datos -->
              <div class="collapse" id="usuarios-collapse">
              <li><a href="?controller=admin&action=usuariosConfig&funcion=get">Ver</a></li>
              <li><a href="?controller=admin&action=usuariosConfig&funcion=create">Crear</a></li>
              </div> 
            </ul>
            <!-- Productos -->
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <button class="btn btn-toggle align-items-center rounded collapsed link-dark rounded w-100 justify-content-between btn-enter" data-bs-toggle="collapse" data-bs-target="#productos-collapse" aria-expanded="false">
                <p class="mb-0">Productos</p>
                <i class="bi bi-arrow-down-circle normal-icon"></i>
                <!-- Si hago hover por el de arriba se muestra el de abajo y el de arriba desaparece -->
                <i class="bi bi-arrow-down-circle-fill hover-icon hidden"></i>
              </button>
              <!-- Crear datos -->
              <div class="collapse" id="productos-collapse">
                <li><a href="?controller=admin&action=productosConfig&funcion=get">Ver</a></li>
                <li><a href="?controller=admin&action=productosConfig&funcion=create">Crear</a></li>
              </div> 
            </ul>
            <!-- Pedidos -->
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <button class="btn btn-toggle align-items-center rounded collapsed link-dark rounded w-100 justify-content-between btn-enter" data-bs-toggle="collapse" data-bs-target="#pedidos-collapse" aria-expanded="false">
                <p class="mb-0">Pedidos</p>
                <i class="bi bi-arrow-down-circle normal-icon"></i>
                <!-- Si hago hover por el de arriba se muestra el de abajo y el de arriba desaparece -->
                <i class="bi bi-arrow-down-circle-fill hover-icon hidden"></i>
              </button>
              <!-- Crear datos -->
              <div class="collapse" id="pedidos-collapse">
                <li><a href="?controller=admin&action=pedidosConfig&funcion=get">Ver</a></li>
                <li><a href="?controller=admin&action=pedidosConfig&funcion=create">Crear</a></li>
              </div> 
            </ul>
            <li class="mb-1">
              <a href="?controller=admin&action=logs" class="btn btn-toggle align-items-center rounded content-none">
                Logs
              </a>
            </li>
          </div>
        </ul>
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
<script src="../../javascript/admin/cambiar-iconos.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">