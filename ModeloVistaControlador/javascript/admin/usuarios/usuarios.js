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
                <div class="col-12 col-sm-6 col-md-6 col-lg-4 mt-0 mb-5">
                    <div class="card h-100 w-100">
                        <div class="card-body">
                            <p>ID: ${user.id}</p>
                            <h3 class="card-title">${user.nombre} ${user.apellidos}</h3>
                            <p>Correo: ${user.correo}</p>
                            <p>Direccion: ${user.direccion}</p>
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
                `;
            });

            // Asegurarse de que la tabla existe en el DOM
            const listaUsuarios = document.getElementById("listaUsuarios");
            if (listaUsuarios) {
                listaUsuarios.innerHTML = `
                    ${content}
                `;
            } else {
                console.error("No se encontró el elemento con id 'listaUsuarios'.");
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
