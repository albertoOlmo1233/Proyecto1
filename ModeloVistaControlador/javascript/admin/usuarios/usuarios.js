class Usuario {
    // Obtener usuarios
    async getUsers() {
        const funcion = "getUsuarios";
        const fullURL = `http://workandtaste.com/?controller=api&action=${funcion}`;
        const respuesta = await fetch(fullURL);
    
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
                                <p>Dirección: ${user.direccion}</p>
                                <div class="d-flex flex-row justify-content-around">
                                    <a href="?controller=admin&action=usuariosConfig&funcion=modify&id=${user.id}" class="material-symbols-outlined cursor-pointer text-decoration-none mb-4">
                                    edit
                                    </a> 
                                    <a href="?controller=admin&action=usuariosConfig&funcion=erase&id=${user.id}" class="material-symbols-outlined text-decoration-none cursor-pointer mb-4">
                                    delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
    
            // Asegurarse de que la tabla exista en el DOM

            const titulo = "<h1 class='text-center pb-5'>Lista de usuarios:</h1>";
            const listaUsuarios = document.getElementById("listaUsuarios");
            if (listaUsuarios) {
                listaUsuarios.innerHTML = titulo + content;
    
                // Agregar eventos de eliminación a cada usuario
                usuarios.data.forEach(user => {
                    const eliminarBtn = document.getElementById(`eliminarUsuario${user.id}`);
                    if (eliminarBtn) {
                        eliminarBtn.addEventListener("click", () => {
                            this.eraseUser(user.id); // Eliminar usuario sin recargar página
                        });
                    }
                });
            } else {
                console.error("No se encontró el elemento con id 'listaUsuarios'.");
            }
        } else {
            console.error("Error en la API: Datos no disponibles o estado incorrecto.");
        }
    }

    async eraseUser(userId) {
        const confirmDelete = confirm("¿Estás seguro de que deseas eliminar este usuario?");
        if (!confirmDelete) return;
    
        console.log("Eliminación confirmada, enviando solicitud...");
    
        const fullURL = `http://workandtaste.com/?controller=api&action=eraseUsuarios&id=${userId}`;
    
        try {
            const respuesta = await fetch(fullURL);
            if (!respuesta.ok) {
                throw new Error(`Error HTTP: ${respuesta.status}`);
            }
    
            const resultado = await respuesta.json();
            console.log("Respuesta recibida:", resultado);
            alert(resultado.mensaje);
            
            // Recargar la lista de usuarios si la eliminación fue exitosa
            if (resultado.estado === "Exito") {
                // Instead of reloading the entire page, you can re-fetch the users
                await this.getUsers();  // Call to getUsers instead of location.reload();
            }
        } catch (error) {
            console.error("Error al eliminar el usuario:", error);
            alert("Hubo un problema al intentar eliminar el usuario. Inténtalo de nuevo más tarde.");
        }
    }
    

    // Crear usuarios
    async addUser() {
        console.log("Crear usuario.");
    
        // URL para la creación de usuarios en la API
        const fullURL = `http://workandtaste.com/?controller=api&action=createUsuarios`;
    
        // Crear el formulario de creación
        const content = `
            <div class="col-12 col-sm-6 col-md-6 col-lg-9 mt-0 mb-5">
                <div class="card h-100 w-100">
                    <div class="card-body">
                        <form id="formulario-creacion-usuario" action="${fullURL}" method="POST">
                            <h3>Crear Usuario</h3>
                            <label>Nombre:</label>
                            <input type="text" name="nombre" required><br>
                            <label>Apellidos:</label>
                            <input type="text" name="apellidos" required><br>
                            <label>Correo:</label>
                            <input type="email" name="correo" required><br>
                            <label>Contraseña:</label>
                            <input type="password" name="contraseña" required><br>
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
        } else {
            console.error("No se encontró el elemento con id 'listaUsuarios'.");
        }
        
        // Gestionar los datos, enviarlos sin recargar la pagina
        // Por que esta parte la hago sin recargar la pagina? 
        // Respuesta: Lo veo mas comodo para segun el resultado aplicarle una alerta.
        document.getElementById("formulario-creacion-usuario").addEventListener("submit", async function (event) {
            event.preventDefault();
            const datos = {
                nombre: event.target.nombre.value,
                apellidos: event.target.apellidos.value,
                correo: event.target.correo.value,
                contraseña: event.target.contraseña.value,
                direccion: event.target.direccion.value,
            }
    
            console.log(datos); // Verifica la estructura de datos antes de enviarlos
    
            const respuesta = await fetch(event.target.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json', // Añadir encabezado
                },
                body: JSON.stringify(datos), // Enviar directamente el objeto de datos
            });
    
            const datosPeticion = await respuesta.json(); 
    
            // Manejar la respuesta
            if (datosPeticion.estado === "Exito") {
                alert(datosPeticion.mensaje);
                window.location.href = "http://workandtaste.com/?controller=admin&action=usuariosConfig&funcion=get";
            } else {
                alert("Error: " + datosPeticion.mensaje);
            }
        });
    

        // Cancelar peticion
        document.getElementById("cancelCreate").addEventListener("click", () => {
            window.location.href = "http://workandtaste.com/?controller=admin&action=usuariosConfig&funcion=get";
        });
    }
    
    // Función para obtener usuario por ID
    async getUsuarioById(id) {
        const url = `http://workandtaste.com/?controller=api&action=getUsuarios&id=${id}`;
        console.log("URL solicitada:", url);  // Log para verificar la URL
        
        try {
            const respuesta = await fetch(url);

            if (!respuesta.ok) {
                throw new Error(`Error al obtener el usuario: ${respuesta.status} ${respuesta.statusText}`);
            }

            const usuario = await respuesta.json();  // Usamos .json() para obtener el objeto de usuario directamente
            console.log("Respuesta completa del servidor:", usuario);  // Verificar los datos completos

            if (usuario.estado === 'Exito' && usuario.data) {
                return usuario.data;  // Retorna el usuario directamente si la respuesta es exitosa
            } else {
                throw new Error("No se pudo obtener el usuario o estado incorrecto.");
            }
        } catch (error) {
            console.error("Error al obtener los datos del usuario:", error);
            throw error;  // Lanzamos el error para ser manejado por quien llame la función
        }
    }

    // Función para modificar un usuario
    async modifyUser(userId) {
        console.log(`Modificar usuario con ID: ${userId}`);
        const fullURL = `http://workandtaste.com/?controller=api&action=modifyUsuarios`;

        // Obtener los datos del usuario
        const usuario = await this.getUsuarioById(userId);
        
        if (!usuario) {
            console.error("No se encontró el usuario.");
            alert("No se encontró el usuario.");
            return;
        }

        // Crear el contenido del formulario de modificación con los datos del usuario
        const content = `
            <div class="col-12 col-sm-6 col-md-6 col-lg-9 mt-0 mb-5">
                <div class="card h-100 w-100">
                    <div class="card-body">
                        <form id="formulario-modificar-usuario" action=${fullURL}>
                            <h3>Modificar datos de usuario (${usuario.id})</h3>
                            <label>Nombre de usuario</label>
                            <input type="text" placeholder="${usuario.nombre}" name="nombre">
                            <label>Apellidos</label>
                            <input type="text" placeholder="${usuario.apellidos}" name="apellidos">
                            <label>Contraseña</label>
                            <input type="password" placeholder="Introduce tu nueva contraseña" name="contraseña">
                            <label>Correo</label>
                            <input type="email" placeholder="${usuario.correo}" name="correo">
                            <label>Direccion</label>
                            <input type="text" placeholder="${usuario.direccion}" name="direccion">
                            <div class="d-flex flex-row">
                                <button type="submit">Modificar</button>
                                <button type="button" id="cancelModify">Cancelar</button>
                            </div><br>
                        </form>
                    </div>
                </div>
            </div>
        `;

        const listaUsuarios = document.getElementById("listaUsuarios");
        if (listaUsuarios) {
            listaUsuarios.innerHTML = content;
        } else {
            console.error("No se encontró el elemento con id 'listaUsuarios'.");
        }

        // Gestionar los datos, enviarlos sin recargar la pagina
        document.getElementById("formulario-modificar-usuario").addEventListener("submit", async function (event) {
            event.preventDefault();
            const datos = {
                nombre: event.target.nombre.value,
                apellidos: event.target.apellidos.value,
                contraseña: event.target.contraseña.value,
                correo: event.target.correo.value,
                direccion: event.target.direccion.value,
            }

            console.log(event.target.nombre.value);
                const respuesta = await fetch(event.target.action, {
                    method: 'POST',
                    body: JSON.stringify({
                        datos,
                        userId: userId,
                    }),
                });
            
                const datosPeticion = await respuesta.json(); 
            
                // Manejar la respuesta
                if (datosPeticion.estado === "Exito") {
                    alert(datosPeticion.mensaje);
                    window.location.href = "http://workandtaste.com/?controller=admin&action=usuariosConfig&funcion=get";
                } else {
                    alert("Error: " + datosPeticion.mensaje);
                }
        });
        
        
        // Acción al hacer click en "Cancelar"
        document.getElementById("cancelModify").addEventListener("click", () => {
            window.location.href = "http://workandtaste.com/?controller=admin&action=usuariosConfig&funcion=get";
        });
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
                const userId = urlParams.get("id");
                usuario.modifyUser(userId);
            } else if (funcion === "erase") {
                const userId = urlParams.get("id");
                usuario.eraseUser(userId);
            } else {
                console.warn("No se ha encontrado una función válida en la URL.");
            }
        });
    }
}

// Inicializar la clase al cargar el DOM
Usuario.init();
