<section id="seccion-login" class="vh-100 d-flex align-items-center">
    <div class="contenido-login mx-auto gap-6 d-flex flex-column align-items-center">
        <div class="titulo-redireccion text-center">
            <!-- Logo -->
             <div class="logo gap-3 d-flex flex-column align-items-center">
                <img src="imagenes/Logo/Logo blanco.svg" alt="" width="36px">
                <h3 class="titulo-login">Inicio de sesion</h3>
             </div>
            <div id="redireccion-register">
                <p class="h3-p">¿No tienes una cuenta? <a href="?controller=user&action=register">Registrate</a></p>
            </div>
        </div>
        
        <!-- Login Form -->
        <form action="?controller=user&action=inicioSesion" method="POST" class="w-100 d-flex flex-column gap-3">
            <input type="email" class="form-control custom-border w-100" id="correo" name="correo" placeholder="Email" required>
            <input type="password" class="form-control custom-border w-100" id="password" name="password" placeholder="Contraseña" required>
            <!-- Mostrar el error si existe -->
            <?php if (isset($_SESSION['error']) && $_SESSION['error'] != ""): ?>
                <div class="alert alert-danger mt-3" id="alert-error">
                    <?php echo $_SESSION['error']; ?>
                </div>
                <script src="../../javascript/cuenta/animacion-error.js"></script>
            <?php unset($_SESSION['error']); endif; ?>

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
            <?php unset($_SESSION['confirmacion']); endif; ?>
            <!-- Login Button -->
            <button type="submit" class="primaryButton-yellow-3-login">
                Login
            </button>
        </form>
    </div>

</section>