document.addEventListener('DOMContentLoaded', function () {
    // Validar existencia de elementos antes de agregar eventos
    const editBtn_nombre = document.querySelector('#edit-btn-nombre');
    const editBtn_contraseña = document.querySelector('#edit-btn-contraseña');
    const editBtn_direccion = document.querySelector('#edit-btn-direccion');
    const editBtn_apellidos = document.querySelector('#edit-btn-apellidos');
    const formulario = document.querySelector('#formulario');
    const datos_nombre = document.querySelector('.mostrar-0');
    const datos_contraseña = document.querySelector('.mostrar-1');
    const datos_direccion = document.querySelector('.mostrar-2');
    const datos_apellidos = document.querySelector('.mostrar-3');
    const contenedor = document.querySelector('#contenedor');
    const closeBtn = document.querySelector('#close-btn');

    // Configuración para el botón de editar nombre
    if (editBtn_nombre) {
        editBtn_nombre.addEventListener('click', () => {
            contenedor.classList.remove('hidden');
            formulario.action = `?controller=user&action=modificarNombre&id=${userId}`;
            document.querySelector('#titulo').textContent = "Modificar tu nombre de usuario";
            document.querySelector('#descripcion').textContent = "Introduce tu nombre de usuario a continuación";
            datos_nombre.classList.remove('hidden');
            datos_contraseña.classList.add('hidden');
            datos_direccion.classList.add('hidden');
            datos_apellidos.classList.add('hidden');
        });
    }

    // Configuración para el botón de editar contraseña
    if (editBtn_contraseña) {
        editBtn_contraseña.addEventListener('click', () => {
            contenedor.classList.remove('hidden');
            formulario.action = `?controller=user&action=modificarContraseña&id=${userId}`;
            document.querySelector('#titulo').textContent = "Modificar tu contraseña";
            document.querySelector('#descripcion').textContent = "Introduce tu contraseña a continuación";
            datos_contraseña.classList.remove('hidden');
            datos_nombre.classList.add('hidden');
            datos_direccion.classList.add('hidden');
            datos_apellidos.classList.add('hidden');
        });
    }

    // Configuración para el botón de editar contraseña
    if (editBtn_apellidos) {
        editBtn_apellidos.addEventListener('click', () => {
            contenedor.classList.remove('hidden');
            formulario.action = `?controller=user&action=modificarApellidos&id=${userId}`;
            document.querySelector('#titulo').textContent = "Modificar tus apellidos";
            document.querySelector('#descripcion').textContent = "Introduce tus apellidos a continuación";
            datos_contraseña.classList.add('hidden');
            datos_nombre.classList.add('hidden');
            datos_direccion.classList.add('hidden');
            datos_apellidos.classList.remove('hidden');
        });
    }

    // Configuración para el botón de editar dirección
    if (editBtn_direccion) {
        editBtn_direccion.addEventListener('click', () => {
            contenedor.classList.remove('hidden');
            formulario.action = `?controller=user&action=modificarDireccion&id=${userId}`;
            document.querySelector('#titulo').textContent = "Modificar tu dirección";
            document.querySelector('#descripcion').textContent = "Introduce tu dirección a continuación";
            datos_direccion.classList.remove('hidden');
            datos_contraseña.classList.add('hidden');
            datos_nombre.classList.add('hidden');
            datos_apellidos.classList.add('hidden');
        });
    }

    // Configuración para el botón de cerrar
    if (closeBtn) {
        closeBtn.addEventListener('click', (event) => {
            event.preventDefault();
            contenedor.classList.add('hidden');
        });
    }
});