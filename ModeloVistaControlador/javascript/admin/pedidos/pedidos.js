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

            // Aquí se genera cada fila de la tabla
            content += `
                <tr>
                    <td>${pedido.correo}</td>
                    <td>${productoLinks}</td>
                    <td>${pedido.cantidad_total}</td>
                    <td>${pedido.total_pedido} €</td>
                    <td>${pedido.fecha}</td>
                </tr>
            `;
        });

        // Verificar si la tabla existe en el DOM y agregar los datos
        const tablaGeneral = document.getElementById("tablaGeneral");
        if (tablaGeneral) {
            tablaGeneral.innerHTML = `
                <thead>
                    <tr>
                        <th>ID Usuario</th>
                        <th>ID Productos</th>
                        <th>Cantidad Total</th>
                        <th>Total Pedido</th>
                        <th>Fecha</th>
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
