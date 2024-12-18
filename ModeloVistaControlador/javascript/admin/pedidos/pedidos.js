// Obtener pedidos desde la API
async function getPedidos() {
    const API_URL = "http://workandtaste.com/?controller=api&action=getPedidos";

    // Realizar la solicitud fetch para obtener los pedidos
    const respuesta = await fetch(API_URL);
    const pedidos = await respuesta.json();

    // Verificar si la respuesta es exitosa y si hay datos
    if (pedidos.estado === "Exito" && pedidos.data) {
        // Crear el contenido de la tabla con los datos de los pedidos
        let content = "";
        pedidos.data.forEach(pedido => {
            // Obtener los productos del pedido
            const productos = pedido.productos || [];  // Asegurarnos de que productos exista

            // Generar los enlaces para los productos si existen
            let productoLinks = '';
            if (productos.length > 0) {
                productoLinks = productos.map(idProducto => {
                    // Crear el HTML del enlace
                    return `<a href='?controller=admin&action=pedidosConfig&id=${encodeURIComponent(idProducto)}' class='productoLink'>${encodeURIComponent(idProducto)}</a>`;
                }).join(', '); // Unimos los enlaces con coma
            } else {
                productoLinks = "No productos disponibles";
            }

            content += `
                <div class="col-12 col-sm-6 col-md-6 col-lg-4 mt-0 mb-5">
                    <div class="card h-100 w-100">
                        <div class="card-body">
                            <h3 class="card-title">${pedido.correo}</h3>
                            <p><b>Productos:</b> ${productoLinks}</p>
                            <p><b>Cantidad:</b> ${pedido.cantidad_total}</p>
                            <p><b>Total:</b> ${pedido.total_pedido}</p>
                            <p><b>Fecha:</b> ${pedido.fecha}</p>
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

        // Verificar si la tabla existe en el DOM y agregar los datos
        const listaPedidos = document.getElementById("listaPedidos");
        if (listaPedidos) {
            listaPedidos.innerHTML = `
                ${content}
            `;
        } else {
            console.error("No se encontró el elemento con id 'tablaGeneral'.");
        }
    } else {
        console.log("Error: No se obtuvieron datos de pedidos.");
        const pedidosContainer = document.getElementById("pedidosContainer");
        if (pedidosContainer) {
            pedidosContainer.innerHTML = "<p>No hay pedidos disponibles.</p>";
        }
    }
}

// Ejecutar la función al cargar el documento
document.addEventListener("DOMContentLoaded", function () {
    getPedidos();
});
