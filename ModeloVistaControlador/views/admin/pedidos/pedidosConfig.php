
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pedidos</title>
    <link rel="stylesheet" href="../../css/admin/header-admin.css">
    <style>
        #tablaGeneral th, #tablaGeneral td {
            border: 1px solid black;
            text-align: center; /* Centrar el contenido */
            padding: 8px; /* Espaciado interno */
        }
    </style>
    <!-- JS de configuración del usuario -->
    <script src="../../javascript/admin/pedidos/pedidos.js"></script>
    <script src="../../javascript/admin/productos/mostrarProductoPedido.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<!-- Sidebar -->
<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION['usuario']["rol"] === "Admin") {
?>
<section id="panel-administrador" class="d-flex-personalizado">
    <!-- HEADER -->
<?php 
    include_once("views/header/header-admin.php");
} else {
    include_once("views/header/header.php");
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-md-9 col-lg-9 mx-auto">
            <h1>Lista de Pedidos:</h1>
            <div class="row d-flex justify-content-around" id="listaPedidos">
                
            </div>
            <div id="productoDetalle" class="hidden">
                <div class="contenido-contenedor text-center">
                    <div class="d-flex flex-row gap-5">
                        <div class="w-50 flex-column text-start position-relative">
                            <h2 id="productoNombre"><?=$detalleProducto->getNombre();?></h2>
                            <?php if ($detalleProducto->getPrecioOferta()){ ?>
                                <div class="d-flex flex-row gap-3">
                                    <h3 class="card-text text-decoration-line-through"><?=$detalleProducto->getPrecio();?> €</h3>
                                    <h3 class="card-text"><?=$detalleProducto->getPrecioOferta();?> €</h3>
                                </div>
                            <?php } else { ?>
                                <h3><?=$detalleProducto->getPrecio();?>€</h3>
                            <?php } ?>
                            <button id="close-productoDetalle" class="position-absolute bottom-0">Close</button>
                        </div>
                        <img src="<?=$detalleProducto->getImagen();?>" alt="<?=$detalleProducto->getNombre();?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </section>
    
</body>
</html>