const hamburguesa = document.querySelector("#hamburguesas");
const patatas = document.querySelector("#patatas");
const bebidas = document.querySelector("#bebidas");
const postres = document.querySelector("#postres");

// Asegurarse de que la variable PHP es pasada a JavaScript correctamente


if(tituloProducto == "Hamburguesas") {
    hamburguesa.classList.add("active-menu");
    patatas.classList.remove("active-menu");
    bebidas.classList.remove("active-menu");
    postres.classList.remove("active-menu");
} else if(tituloProducto == "Patatas") {
    hamburguesa.classList.remove("active-menu");
    patatas.classList.add("active-menu");
    bebidas.classList.remove("active-menu");
    postres.classList.remove("active-menu");
} else if(tituloProducto == "Bebidas") { 
    hamburguesa.classList.remove("active-menu");
    patatas.classList.remove("active-menu");
    bebidas.classList.add("active-menu");
    postres.classList.remove("active-menu");
} else if(tituloProducto == "Postres"){
    hamburguesa.classList.remove("active-menu");
    patatas.classList.remove("active-menu");
    bebidas.classList.remove("active-menu");
    postres.classList.add("active-menu");
}