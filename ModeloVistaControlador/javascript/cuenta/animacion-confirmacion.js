const alertConfirmacion = document.getElementById("alert-confirmacion");
alertConfirmacion.style.animation = "fadeOut 3s forwards";  // La animación durará 4 segundos

// Escuchar el evento cuando la animación termine
alertConfirmacion.addEventListener("animationend", function() {
    alertConfirmacion.style.display = "none"; // Poner display: none solo después de que la animación termine
    window.location.href = "?controller=user"; // Recarga la pagina
});