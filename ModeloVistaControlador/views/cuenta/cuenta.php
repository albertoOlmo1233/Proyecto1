<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("views/header/header.php");

$tipo = "";
?>
<div id="seccion-cuenta" class="w-100 vh-100 d-flex align-items-center">
        <div class="container cuenta py-5">
            <div class="card cuenta border-0 justify-content-start p-5">
                <div class="contenido-cuenta d-flex flex-column h-auto gap-3">
                    <h2 class="mb-0 text-left">Detalles de la cuenta</h2>
                    <label for="nombre">Nombre</label>
                    <div class="d-flex">
                        <input type="text" class="form-control custom-border" id="nombre" name="nombre" placeholder="<?= $_SESSION['usuario']['nombre']?>" disabled>
                        <div class="fondo-edit form-control" id="edit-btn-nombre">
                            <img src="../../imagenes/Iconos/edit-24.svg" alt="icon-edit-24">
                        </div>
                    </div>
                    <label for="correo">Correo</label>
                    <div class="d-flex">
                        <input type="email" class="form-control custom-border" id="correo" name="correo" placeholder="<?= $_SESSION['usuario']['correo']?>" disabled>
                        <div class="fondo-edit form-control accion-deshabilitado">
                            <img src="../../imagenes/Iconos/edit-24.svg" alt="icon-edit-24">
                        </div>
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
                        <input type="text" class="form-control custom-border" id="direccion" name="direccion" disabled>
                        <div class="fondo-edit form-control"id="edit-btn-direccion">
                            <img src="../../imagenes/Iconos/edit-24.svg" alt="icon-edit-24">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Contenedor modal oculto -->
    <div id="contenedor" class="hidden">
        <div class="contenido-contenedor">
            <div class="d-flex flex-column h-auto gap-3">
                <img src="../../imagenes/Iconos/custom-person-24.svg" class="align-left" alt="icon-custom-person-24">
                <h3 class="text-align-left" id="titulo">Update your </h3>
                <p class="text-align-left" id="descripcion">Introduce tu a continuacion</p>
            </div>
            <form id="formulario" class="d-flex flex-column h-auto gap-3" method="POST">
                <div class="mostrar-0 hidden">
                    <label>Nombre de usuario</label>
                    <input type="text" value="<?= $_SESSION['usuario']['nombre']?>" name="nombre" id="nombre">
                </div>
                <div class="mostrar-1 hidden">
                    <label>Contraseña</label>
                    <input type="password" value="******" name="contraseña" id="contraseña">
                </div>
                <div class="mostrar-2 hidden">
                    <label>Direccion</label>
                    <input type="text" value="<?= $_SESSION['usuario']['direccion']?>" name="direccion" id="direccion">
                </div>
                <!-- Mostrar el error si existe -->
                <?php if (isset($error) && $error != ""): ?>
                    <div class="alert alert-danger mt-3">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($confirmacion) && $confirmacion != ""): ?>
                    <div class="alert alert-success mt-3">
                        <?php echo $confirmacion; ?>
                    </div>
                    <script>
                        setTimeout(function() {
                            window.location.href = "?controller=user&action=cuenta";
                        }, 3000);
                    </script>
                <?php endif; ?>
                <div class="accion-contenedor text-end">
                    <button id="close-btn">Close</button>
                    <button type="submit">Confirm</button>
                </div>
            </form>
        </div>
    </div>


    <script >
        // Referencias a los elementos
        const editBtn_nombre = document.getElementById('edit-btn-nombre');
        const editBtn_contraseña = document.getElementById('edit-btn-contraseña');
        const editBtn_direccion = document.getElementById('edit-btn-direccion');

        //  Formulario
        const formulario = document.getElementById('formulario');
        // DATOS 
        const datos_nombre = document.querySelector(".mostrar-0");
        const datos_contraseña = document.querySelector(".mostrar-1");
        const datos_direccion = document.querySelector(".mostrar-2");
        const contenedor = document.getElementById('contenedor');
        const closeBtn = document.getElementById('close-btn');

        // Mostrar el modal
        editBtn_nombre.addEventListener('click', () => {
            contenedor.classList.remove('hidden');
            formulario.action = "?controller=user&action=modificarNombre&id=<?= $_SESSION['usuario']['id']?>";
            titulo.textContent = "Modificar tu nombre de usuario"; // Cambia el título
            descripcion.textContent = "Introduce tu nombre de usuario a continuación"; // Cambia el título
            datos_nombre.classList.remove('hidden');
            datos_contraseña.classList.add('hidden');
            datos_direccion.classList.add('hidden');
        });
        editBtn_contraseña.addEventListener('click', () => {
            contenedor.classList.remove('hidden');
            formulario.action = "?controller=user&action=modificarContraseña&id=<?= $_SESSION['usuario']['id']?>";
            titulo.textContent = "Modificar tu contraseña"; // Cambia el título
            descripcion.textContent = "Introduce tu contraseña a continuación"; // Cambia el título
            datos_contraseña.classList.remove('hidden');
            datos_nombre.classList.add('hidden');
            datos_direccion.classList.add('hidden');
        });
        editBtn_direccion.addEventListener('click', () => {
            contenedor.classList.remove('hidden');
            formulario.action = "?controller=user&action=modificarDireccion&id=<?= $_SESSION['usuario']['id']?>";
            titulo.textContent = "Update your direccion"; // Cambia el título
            descripcion.textContent = "Introduce tu direccion a continuación"; // Cambia el título
            datos_direccion.classList.remove('hidden');
            datos_contraseña.classList.add('hidden');
            datos_nombre.classList.add('hidden');
        });

        // Ocultar el modal
        closeBtn.addEventListener('click', () => {
            contenedor.classList.add('hidden');
        });
    </script>