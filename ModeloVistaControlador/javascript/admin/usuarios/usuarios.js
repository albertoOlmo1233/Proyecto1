class Usuario {
    // Obtener usuarios
    async getUsers() {
        const funcion = "getUsuarios";
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
                                <a href="?controller=admin&action=usuariosConfig&funcion=modify&userId=${user.id}" class="material-symbols-outlined cursor-pointer text-decoration-none mb-4">
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

            // Asegurarse de que la tabla exista en el DOM
            const listaUsuarios = document.getElementById("listaUsuarios");
            if (listaUsuarios) {
                listaUsuarios.innerHTML = content;
            } else {
                console.error("No se encontró el elemento con id 'listaUsuarios'.");
            }
        } else {
            console.error("Error en la API: Datos no disponibles o estado incorrecto.");
        }
    }

    // Crear usuarios
    async addUser() {
        console.log("Crear usuario.");
    
        // URL para la creación de usuarios en la API
        const fullURL = `http://workandtaste.com/?controller=api&action=createUsuario`;
    
        // Crear el formulario de creación
        const content = `
            <div class="col-12 col-sm-6 col-md-6 col-lg-9 mt-0 mb-5">
                <div class="card h-100 w-100">
                    <div class="card-body">
                        <form id="createUserForm" action="${fullURL}" method="POST">
                            <h3>Crear Usuario</h3>
                            <label>Nombre:</label>
                            <input type="text" name="nombre" required><br>
                            <label>Apellidos:</label>
                            <input type="text" name="apellidos" required><br>
                            <label>Correo:</label>
                            <input type="email" name="correo" required><br>
                            <label>Contraseña:</label>
                            <input type="password" name="password" required><br>
                            <label>Dirección:</label>
                            <input type="text" name="direccion" required><br>
                            <div class="d-flex flex-row">
                                <button type="submit">Crear</button>
                                <button type="button" id="cancelCreate">Cancelar</button>
                            </div><br>
                        </form>
                    </div>
                </div>
            </div>
        `;
        
        // Reemplazar el contenido actual con el formulario
        const listaUsuarios = document.getElementById("listaUsuarios");
        if (listaUsuarios) {
            listaUsuarios.innerHTML = content;
    
            // Agregar manejador para el botón de cancelar
            document.getElementById("cancelCreate").addEventListener("click", () => {
                this.getUsers(); // Volver a la lista de usuarios
            });
        } else {
            console.error("No se encontró el elemento con id 'listaUsuarios'.");
        }
    
        // Hacer la solicitud para crear el usuario
        const respuesta = await fetch(fullURL, {
            method: "POST",
            body: new FormData(document.getElementById("createUserForm")) // Enviar datos del formulario
        });
        
        // Verifica si la respuesta fue exitosa
        if (respuesta.ok) {
            // Intentar convertir la respuesta a JSON
            const usuarioCreado = await respuesta.json();

            // Verificar si la respuesta fue exitosa
            if (usuarioCreado.estado === "Exito") {
                // Si la creación fue exitosa, mostrar el mensaje de éxito
                alert(usuarioCreado.mensaje);
            } else {
                // Si la creación falló, mostrar el mensaje de error
                alert(usuarioCreado.mensaje);
            }

            // Realizar la redirección después de la alerta
            window.location.href = "?controller=admin&action=usuariosConfig&funcion=create"; // Redirigir después de mostrar el mensaje
        } else {
            // Si la respuesta de la API no es exitosa, mostrar el error
            alert("Error en la creación del usuario. Intenta de nuevo.");
        }
        
    }
    

    // Modificar usuarios
    async modifyUser(userId) {
        console.log(`Modificar usuario con ID: ${userId}`);
        const funcion = "modifyUsuarios";
        const fullURL = `http://workandtaste.com/?controller=api&action=${funcion}&userId=${userId}`;
        const respuesta = await fetch(fullURL);
        const usuario = await respuesta.json();

        if (usuario.estado === "Exito" && usuario.data) {
            // Obtener los datos del usuario
            const user = usuario.data;

            // Crear el formulario con los datos del usuario
            const content = `
            <div class="col-12 col-md-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Modificar Usuario</h3>
                        <form id="modifyUserForm" action="${fullURL}" method="POST">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="${user.nombre}" required>
                            </div>
                            <div class="mb-3">
                                <label for="apellidos" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos" value="${user.apellidos}" required>
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo</label>
                                <input type="email" class="form-control" id="correo" name="correo" value="${user.correo}" required>
                            </div>
                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" value="${user.direccion}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            <button type="button" class="btn btn-secondary" id="cancelModify">Cancelar</button>
                        </form>
                    </div>
                </div>
            </div>
            `;

            // Reemplazar el contenido actual con el formulario
            const listaUsuarios = document.getElementById("listaUsuarios");
            if (listaUsuarios) {
                listaUsuarios.innerHTML = content;

                // Agregar manejador para el formulario
                const form = document.getElementById("modifyUserForm");
                form.addEventListener("submit", async (e) => {
                    e.preventDefault();
                    const formData = new FormData(form);
                    const updatedUser = {
                        nombre: formData.get("nombre"),
                        apellidos: formData.get("apellidos"),
                        correo: formData.get("correo"),
                        direccion: formData.get("direccion"),
                    };

                    // Llamar a la API para actualizar el usuario
                    const updateResponse = await fetch(fullURL, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify(updatedUser),
                    });

                    const updateResult = await updateResponse.json();
                    if (updateResult.estado === "Exito") {
                        alert("Usuario actualizado exitosamente");
                        this.getUsers(); // Volver a la lista de usuarios
                    } else {
                        console.error("Error al actualizar el usuario:", updateResult);
                        alert("No se pudo actualizar el usuario. Inténtalo de nuevo.");
                    }
                });

                // Manejar el botón de cancelar
                const cancelModify = document.getElementById("cancelModify");
                cancelModify.addEventListener("click", () => {
                    this.getUsers(); // Volver a la lista de usuarios
                });
            } else {
                console.error("No se encontró el elemento con id 'listaUsuarios'.");
            }
        } else {
            console.error("Error en la API: Usuario no encontrado.");
            alert("No se pudo cargar la información del usuario.");
        }
    }

    // Eliminar usuarios (esta función aún necesita ser implementada)
    async eraseUser() {
        // Implementar lógica para eliminar usuarios
    }

    // Ejecutar función al cargar el DOM
    static init() {
        const usuario = new Usuario();
        document.addEventListener("DOMContentLoaded", function () {
            // Obtener parámetros de la URL
            const urlParams = new URLSearchParams(window.location.search);
            const funcion = urlParams.get("funcion");

            if (funcion === "get") {
                usuario.getUsers();
            } else if (funcion === "create") {
                usuario.addUser();
            } else if (funcion === "modify") {
                const userId = urlParams.get("userId");
                usuario.modifyUser(userId);
            } else if (funcion === "erase") {
                usuario.eraseUser();
            } else {
                console.warn("No se ha encontrado una función válida en la URL.");
            }
        });
    }
}

// Inicializar la clase al cargar el DOM
Usuario.init();
