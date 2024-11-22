<section id="seccion-login" class="vh-100 d-flex align-items-center">
    <div class="contenido-login mx-auto gap-6 d-flex flex-column align-items-center">
        <div class="titulo-redireccion text-center">
            <!-- Logo -->
             <div class="logo gap-3 d-flex flex-column align-items-center">
                <img src="imagenes/Logo/Logo blanco.svg" alt="" width="36px">
                <h3 class="titulo-login">Crear una cuenta</h3>
             </div>
            <div id="redireccion-register">
                <p class="h3-p">¿Ya tienes una cuenta? <a href="?controller=user&action=register">Registrate</a></p>
            </div>
        </div>
        
        <!-- Login Form -->
        <form action="" class="w-100 d-flex flex-columngap-3">
            <div class="flex">
                <input type="text" class="form-control custom-border w-100" placeholder="Nombre" required>
                <input type="text" class="form-control custom-border w-100" placeholder="Apellidos" required>
            </div>
            <input type="text" class="form-control custom-border w-100" placeholder="Correo electronico" required>
            <input type="text" class="form-control custom-border w-100" placeholder="Contraseña" required>
            <div class="form-check mb-4">
                    <label for="terms" class="form-check-label">Aceptar los términos y condiciones</label>
                    <input type="checkbox" class="form-check-input" id="terms" required>
            </div>
            <!-- Login Button -->
            <a href="" class="primaryButton-yellow-3-login">Register</a>
        </form>
    </div>

</section>