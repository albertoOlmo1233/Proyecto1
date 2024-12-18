// Obtener usuarios
async function getProductos() {
    const API_URL = "http://workandtaste.com/?controller=api&action=getProductos";
    try {
        // Realizar la solicitud fetch
        const respuesta = await fetch(API_URL);
        const productos = await respuesta.json();

        if (productos.estado === "Exito" && productos.data) {
            // Crear el contenido de la tabla con los datos de los usuarios
            let content = "";
            productos.data.forEach(producto => {
                content += `
                <div class="col-12 col-sm-6 col-md-6 col-lg-4 mt-0 mb-5">
                    <div class="card h-100 w-100">
                        <div class="card-body">
                            <p><b>Categoria:</b> ${producto.categoria}</p>
                            <h3 class="card-title">${producto.nombre}</h3>
                            <p><b>ID Producto:</b> ${producto.id}</p>
                            <p><b>Precio:</b> ${producto.precio} €</p>
                            <p><b>Descripcion:</b> ${producto.descripcion}</p>
                            <p><b>ID Oferta:</b> ${producto.id_oferta}</p>
                            <img src="${producto.imagen}" alt="">
                            <div class="d-flex flex-row justify-content-around">
                                <a href="#" class="material-symbols-outlined cursor-pointer text-decoration-none mb-4">
                                manage_accounts
                                </a> 
                                <a href="#" class="material-symbols-outlined cursor-pointer text-decoration-none mb-4">
                                person_remove
                                </a></td>
                            </div>
                        </div>
                    </div>
                </div>
            `});

            // Aquí aseguramos que el DOM está completamente cargado antes de modificar la tabla
            const listaProductos = document.getElementById("listaProductos");
            if (listaProductos) {
                listaProductos.innerHTML = `
                     ${content}
                `;
            } else {
                console.error("No se encontró el elemento con id 'listaProductos'.");
            }
        } else {
            console.log("Error: No se obtuvo datos de producto.");
        }
    } catch (error) {
        console.log("Error al obtener usuarios:", error);
    }
}

// Crear usuarios


async function addProducto(){

}
// Modificar usuarios 

async function modifyProducto(){
    
}

// Eliminar usuarios 

async function eraseProducto(){
    
}

// Si la tabla existe, ejecuta la función
document.addEventListener("DOMContentLoaded", function () {


    // Obtener parámetros de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const funcion = urlParams.get("funcion");

    if (funcion === "get") {
        getProductos();
    } else if (funcion === "create") {
        addProducto();
    } else if (funcion === "modify") {  // Se corrigió "modifiy"
        modifyProducto();
    } else if (funcion === "erase") {
        eraseProducto();
    } else {
        console.warn("No se ha encontrado una función válida en la URL.");
    }
});