document.addEventListener("DOMContentLoaded", function () {
    const obtenerUsuarios = document.getElementById("obtenerUsuarios");

    // USUARIOS
    if (obtenerUsuarios) {
        obtenerUsuarios.addEventListener("click", () => {
            // Redirigir al usuario cuando se haga clic.
            console.log("Redirigiendo a la página de configuración de usuarios.");
            window.location.href = "http://workandtaste.com/?controller=admin&action=usuariosConfig";
        });
    } else {
        console.log("No se encontró el botón para redirigir usuarios.");
    }
    const obtenerProductos = document.getElementById("obtenerProductos");
    if (obtenerProductos) {
        obtenerProductos.addEventListener("click", () => {
            // Redirigir al usuario cuando se haga clic.
            console.log("Redirigiendo a la página de configuración de usuarios.");
            window.location.href = "http://workandtaste.com/?controller=admin&action=productosConfig";
        });
    } else {
        console.log("No se encontró el botón para redirigir usuarios.");
    }
});