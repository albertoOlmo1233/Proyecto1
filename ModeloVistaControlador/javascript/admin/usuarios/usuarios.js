let funcion = null;

// Obtener usuarios
async function getUsers() {
        funcion = "getUsuarios";
        const fullURL = `http://workandtaste.com/?controller=api&action=${funcion}`;
        const respuesta = await fetch(fullURL);
        console.log(respuesta);

        // Intentar convertir la respuesta a JSON
        const usuarios = await respuesta.json();

        if (usuarios.estado === "Exito" && Array.isArray(usuarios.data)) {
            // Crear el contenido de la tabla con los datos de los usuarios
            let content = "";
            usuarios.data.forEach(user => {
                content += `
                <tr>
                    <td>${user.id}</td>
                    <td>${user.nombre}</td>
                    <td>${user.apellidos}</td>
                    <td>${user.correo}</td>
                    <td>${user.direccion}</td>
                    <td>
                    <a class="material-symbols-outlined cursor-pointer">
                    person_add
                    </a> 
                    <a class="material-symbols-outlined cursor-pointer">
                    manage_accounts
                    </a> 
                    <a class="material-symbols-outlined cursor-pointer">
                    person_remove
                    </a></td>
                </tr>
                `;
            });

            // Asegurarse de que la tabla existe en el DOM
            const tablaGeneral = document.getElementById("tablaGeneral");
            if (tablaGeneral) {
                tablaGeneral.innerHTML = `
                    <thead>
                        <tr>
                            <th class="centered">ID</th>
                            <th class="centered">Nombre</th>
                            <th class="centered">Apellidos</th>
                            <th class="centered">Correo</th>
                            <th class="centered">Direccion</th>
                            <th class="centered">Accion</th>
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
            console.error("Error en la API: Datos no disponibles o estado incorrecto.");
        }
}

// Crear usuarios
async function addUser() {
    // Implementar lógica para crear usuarios
}

// Modificar usuarios 
async function modifyUser() {
    // Implementar lógica para modificar usuarios
}

// Eliminar usuarios 
async function eraseUser() {
    // Implementar lógica para eliminar usuarios
}

// Ejecutar función al cargar el DOM
document.addEventListener("DOMContentLoaded", function () {
    // Obtener parámetros de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const funcion = urlParams.get("funcion");

    if (funcion === "get") {
        getUsers();
    } else if (funcion === "create") {
        addUser();
    } else if (funcion === "modify") {  // Se corrigió "modifiy"
        modifyUser();
    } else if (funcion === "erase") {
        eraseUser();
    } else {
        console.warn("No se ha encontrado una función válida en la URL.");
    }
});
