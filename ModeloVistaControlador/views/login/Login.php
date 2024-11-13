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