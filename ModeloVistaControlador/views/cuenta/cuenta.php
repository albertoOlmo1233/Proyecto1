<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("views/header/header.php");
?>
<div id="seccion-cuenta" class="w-100">
        <div class="container cuenta py-5">
            <div class="card cuenta border-0 justify-content-start p-5">
                <div class="contenido-cuenta">
                    <h2 class="mb-0 text-left">Detalles de la cuenta</h2>
                    <label for="nombre">Nombre</label>
                    <div class="d-flex">
                        <input type="text" class="form-control custom-border" id="nombre" name="nombre">
                        <div class="fondo-edit form-control" id="edit-btn">
                            <img src="../../imagenes/Iconos/edit-24.svg" alt="icon-edit-24">
                        </div>
                    </div>
                    <label for="correo">Correo</label>
                    <div class="d-flex">
                        <input type="email" class="form-control custom-border" id="correo" name="correo" placeholder="Tu correo" disabled>
                        <div class="fondo-edit form-control accion-deshabilitado">
                            <img src="../../imagenes/Iconos/edit-24.svg" alt="icon-edit-24">
                        </div>
                    </div>
                    <label for="password">Contraseña</label>
                    <div class="d-flex">
                        <input type="password" class="form-control custom-border" id="password" name="password">
                        <div class="fondo-edit form-control" id="edit-btn">
                            <img src="../../imagenes/Iconos/edit-24.svg" alt="icon-edit-24">
                        </div>
                    </div>
                    <label for="direccion">Dirección</label>
                    <div class="d-flex">
                        <input type="text" class="form-control custom-border" id="direccion" name="direccion">
                        <div class="fondo-edit form-control"id="edit-btn">
                            <img src="../../imagenes/Iconos/edit-24.svg" alt="icon-edit-24">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contenedor modal oculto -->
    <div id="modal" class="hidden">
        <div class="modal-content">
            <h3>Update your name</h3>
            <p>Enter your name below</p>
            <label>First name</label>
            <input type="text" value="John">
            <label>Last name</label>
            <input type="text" value="Doe">
            <div class="modal-actions">
                <button id="close-btn">Close</button>
                <button>Confirm</button>
            </div>
        </div>
    </div>


    <script >
        // Referencias a los elementos
        const editBtn = document.getElementById('edit-btn');
        const modal = document.getElementById('modal');
        const closeBtn = document.getElementById('close-btn');

        // Mostrar el modal
        editBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        // Ocultar el modal
        closeBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    </script>
<?php 
include_once("views/footer/footer.php");
?>