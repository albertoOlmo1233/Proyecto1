<section id="fondo-login" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 d-flex flex-column align-items-center">
                <div class="titulo-redireccion d-flex flex-column justify-content-center">
                    <!-- Logo -->
                    <img src="imagenes/Logo/Logo Letra color.png" alt="Company Logo" class="mb-4">
                    
                    <!-- Heading -->
                    <h3 class="text-center mb-3">Crear cuenta</h3>
                    
                    <!-- Redirect to Login -->
                    <div id="redireccion-register" class="text-center mb-4">
                        <p>¿Ya tienes cuenta? 
                            <a href="?controller=user" class="text-decoration-none">Iniciar sesión</a>
                        </p>
                    </div>
                </div>
                
                <!-- Registration Form -->
                <form action="" class="w-100">
                    <div class="row mb-3 w-100">
                        <div class="col-6">
                            <input type="text" class="form-control custom-border" placeholder="Nombre" required>
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control custom-border" placeholder="Apellidos" required>
                        </div>
                    </div>
                    <div class="row w-100">
                        <div class="col-12 mb-3">
                            <input type="email" class="form-control custom-border" placeholder="Dirección de correo" required>
                        </div>
                        
                        <div class="col-12 mb-3">
                            <input type="password" class="form-control custom-border" placeholder="Contraseña" required>
                        </div>
                    </div>
                    
                    <div class="form-check mb-4">
                        <input type="checkbox" class="form-check-input" id="terms" required>
                        <label for="terms" class="form-check-label">Aceptar los términos y condiciones</label>
                    </div>
                    
                    <!-- Register Button -->
                    <a href="" class="primaryButton-yellow-3-login">Register</a>
                </form>
            </div>
        </div>
    </div>
</section>
