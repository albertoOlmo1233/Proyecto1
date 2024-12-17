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
                <tr>
                    <td border="1">${producto.id}</td>
                    <td border="1">${producto.nombre}</td>
                    <td border="1">${producto.descripcion}</td>
                    <td border="1">${producto.precio}</td>
                    <td border="1">${producto.id_oferta}</td>
                    <td border="1"><img src="${producto.imagen}" alt=""></td>
                    <td border="1">${producto.categoria}</td>
                </tr>;
            `});

            // Aquí aseguramos que el DOM está completamente cargado antes de modificar la tabla
            const tablaGeneral = document.getElementById("tablaGeneral");
            if (tablaGeneral) {
                tablaGeneral.innerHTML = `
                    <thead>
                        <tr>
                            <th border="1" class="centered">ID</th>
                            <th border="1" class="centered">Nombre</th>
                            <th border="1" class="centered">Descripcion</th>
                            <th border="1" class="centered">Precio</th>
                            <th border="1" class="centered">ID Oferta</th>
                            <th border="1" class="centered">Imagen</th>
                            <th border="1" class="centered">Categoria</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${content}
                    </tbody>
                `;
            } else {
                console.error("No se encontró el elemento con id 'tablaGeneral'.");
            }
        } else {
            console.log("Error: No se obtuvo datos de usuarios.");
        }
    } catch (error) {
        console.log("Error al obtener usuarios:", error);
    }
}

// Crear usuarios


async function addProductos(){

}
// Modificar usuarios 

async function modifyProductos(){
    
}

// Eliminar usuarios 

async function eraseProductos(){
    
}

// Si la tabla existe, ejecuta la función
document.addEventListener("DOMContentLoaded", function () {
    const tabla = document.getElementById("tablaGeneral");

    // Productos
    if (tabla) {
        getProductos();
    } else {
        console.log("No se encontró la tabla.");
    }
});