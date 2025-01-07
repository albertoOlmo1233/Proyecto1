const alertError = document.getElementById("alert-error");
alertError.style.animation = "fadeOut 3s forwards";  // La animación durará 4 segundos

// Escuchar el evento cuando la animación termine
alertError.addEventListener("animationend", function() {
alertError.style.display = "none"; // Poner display: none solo después de que la animación termine
window.location.href = "?controller=user"; // Recarga la pagina
});