async function getProductos() {
    const API_URL = "http://workandtaste.com/?controller=api&action=getProductos";
    const respuesta = await fetch(API_URL);
    const productos = await respuesta.json();

    if (productos.estado === "Exito" && productos.data) {
        let content = "";
        productos.data.forEach(producto => {
            const precio = producto.precio || "N/A"; // Precio original
            const precioOferta = producto.precioOferta; // Convertir a número
        
            // Construcción dinámica del precio
            let bloquePrecio = "";
            if (precioOferta > 0) {
                bloquePrecio = `
                <div class="d-flex flex-row gap-3">
                    <p><b>Precio:</b></p>
                    <p class="card-text h3-p text-decoration-line-through">${precio} €</p>
                    <p class="card-text h3-p text-success">${precioOferta} €</p>
                </div>
                `;
            } else {
                bloquePrecio = `
                    <p class="card-text h3-p"><b>Precio:</b> ${precio} €</p>
                `;
            }
        
            // Estructura de la tarjeta
            content += `
                <div class="col-12 col-sm-6 col-md-6 col-lg-4 mt-0 mb-5">
                    <div class="card h-100 w-100">
                        <div class="card-body">
                            <img src="${producto.imagen}" alt="Imagen del producto" style="max-width: 100%; height: auto;">
                            <p><b>Categoría:</b> ${producto.categoria}</p>
                            <h3 class="card-title">${producto.nombre}(${producto.id})</h3>
                            ${bloquePrecio}
                            <p><b>Descripción:</b> ${producto.descripcion}</p>
                            <p><b>ID Oferta:</b> ${producto.id_oferta || "No aplica"}</p>
                            <div class="d-flex flex-row justify-content-around">
                                <a href="#" class="material-symbols-outlined cursor-pointer text-decoration-none mb-4">
                                    manage_accounts
                                </a> 
                                <a href="#" class="material-symbols-outlined cursor-pointer text-decoration-none mb-4">
                                    person_remove
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        

        // Insertar en el DOM
        const listaProductos = document.getElementById("listaProductos");
        if (listaProductos) {
            listaProductos.innerHTML = content;
        } else {
            console.error("No se encontró el elemento con id 'listaProductos'.");
        }
    } else {
        console.error("Error: No se obtuvo datos de producto o el estado no es 'Exito'.");
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