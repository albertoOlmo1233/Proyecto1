document.addEventListener("DOMContentLoaded", () => {
    const detalleProducto = document.getElementById("productoDetalle");
    const closeBtn = document.getElementById('close-productoDetalle');

    // Comprobar si el parámetro 'id' está presente en la URL
    const urlParams = new URLSearchParams(window.location.search);
    const productoId = urlParams.get('id'); // Obtén el valor del parámetro 'id'

    // Si el parámetro 'id' está presente, mostrar el detalle del producto
    if (productoId) {
        detalleProducto.classList.remove('hidden');
    }

    // Ocultar el modal
    closeBtn.addEventListener('click', () => {
        detalleProducto.classList.add('hidden');

    });
});