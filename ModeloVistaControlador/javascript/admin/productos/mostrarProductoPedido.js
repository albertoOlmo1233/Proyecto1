document.addEventListener("DOMContentLoaded", () => {
    const detalleProducto = document.getElementById("productoDetalle");
    const closeBtn = document.getElementById('close-productoDetalle');

    // Verifica si el modal y el botón de cerrar existen
    if (!detalleProducto || !closeBtn) {
        console.warn('El modal o el botón de cerrar no existen.'); // Agregar un aviso en la consola
        return; // Termina la ejecución si alguno de los elementos no existe
    }

    // Comprobar si el parámetro 'id' está presente en la URL
    const urlParams = new URLSearchParams(window.location.search);
    const productoId = urlParams.get('id'); // Obtén el valor del parámetro 'id'

    // Si el parámetro 'id' está presente, mostrar el detalle del producto
    if (productoId) {
        detalleProducto.classList.remove('hidden');
    } else {
        detalleProducto.classList.add('hidden'); // Asegúrate de que el modal esté oculto si no hay 'id'
    }

    // Ocultar el modal
    closeBtn.addEventListener('click', () => {
        // Verificar si el parámetro 'action' en la URL es 'pedidosConfig'
        const action = urlParams.get('action'); // Obtener el valor de 'action' desde la URL

        if (action === 'pedidosConfig') {
            // Redireccionar si el action es 'pedidosConfig'
            window.location.href = "http://workandtaste.com/?controller=admin&action=pedidosConfig&funcion=get";
        } else {
            // Solo ocultar el modal si el action no es 'pedidosConfig'
            detalleProducto.classList.add('hidden');
        }
    });
});
