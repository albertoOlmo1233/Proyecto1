<div id="fondo-login">
    <div class="plantilla-login">
        <img src="imagenes/Logo/Logo Letra color.png" alt="" >
        <h3 class="titulo-login">Conectarse a Work & Taste</h3>
        <div id="redireccion-register">
            <p>¿No tienes cuenta?</p>
            <a href="?controller=user&action=register">Registrate</a>
        </div>
        <form action="?controller=user&action=inicioSesion" method="POST">
            <input type="text" name="correo" placeholder="Correo electronico" ><br>
            <input type="password" name="password" placeholder="Contraseña"><br>
            <button type="submit" class="primaryButton-yellow-3-login">Log in</button>
        </form>
    </div>
</div>

<section id="fondo-login">
    <div class="container login">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 d-flex flex-column align-items-center">
                <div class="titulo-redireccion d-flex flex-column justify-content-center">
                    <!-- Logo -->
                    <img src="imagenes/Logo/Logo Letra color.png" alt="" >
                    <h3 class="titulo-login">Conectarse a Work & Taste</h3>
                    <div id="redireccion-register">
                        <p>¿No tienes cuenta?</p>
                        <a href="?controller=user&action=register">Registrate</a>
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