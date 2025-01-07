const header = document.getElementsByTagName("header")[0];
window.addEventListener("scroll", () => {
    if (window.scrollY > 80) { // Cambia el fondo al desplazarse más de 50px
        header.style.backgroundColor = "rgba(255, 255, 255, 0.8)";
        header.style.backdropFilter = "blur(10px)"; 
        header.style.webkitBackdropFilter = "blur(10px)";
    }
});
