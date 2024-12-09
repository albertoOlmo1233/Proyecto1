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
            </div>
        </div>
    </div>
</div>

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
            <div class="accion-contenedor text-end">
                <button id="close-btn">Close</button>
                <button type="submit">Confirm</button>
            </div>
        </form>
    </div>
</div>

<script src="../../javascript/cuenta/funciones-configuracion-cuenta.js"></script>
