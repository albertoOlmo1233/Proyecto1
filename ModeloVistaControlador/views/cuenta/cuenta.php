<script>
        window.addEventListener("beforeunload", function(event) {
            // Redirigir a otra URL al recargar
            window.location.href = "?controller=user"; // Cambia esto a la URL deseada
        });
</script>

<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if($_SESSION['usuario']["rol"] === "Admin"){
?>
<section id="panel-administrador" class="d-flex">
<?php 
    include_once("views/header/header-admin.php");
} else {
    include_once("views/header/header.php");
}
?>
<div id="seccion-cuenta" class="w-100 vh-100 d-flex align-items-center">
    <div class="container cuenta py-5">
        <div class="card cuenta border-0 justify-content-start p-5 position-relative overflow-visible">
            <div class="contenido-cuenta d-flex flex-column h-auto gap-3">
                <h2 class="mb-0 text-left">Detalles de la cuenta</h2>
                
                <!-- Mostrar el error si existe -->
                <?php if (isset($_SESSION['error']) && $_SESSION['error'] != ""): ?>
                    <div class="alert animacion alert-danger mt-3" id="alert-error">
                        <?php echo $_SESSION['error']; ?>
                    </div>
                    <script src="../../javascript/cuenta/animacion-error.js"></script>
                    <?php unset($_SESSION['error']); // Limpiar el mensaje de error después de mostrarlo ?>
                <?php endif; ?>

                <!-- Mostrar la confirmación si existe -->
                <?php if (isset($_SESSION['confirmacion']) && $_SESSION['confirmacion'] != ""): ?>
                    <div class="alert animacion alert-success mt-3" id="alert-confirmacion">
                        <?php echo $_SESSION['confirmacion']; ?>
                    </div>
                    <script src="../../javascript/cuenta/animacion-confirmacion.js"></script>
                    <?php unset($_SESSION['confirmacion']); // Limpiar el mensaje de confirmación después de mostrarlo ?>
                <?php endif; ?>

                <!-- Formulario de datos -->
                <label for="nombre">Nombre</label>
                <div class="d-flex">
                    <input type="text" class="form-control custom-border" id="nombre" name="nombre" placeholder="<?= $_SESSION['usuario']['nombre']?>" disabled>
                    <div class="fondo-edit form-control" id="edit-btn-nombre">
                        <img src="../../imagenes/Iconos/edit-24.svg" alt="icon-edit-24">
                    </div>
                </div>
                <label for="nombre">Apellidos</label>
                <div class="d-flex">
                    <input type="text" class="form-control custom-border" id="apellidos" name="apellidos" placeholder="<?= $_SESSION['usuario']['apellidos']?>" disabled>
                    <div class="fondo-edit form-control" id="edit-btn-apellidos">
                        <img src="../../imagenes/Iconos/edit-24.svg" alt="icon-edit-24">
                    </div>
                </div>

                <label for="correo">Correo</label>
                <div class="d-flex align-items-center position-relative">
                    <input type="email" class="form-control custom-border" id="correo" name="correo" placeholder="<?= $_SESSION['usuario']['correo']?>" disabled>
                    <div class="hidden avisos-flotantes" id="aviso-flotante">
                        <p>No puedes cambiar tu correo electrónico mientras estás con la sesión iniciada. Por favor, si necesitas cambiarlo contacta con un administrador.</p>
                    </div>
                    <div class="fondo-edit form-control accion-deshabilitado" id="boton-hover">
                        <img src="../../imagenes/Iconos/edit-24.svg" alt="icon-edit-24">
                    </div>
                    <script src="../../javascript/cuenta/aviso-flotante.js"></script>

                </div>

                <label for="password">Contraseña</label>
                <div class="d-flex">
                    <input type="password" class="form-control custom-border" id="password" name="password" disabled>
                    <div class="fondo-edit form-control" id="edit-btn-contraseña">
                        <img src="../../imagenes/Iconos/edit-24.svg" alt="icon-edit-24">
                    </div>
                </div>

                <label for="direccion">Dirección</label>
                <div class="d-flex">
                    <input type="text" class="form-control custom-border" id="direccion" name="direccion" placeholder="<?=$_SESSION['usuario']['direccion']?>" disabled>
                    <div class="fondo-edit form-control" id="edit-btn-direccion">
                        <img src="../../imagenes/Iconos/edit-24.svg" alt="icon-edit-24">
                    </div>
                </div>
                <label for="direccion">Mis pedidos</label>
                <?php 
                
                if (isset($_SESSION['usuario']['pedidos']) && !empty($_SESSION['usuario']['pedidos'])) { ?>
                    <div class="overflow-auto" style="max-height: 20vh; max-width: 90vw;">
                        <table class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th scope="col">ID Usuario</th>
                                    <th scope="col">ID Productos</th>
                                    <th scope="col">Cantidad Total</th>
                                    <th scope="col">Total Pedido</th>
                                    <th scope="col">Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($_SESSION['usuario']['pedidos'] as $pedido) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($_SESSION['usuario']['correo']); ?></td>
                                    <td>
                                    <?php 
                                        if (!empty($pedido->productos)) {
                                            $productoLinks = array_map(function($idProducto) {
                                                return "<a href='?controller=user&action=cuenta&id=" . htmlspecialchars($idProducto) . "' class='productoLink'>" . htmlspecialchars($idProducto) . "</a>";
                                            }, $pedido->productos);
                                            echo implode(", ", $productoLinks);
                                        } else {
                                            echo "No productos disponibles";
                                        }
                                        ?>
                                    </td>
                                    <td><?= htmlspecialchars($pedido->cantidad_total); ?></td>
                                    <td><?= htmlspecialchars($pedido->total_pedido); ?>€</td>
                                    <td><?= htmlspecialchars($pedido->Fecha); ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <p>No hay pedidos disponibles.</p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script src="../../javascript/admin/productos/mostrarProductoPedido.js"></script>

<div id="productoDetalle" class="hidden">
    <?php if (isset($detalleProducto) && $detalleProducto): ?>
    <div class="contenido-contenedor text-center">
        <div class="d-flex flex-row gap-5">
            <div class="w-50 flex-column text-start position-relative">
                <h2 id="productoNombre"><?= htmlspecialchars($detalleProducto->getNombre()); ?></h2>
                <?php if ($detalleProducto->getPrecioOferta()) { ?>
                    <div class="d-flex flex-row gap-3">
                        <h3 class="card-text text-decoration-line-through"><?= htmlspecialchars($detalleProducto->getPrecio()); ?> €</h3>
                        <h3 class="card-text"><?= htmlspecialchars($detalleProducto->getPrecioOferta()); ?> €</h3>
                    </div>
                <?php } else { ?>
                    <h3><?= htmlspecialchars($detalleProducto->getPrecio()); ?>€</h3>
                <?php } ?>
                <button id="close-productoDetalle" class="position-absolute bottom-0">Close</button>
            </div>
            <img src="<?= htmlspecialchars($detalleProducto->getImagen()); ?>" alt="<?= htmlspecialchars($detalleProducto->getNombre()); ?>">
        </div>
    </div>
    <?php else: ?>
        <p>Detalles del producto no disponibles.</p>
    <?php endif; ?>
</div>

<script src="../../javascript/cuenta/funciones-configuracion-cuenta.js" defer></script>


<!-- Modal para editar datos -->
<div id="contenedor" class="hidden">
    <div class="contenido-contenedor">
        <div class="d-flex flex-column h-auto gap-3">
            <img src="../../imagenes/Iconos/custom-person-24.svg" class="align-left" alt="icon-custom-person-24">
            <h3 class="text-align-left" id="titulo">Update your </h3>
            <p class="text-align-left" id="descripcion">Introduce tu a continuacion</p>
        </div>
        <!-- Pasar el id de usuario al archivo javascript, para poder trabajar con el -->
        <script>
            const userId = <?= json_encode($_SESSION['usuario']['id']); ?>;
        </script>
        <form id="formulario" class="d-flex flex-column h-auto gap-3" method="POST">
            <div class="mostrar-0 hidden">
                <label>Nombre de usuario</label>
                <input type="text" value="<?= $_SESSION['usuario']['nombre']?>" name="nombre" id="nombre">
            </div>
            <div class="mostrar-1 hidden">
                <label>Contraseña</label>
                <input type="password" value="******" name="contraseña" id="contraseña" minlength="8" maxlength="15">
            </div>
            <div class="mostrar-2 hidden">
                <label>Direccion</label>
                <input type="text" value="<?= $_SESSION['usuario']['direccion']?>" name="direccion" id="direccion">
            </div>
            <div class="mostrar-3 hidden">
                <label>Apellidos</label>
                <input type="text" value="<?= $_SESSION['usuario']['apellidos']?>" name="apellidos" id="apellidos">
            </div>
            <div class="accion-contenedor text-end">
                <button id="close-btn">Close</button>
                <button type="submit">Confirm</button>
            </div>
        </form>
    </div>
</div>
