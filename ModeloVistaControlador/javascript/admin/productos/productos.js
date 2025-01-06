class Producto {
    // Método para obtener productos
    async getProductos() {
        const API_URL = "?controller=api&action=getProductos";
        const respuesta = await fetch(API_URL);
        const productos = await respuesta.json();

        if (productos.estado === "Exito" && productos.data) {
            let content = "";
            productos.data.forEach(producto => {
                const precio = producto.precio || "N/A"; // Precio original
                const precioOferta = producto.precioOferta || 0; // Aseguramos que precioOferta tenga un valor por defecto
            
                // Construcción dinámica del precio
                let bloquePrecio = "";
                if (precioOferta > 0) {
                    bloquePrecio = `
                    <div class="d-flex flex-row gap-3">
                        <p><b>Precio:</b></p>
                        <p class="card-text h3-p text-decoration-line-through">${precio} €</p>
                        <p class="card-text h3-p text-success">${precioOferta} €</p>
                    </div>
                    `;
                } else {
                    bloquePrecio = `
                        <p class="card-text h3-p"><b>Precio:</b> ${precio} €</p>
                    `;
                }
            
                // Estructura de la tarjeta
                content += `
                    <div class="col-12 col-sm-6 col-md-6 col-lg-4 mt-0 mb-5">
                        <div class="card h-100 w-100">
                            <div class="card-body">
                                <img src="${producto.imagen}" alt="Imagen del producto" style="max-width: 100%; height: auto;">
                                <p><b>Categoría:</b> ${producto.categoria}</p>
                                <h3 class="card-title">${producto.nombre}(${producto.id})</h3>
                                ${bloquePrecio}
                                <p><b>Descripción:</b> ${producto.descripcion}</p>
                                <p><b>ID Oferta:</b> ${producto.id_oferta || "No aplica"}</p>
                                <div class="d-flex flex-row justify-content-around">
                                    <a href="?controller=admin&action=productosConfig&funcion=modify&id=${producto.id}" class="material-symbols-outlined cursor-pointer text-decoration-none mb-4">
                                        edit
                                    </a> 
                                    <a href="?controller=admin&action=productosConfig&funcion=erase&id=${producto.id}" class="material-symbols-outlined cursor-pointer text-decoration-none mb-4">
                                        delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            // Insertar en el DOM
            const listaProductos = document.getElementById("listaProductos");
            if (listaProductos) {
                const titulo = "<h1>Lista de Productos:</h1>";
                listaProductos.innerHTML = titulo + content;
            } else {
                console.error("No se encontró el elemento con id 'listaProductos'.");
            }
        } else {
            console.error("Error: No se obtuvo datos de producto o el estado no es 'Exito'.");
        }
    }

    // Método para crear un producto
    async addProducto() {
        console.log("Crear producto.");

        // URL para la creación de productos en la API
        const fullURL = `?controller=api&action=createProductos`;

        // Crear el formulario de creación
        const content = `
            <div class="col-12 col-sm-6 col-md-6 col-lg-9 mt-0">
                <div class="card h-100 w-100">
                    <div class="card-body">
                        <form id="formulario-creacion-producto" action="${fullURL}" method="POST" enctype="multipart/form-data">
                            <h3>Crear Producto</h3>
                            <label>Nombre:</label>
                            <input type="text" name="nombre" required><br>
                            <label>Descripción:</label>
                            <input type="text" name="descripcion" required><br>
                            <label>Precio:</label>
                            <input type="number" step="0.01" name="precio" required><br>
                            <label for="imagen">Selecciona una imagen:</label>
                            <input type="file" class="form-control" id="imagen" accept="image/*" required>
                            <img id="imagenPrevia" src="" alt="Vista previa de la imagen">
                            <label>Categoría:</label>
                            <input type="text" name="categoria" required><br>
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
        const listaProductos = document.getElementById("listaProductos");
        if (listaProductos) {
            listaProductos.innerHTML = content;
        } else {
            console.error("No se encontró el elemento con id 'listaProductos'.");
        }

        // Vista previa de la imagen:
        const inputImagen = document.getElementById('imagen');
        const imagenPrevia = document.getElementById('imagenPrevia');

        inputImagen.addEventListener("change", function(event) {
            const archivo = event.target.files[0];
            if (archivo) {
                const reader = new FileReader();

                // Crear una función para definir lo que se hará al leer la imagen
                reader.onload = function(event) {
                    imagenPrevia.src = event.target.result;
                    imagenPrevia.style.display = "block";
                }

                // Llamamos a la función y le pasamos el archivo
                reader.readAsDataURL(archivo);
            } else {
                console.error('No se ha seleccionado ningún archivo');
                imagenPrevia.src = "";
                imagenPrevia.style.display = "none";
            }
        });

        // Gestionar los datos y enviarlos sin recargar la página
        document.getElementById("formulario-creacion-producto").addEventListener("submit", async function (event) {
            event.preventDefault(); // Evitar envío normal

            const inputImagen = document.getElementById('imagen'); // Obtener referencia al input de la imagen
            if (!inputImagen.files.length) {
                alert('Por favor, selecciona una imagen antes de enviar el formulario.');
                return;
            }

            // Crear el objeto FormData para manejar tanto los datos del formulario como el archivo
            const formData = new FormData();
            const categoria = event.target.categoria.value;
            formData.append('categoria', categoria); // Agregar la categoría al FormData
            formData.append('imagen', inputImagen.files[0]);

            // Subir la imagen al servidor y obtener la URL
            const respuestaImagen = await fetch('?controller=api&action=uploadImagen', {
                method: 'POST',
                body: formData,
            });

            if (!respuestaImagen.ok) {
                alert("Error al subir la imagen.");
                return;
            }

            const imagenData = await respuestaImagen.json();
            if (imagenData.estado !== 'Exito') {
                alert("Error al obtener la URL de la imagen.");
                return;
            }

            // Ahora que tenemos la URL de la imagen, podemos enviar el resto de los datos en formato JSON
            const datos = {
                nombre: event.target.nombre.value,
                descripcion: event.target.descripcion.value,
                precio: parseFloat(event.target.precio.value),
                imagen: imagenData.url, // Usamos la URL devuelta del servidor
                categoria: categoria,
            };

            console.log("Datos enviados:", datos);

            // Enviar los datos utilizando fetch con JSON
            const respuesta = await fetch(event.target.action, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(datos),
            });

            if (!respuesta.ok) {
                throw new Error("Error en la respuesta del servidor.");
            }

            const datosPeticion = await respuesta.json();

            if (datosPeticion.estado === "Exito") {
                alert(datosPeticion.mensaje);
                window.location.href = "?controller=admin&action=productosConfig&funcion=get";
            } else {
                alert("Error: " + datosPeticion.mensaje);
            }
        });

        // Cancelar petición
        document.getElementById("cancelCreate").addEventListener("click", () => {
            window.location.href = "?controller=admin&action=productosConfig&funcion=get";
        });
    }

    // Función para obtener usuario por ID
    async getProductoById(productoId) {
        const url = `?controller=api&action=getProductos&id=${productoId}`;
        console.log("URL solicitada:", url);  // Log para verificar la URL
        
        try {
            const respuesta = await fetch(url);

            if (!respuesta.ok) {
                throw new Error(`Error al obtener el usuario: ${respuesta.status} ${respuesta.statusText}`);
            }

            const producto = await respuesta.json();  // Usamos .json() para obtener el objeto de usuario directamente
            console.log("Respuesta completa del servidor:", producto);  // Verificar los datos completos

            if (producto.estado === 'Exito' && producto.data) {
                return producto.data;  // Retorna el usuario directamente si la respuesta es exitosa
            } else {
                throw new Error("No se pudo obtener el usuario o estado incorrecto.");
            }
        } catch (error) {
            console.error("Error al obtener los datos del producto:", error);
            throw error;  // Lanzamos el error para ser manejado por quien llame la función
        }
    }

    // Función para modificar un usuario
    async modifyProducto(productoId) {
        console.log(`Modificar producto con ID: ${productoId}`);
        
        if (!productoId) {
            console.error("No se encontró el productoId.");
            alert("Producto no encontrado.");
            return;  // Si no hay un productoId válido, salir de la función
        }else {
            alert("Producto encontrado: " + productoId);
        }
    
        const fullURL = `?controller=api&action=modifyProductos`;
    
        // Obtener los datos del producto
        const producto = await this.getProductoById(productoId);
        
        if (!producto) {
            console.error("No se encontró el producto.");
            alert("No se encontró el producto.");
            return;
        }
    
        // Crear el contenido del formulario de modificación con los datos del producto
        const content = `
            <div class="col-12 col-sm-6 col-md-6 col-lg-9 mt-0 mb-5">
                <div class="card h-100 w-100">
                    <div class="card-body">
                        <form id="formulario-modificar-producto" action="${fullURL}">
                            <h3>Modificar producto (${producto.id})</h3>
                            <label>Nombre de producto:</label>
                            <input type="text" placeholder="${producto.nombre}" name="nombre">
                            <label>Descripción:</label>
                            <input type="text" placeholder="${producto.descripcion}" name="descripcion">
                            <label>Precio:</label>
                            <input type="decimal" placeholder="${producto.precio}" name="precio">
                            <label>Imagen:</label>
                            <input type="file" class="form-control" id="imagen" accept="image/*">
                            <img id="imagenPrevia" src="${producto.imagen}" alt="Vista previa de la imagen">
                            <label>Categoría:</label>
                            <input type="text" placeholder="${producto.categoria}" name="categoria">
                            <div class="d-flex flex-row">
                                <button type="submit">Modificar</button>
                                <button type="button" id="cancelModify">Cancelar</button>
                            </div><br>
                        </form>
                    </div>
                </div>
            </div>
        `;
    
        const listaProductos = document.getElementById("listaProductos");
        if (listaProductos) {
            listaProductos.innerHTML = content;
        } else {
            console.error("No se encontró el elemento con id 'listaProductos'.");
        }
    
        // Vista previa de la imagen:
        const inputImagen = document.getElementById('imagen');
        const imagenPrevia = document.getElementById('imagenPrevia');
    
        inputImagen.addEventListener("change", function(event){
            const archivo = event.target.files[0];
            if(archivo){
                const reader = new FileReader();
    
                reader.onload = function(event) {
                    imagenPrevia.src = event.target.result;
                    imagenPrevia.style.display = "block";
                }
    
                reader.readAsDataURL(archivo);
            } else {
                console.error('No se ha seleccionado ningún archivo');
                imagenPrevia.src="";
                imagenPrevia.style.display = "none";
            }
        });
    
        // Gestionar los datos, enviarlos sin recargar la página
        document.getElementById("formulario-modificar-producto").addEventListener("submit", async function (event) {
            event.preventDefault(); // Evitar envío normal
    
            // Verifica si se ha seleccionado una imagen
            let urlImagen = null;
    
            if (inputImagen.files.length) {
                const categoriaConS = event.target.categoria.value.toLowerCase() + 's';
                const nombreImagen = inputImagen.files[0].name;
                urlImagen = `imagenes/Productos/${categoriaConS}/${nombreImagen}`;
            }
    
            const datos = {
                nombre: event.target.nombre.value,
                descripcion: event.target.descripcion.value,
                precio: parseFloat(event.target.precio.value),
                imagen: urlImagen,
                categoria: event.target.categoria.value,
            };
    
            console.log("Datos enviados:", datos);
    
            // Incluir el productoId en el cuerpo de la petición
            const respuesta = await fetch(event.target.action, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    datos, 
                    productoId: productoId }),
            });
    
            if (!respuesta.ok) {
                throw new Error("Error en la respuesta del servidor.");
            }
    
            const datosPeticion = await respuesta.json();
            console.log(datosPeticion);
    
            if (datosPeticion.estado === "Exito") {
                alert(datosPeticion.mensaje);
                window.location.href = "?controller=admin&action=productosConfig&funcion=get";
            } else {
                alert("Error: " + datosPeticion.mensaje);
            }
        });
    
        // Acción al hacer click en "Cancelar"
        document.getElementById("cancelModify").addEventListener("click", () => {
            window.location.href = "?controller=admin&action=productosConfig&funcion=get";
        });
    }
    

    // Método para eliminar productos (no implementado en el original)
    async eraseProducto(userId) {
        const confirmDelete = confirm("¿Estás seguro de que deseas eliminar este producto?");
        if (!confirmDelete) return;
    
        console.log("Eliminación confirmada, enviando solicitud...");
    
        const fullURL = `?controller=api&action=eraseProductos&id=${userId}`;

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
                await this.getProductos();  // Call to getUsers instead of location.reload();
            } else {
                await this.getProductos();
            }
    }

    // Método estático para inicializar la clase
    static init() {
        const producto = new Producto();
        document.addEventListener("DOMContentLoaded", function () {
            // Obtener parámetros de la URL
            const urlParams = new URLSearchParams(window.location.search);
            const funcion = urlParams.get("funcion");

            if (funcion === "get") {
                producto.getProductos(); // Cambiar a getProductos
            } else if (funcion === "create") {
                producto.addProducto(); // Cambiar a addProducto
            } else if (funcion === "modify") {
                const productoId = urlParams.get("id");
                console.log(productoId);
                producto.modifyProducto(productoId); // Cambiar a modifyProducto
            } else if (funcion === "erase") {
                const productoId = urlParams.get("id");
                producto.eraseProducto(productoId); // Cambiar a eraseProducto
            } else {
                console.warn("No se ha encontrado una función válida en la URL.");
            }
        });
    }
}

// Inicializar la clase al cargar el DOM
Producto.init();
