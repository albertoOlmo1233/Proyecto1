<section id="seccion-login" class="vh-100 d-flex align-items-center">
    <div class="contenido-register mx-auto gap-6 d-flex flex-column align-items-center">
        <div class="titulo-redireccion text-center">
            <!-- Logo -->
             <div class="logo gap-3 d-flex flex-column align-items-center">
                <img src="imagenes/Logo/Logo blanco.svg" alt="" width="36px">
                <h3 class="titulo-login">Crear una cuenta</h3>
             </div>
            <div id="redireccion-register">
                <p class="h3-p">¿Ya tienes una cuenta? <a href="?controller=user">Inicia sesion</a></p>
            </div>
        </div>
        
        <!-- Login Form -->
        <form action="?controller=user&action=registroSesion" method="POST" class="w-100 d-flex flex-columngap-3">
            <div class="flex">
                <input type="text" class="form-control custom-border w-100" id="nombre" name="nombre" placeholder="Nombre" required>
                <input type="text" class="form-control custom-border w-100" id="apellidos" name="apellidos" placeholder="Apellidos" required>
            </div>
            <input type="email" class="form-control custom-border w-100" id="correo" name="correo" placeholder="Correo electronico" required>
            <input type="password" class="form-control custom-border w-100" id="password" name="password" placeholder="Contraseña" required minlength="8" maxlength="15">
            <div class="form-check w-100">
                <label for="mycheck" class="form-check-label w-100">Agree to terms of service</label>
                <input type="checkbox" class="mycheck" id="mycheck" required>
            </div>
            <!-- Mostrar el error si existe -->
            <?php if (isset($_SESSION['error']) && $_SESSION['error'] != ""): ?>
                <div class="alert alert-danger mt-3" id="alert-error">
                    <?php echo $_SESSION['error']; ?>
                </div>
                <script src="../../javascript/cuenta/animacion-error.js"></script>
            <?php endif; ?>
            <?php if (isset($_SESSION['confirmacion']) && $_SESSION['confirmacion'] != ""): ?>
                <div class="alert alert-success mt-3" id="alert-confirmacion">
                    <?php echo $_SESSION['confirmacion']; ?>
                </div>
                <script src="../../javascript/cuenta/animacion-confirmacion.js"></script>
                <script>
                    // Redirigir después de 3 segundos
                    setTimeout(function() {
                        window.location.href = "?controller=user";
                    }, 1500);
                </script>
            <?php endif; ?>
            <!-- Login Button -->
            <button type="submit" class="primaryButton-yellow-3-login">Registrarse con correo</button>
        </form>
    </div>

</section>