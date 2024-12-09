// Mostrar el modal para editar los datos
const editBtn_nombre = document.getElementById('edit-btn-nombre');
const editBtn_contraseña = document.getElementById('edit-btn-contraseña');
const editBtn_direccion = document.getElementById('edit-btn-direccion');

const formulario = document.getElementById('formulario');
const datos_nombre = document.querySelector(".mostrar-0");
const datos_contraseña = document.querySelector(".mostrar-1");
const datos_direccion = document.querySelector(".mostrar-2");
const contenedor = document.getElementById('contenedor');
const closeBtn = document.getElementById('close-btn');

editBtn_nombre.addEventListener('click', () => {
    contenedor.classList.remove('hidden');
    formulario.action = `?controller=user&action=modificarNombre&id=${userId}`;
    titulo.textContent = "Modificar tu nombre de usuario"; // Cambia el título
    descripcion.textContent = "Introduce tu nombre de usuario a continuación"; // Cambia la descripción
    datos_nombre.classList.remove('hidden');
    datos_contraseña.classList.add('hidden');
    datos_direccion.classList.add('hidden');
});

editBtn_contraseña.addEventListener('click', () => {
    contenedor.classList.remove('hidden');
    formulario.action = `?controller=user&action=modificarContraseña&id=${userId}`;
    titulo.textContent = "Modificar tu contraseña"; // Cambia el título
    descripcion.textContent = "Introduce tu contraseña a continuación"; // Cambia la descripción
    datos_contraseña.classList.remove('hidden');
    datos_nombre.classList.add('hidden');
    datos_direccion.classList.add('hidden');
});

editBtn_direccion.addEventListener('click', () => {
    contenedor.classList.remove('hidden');
    formulario.action = `?controller=user&action=modificarDireccion&id=${userId}`;
    titulo.textContent = "Update your direccion"; // Cambia el título
    descripcion.textContent = "Introduce tu direccion a continuación"; // Cambia la descripción
    datos_direccion.classList.remove('hidden');
    datos_contraseña.classList.add('hidden');
    datos_nombre.classList.add('hidden');
});

// Ocultar el modal
closeBtn.addEventListener('click', () => {
    contenedor.classList.add('hidden');
    formulario.action = "?controller=user";

});