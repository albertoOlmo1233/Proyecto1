const contenedor_flotante = document.querySelector("#aviso-flotante");
const boton_hover = document.querySelector("#boton-hover");

boton_hover.addEventListener("mouseover", () => {
    contenedor_flotante.classList.remove("hidden");
});

boton_hover.addEventListener("mouseout", () => {
    contenedor_flotante.classList.add("hidden");
});