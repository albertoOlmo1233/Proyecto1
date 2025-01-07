class Pedido {
    // Obtener pedidos desde la API
    async getPedidos() {
        const API_URL = "?controller=api&action=getPedidos";

        const respuesta = await fetch(API_URL);
        const pedidos = await respuesta.json();

        if (pedidos.estado === "Exito" && pedidos.data) {
            const listaPedidos = document.getElementById("listaPedidos");
            if (listaPedidos) {
                listaPedidos.innerHTML = this.getFiltroHTML(); // Mostrar filtro
                await this.cargarUsuariosSelect(); // Cargar usuarios en el select

                const pedidosContent = await this.renderPedidos(pedidos.data);
                listaPedidos.innerHTML += pedidosContent; // Añadir los pedidos

                // Manejo del filtro
                const filtroPedidos = document.getElementById("filtroPedidos");
                filtroPedidos.addEventListener("submit", async (event) => {
                    event.preventDefault(); // Evitar el envío normal del formulario
                    const datosFiltro = {
                        usuario: event.target.usuario.value,
                        fechaInicio: event.target.fechaInicio.value,
                        fechaFin: event.target.fechaFin.value,
                        precioMin: parseFloat(event.target.precioMin.value) || null,
                        precioMax: parseFloat(event.target.precioMax.value) || null,
                        ordenarPor: event.target.ordenarPor.value // Añadido para recoger el valor de ordenar
                    };

                    // Filtrar los pedidos
                    const pedidosFiltrados = this.filtrarPedidos(pedidos.data, datosFiltro);
                    const pedidosFiltradosContent = await this.renderPedidos(pedidosFiltrados);

                    // Mostrar los pedidos filtrados
                    listaPedidos.innerHTML = this.getFiltroHTML() + pedidosFiltradosContent; // Mostrar filtro + pedidos filtrados
                });

                // Escuchar el cambio de moneda
                const monedaSelect = document.getElementById("moneda");
                monedaSelect.addEventListener("change", async () => {
                    const pedidosContent = await this.renderPedidos(pedidos.data); // Volver a renderizar los pedidos con la nueva moneda
                    listaPedidos.innerHTML = this.getFiltroHTML() + pedidosContent; // Mostrar filtro + todos los pedidos
                });

                // Escuchar el evento de restablecer el formulario
                filtroPedidos.addEventListener("reset", async () => {
                    // Volver a cargar todos los pedidos
                    const pedidosContent = await this.renderPedidos(pedidos.data);
                    listaPedidos.innerHTML = this.getFiltroHTML() + pedidosContent; // Mostrar filtro + todos los pedidos

                    // Recargar usuarios en el select
                    await this.cargarUsuariosSelect(); // Cargar usuarios nuevamente

                    // Reiniciar el formulario
                    filtroPedidos.reset(); // Restablecer los campos del formulario
                });
            } else {
                console.error("No se encontró el elemento con id 'listaPedidos'.");
            }
        } else {
            console.log("Error: No se obtuvieron datos de pedidos.");
            const pedidosContainer = document.getElementById("pedidosContainer");
            if (pedidosContainer) {
                pedidosContainer.innerHTML = "<p>No hay pedidos disponibles.</p>";
            }
        }
    }

    // Función para obtener la tasa de cambio
    async obtenerTasaCambio(moneda) {
        const API_URL = `https://api.freecurrencyapi.com/v1/latest?apikey=fca_live_7LLNWbnHgn1vG7eM4TiibDIarnak3ZlC1g4bbdKd&currencies=EUR,USD,GBP,JPY,AUD`; // Todas las monedas del filtro
        try {
            const respuesta = await fetch(API_URL);
            const data = await respuesta.json();
            return data.data[moneda]; // Retorna la tasa de cambio para la moneda seleccionada
        } catch (error) {
            console.error("Error al obtener la tasa de cambio:", error);
            return null; // Devuelve null en caso de error
        }
    }
    

    // Función para renderizar los pedidos
    async renderPedidos(pedidos) {
        const monedaSeleccionada = document.getElementById("moneda").value; // Obtener la moneda seleccionada
        const tasaCambio = await this.obtenerTasaCambio(monedaSeleccionada); // Obtener la tasa de cambio

        let content = "";
        for (const pedido of pedidos) {
            const productos = pedido.productos || [];
            let productoLinks = productos.length > 0
                ? productos.map(idProducto => 
                    `<a href='?controller=admin&action=pedidosConfig&id=${encodeURIComponent(idProducto)}' class='productoLink'>${encodeURIComponent(idProducto)}</a>`
                  ).join(', ')
                : "No productos disponibles";

            // Obtener el correo del usuario desde la API
            const id_usuario = pedido.id_usuario;
            const obtenerUsuarioUrl = `?controller=api&action=getUsuarios&id=${id_usuario}`;
            
            const respuestaUsuario = await fetch(obtenerUsuarioUrl);
            const usuario = await respuestaUsuario.json();
            console.log(usuario);
            const correoUsuario = usuario.data.correo;

            // Calcular el total en la moneda seleccionada
            const totalPedidoOriginal = pedido.total_pedido; // Asumir que el total es en EUR
            const totalPedidoConvertido = tasaCambio ? (totalPedidoOriginal * tasaCambio).toFixed(2) : totalPedidoOriginal.toFixed(2); // Conversión de precio

            content += `
                <div class="col-12 col-sm-6 col-md-6 col-lg-4 mt-0 mb-5">
                    <div class="card h-100 w-100">
                        <div class="card-body">
                            <p><b>ID Peddido:</b> ${pedido.id_pedido}</p>
                            <h3 class="card-title">${correoUsuario || 'Usuario desconocido'}</h3>
                            <p><b>Productos:</b> ${productoLinks}</p>
                            <p><b>Cantidad:</b> ${pedido.cantidad_total}</p>
                            <p><b>Total:</b> ${totalPedidoConvertido} ${monedaSeleccionada}</p> <!-- Mostrar el precio convertido -->
                            <p><b>Fecha:</b> ${pedido.fecha}</p>
                            <div class="d-flex flex-row justify-content-around">
                                <a href="?controller=admin&action=pedidosConfig&funcion=modify&userId=${pedido.id_usuario}&pedidoId=${pedido.id_pedido}" class="material-symbols-outlined cursor-pointer text-decoration-none mb-4">
                                    edit
                                </a> 
                                <a href="?controller=admin&action=pedidosConfig&funcion=erase&userId=${pedido.id_usuario}&pedidoId=${pedido.id_pedido}" class="material-symbols-outlined cursor-pointer text-decoration-none mb-4">
                                    delete
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }
        return content; // Devolver el contenido en lugar de agregar directamente al DOM
    }

    // Función para obtener el HTML del filtro
    getFiltroHTML() {
        return `
            <div class="container mt-5">
                <form id="filtroPedidos" method="POST">
                    <div class="form-row">
                        <!-- Filtro por Usuario -->
                        <div class="form-group col-md-4">
                            <label for="usuario">Usuario</label>
                            <select id="usuario" name="usuario" class="form-control custom-border">
                                <option value="">Seleccionar usuario</option>
                                <!-- Opciones serán añadidas dinámicamente -->
                            </select>
                        </div>

                        <!-- Filtro por Moneda -->
                        <div class="form-group col-md-4">
                            <label for="moneda">Moneda</label>
                            <select id="moneda" name="moneda" class="form-control custom-border">
                                <option value="EUR">Euro (€)</option>
                                <option value="USD">Dólar (USD)</option>
                                <option value="GBP">Libra (GBP)</option>
                                <option value="JPY">Yen (JPY)</option>
                                <option value="AUD">Dólar Australiano (AUD)</option>
                                <!-- Agregar más monedas según sea necesario -->
                            </select>
                        </div>

                        <!-- Filtro por Fecha -->
                        <div class="form-group col-md-4">
                            <label for="fechaInicio">Fecha de Inicio</label>
                            <input type="date" id="fechaInicio" name="fechaInicio" class="form-control custom-border">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="fechaFin">Fecha de Fin</label>
                            <input type="date" id="fechaFin" name="fechaFin" class="form-control custom-border">
                        </div>
                    </div>

                    <div class="form-row">
                        <!-- Filtro por Precio -->
                        <div class="form-group col-md-4">
                            <label for="precioMin">Precio Mínimo (€)</label>
                            <input type="number" id="precioMin" name="precioMin" class="form-control custom-border" step="0.01" min="0">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="precioMax">Precio Máximo (€)</label>
                            <input type="number" id="precioMax" name="precioMax" class="form-control custom-border" step="0.01" min="0">
                        </div>

                        <!-- Ordenar por -->
                        <div class="form-group col-md-4">
                            <label for="ordenarPor">Ordenar por</label>
                            <select id="ordenarPor" name="ordenarPor" class="form-control custom-border">
                                <option value="">Ordenar por</option>
                                <option value="fecha">Fecha</option>
                                <option value="precio">Precio</option>
                                <option value="usuario">Usuario</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex mb-5 gap-3">
                        <button type="submit" class="neutralButton-white">Filtrar</button>
                        <a href="?controller=admin&action=pedidosConfig&funcion=get" class="neutralButton-white">Restablecer</a>
                    </div>
                </form>
            </div>
        `;
    }

    // Función para filtrar pedidos
    filtrarPedidos(pedidos, filtros) {
        // Filtrar los pedidos
        const pedidosFiltrados = pedidos.filter(pedido => {
            let esValido = true;

            if (filtros.usuario) {
                esValido = esValido && pedido.id_usuario == filtros.usuario; // Filtrar por ID de usuario
            }

            if (filtros.fechaInicio) {
                const fechaPedido = new Date(pedido.fecha);
                const fechaInicio = new Date(filtros.fechaInicio);
                esValido = esValido && fechaPedido >= fechaInicio; // Filtrar por fecha de inicio
            }

            if (filtros.fechaFin) {
                const fechaPedido = new Date(pedido.fecha);
                const fechaFin = new Date(filtros.fechaFin);
                esValido = esValido && fechaPedido <= fechaFin; // Filtrar por fecha de fin
            }

            if (filtros.precioMin !== null) {
                esValido = esValido && pedido.total_pedido >= filtros.precioMin; // Filtrar por precio mínimo
            }

            if (filtros.precioMax !== null) {
                esValido = esValido && pedido.total_pedido <= filtros.precioMax; // Filtrar por precio máximo
            }

            return esValido;
        });

        // Ordenar los pedidos filtrados según la opción seleccionada
        if (filtros.ordenarPor) {
            if (filtros.ordenarPor === 'fecha') {
                pedidosFiltrados.sort((a, b) => new Date(a.fecha) - new Date(b.fecha)); // Ordenar por fecha
            } else if (filtros.ordenarPor === 'precio') {
                pedidosFiltrados.sort((a, b) => a.total_pedido - b.total_pedido); // Ordenar por precio
            } else if (filtros.ordenarPor === 'usuario') {
                pedidosFiltrados.sort((a, b) => a.id_usuario - b.id_usuario); // Ordenar por ID de usuario
            }
        }

        return pedidosFiltrados;
    }
    
    
    
    
    // Función para cargar los usuarios desde el backend
    async cargarUsuariosSelect() {

        // Realizar la solicitud al backend para obtener la lista de usuarios
        const response = await fetch('?controller=api&action=getUsuarios');
        const  usuarios = await response.json();

        if (response.ok) {
            // Obtener el elemento <select>
            const selectUsuarios = document.getElementById('usuario');

            // Iterar sobre los usuarios y añadirlos como opciones
            usuarios.data.forEach(usuario => {
                const option = document.createElement('option');
                option.value = usuario.id; // ID del usuario
                option.textContent = usuario.nombre; // Nombre del usuario
                selectUsuarios.appendChild(option);
            });
        } else {
            console.error('Error al obtener usuarios:', data.mensaje);
        }
    }

    async cargarUsuariosSelect() {
        // Realizar la solicitud al backend para obtener la lista de usuarios
        const response = await fetch('?controller=api&action=getUsuarios');
        const usuarios = await response.json();
    
        // Verificar si la respuesta fue exitosa
        if (response.ok) {
            // Obtener el elemento <select>
            const selectUsuarios = document.getElementById('usuario');
            
            // Limpiar las opciones previas en el select antes de añadir nuevas
            selectUsuarios.innerHTML = '<option value="">Selecciona un usuario</option>';
    
            // Iterar sobre los usuarios y añadirlos como opciones
            usuarios.data.forEach(usuario => {
                const option = document.createElement('option');
                option.value = usuario.id; // ID del usuario
                option.textContent = usuario.nombre; // Nombre del usuario
                selectUsuarios.appendChild(option);
            });
        } else {
            console.error('Error al obtener usuarios:', usuarios.mensaje);
        }
    }
    


    async cargarProductos() {
        const obtenerProductoUrl = '?controller=api&action=getProductos';
    
        try {
            const response = await fetch(obtenerProductoUrl);
            const data = await response.json();
    
            if (data.estado === 'Exito') {
                const tbody = document.querySelector('#productos-table tbody');
    
                data.data.forEach(producto => {
                    // Crear una fila para cada producto
                    const row = document.createElement('tr');
    
                    // Crear la celda del nombre del producto
                    const nombreCell = document.createElement('td');
                    nombreCell.textContent = producto.nombre;
    
                    // Crear la celda de cantidad
                    const cantidadCell = document.createElement('td');
                    const cantidadInput = document.createElement('input');
                    cantidadInput.type = 'number';
                    cantidadInput.min = 0; // Cantidad mínima
                    cantidadInput.placeholder = 'Cantidad';
                    cantidadInput.className = 'producto-cantidad';
                    cantidadInput.disabled = true; // Deshabilitar por defecto
                    cantidadCell.appendChild(cantidadInput);
    
                    // Crear la celda del checkbox
                    const checkboxCell = document.createElement('td');
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.value = producto.id;
                    checkbox.classList.add("mycheck");
                    checkbox.id = `mycheck`;
                    checkbox.addEventListener('change', () => {
                        if (checkbox.checked) {
                            cantidadInput.value = 1; // Asignar valor 1
                            cantidadInput.disabled = false; // Habilitar campo
                        } else {
                            cantidadInput.value = ''; // Limpiar valor
                            cantidadInput.disabled = true; // Deshabilitar campo
                        }
                    });
                    checkboxCell.appendChild(checkbox);
    
                    // Agregar las celdas a la fila
                    row.appendChild(nombreCell);
                    row.appendChild(cantidadCell);
                    row.appendChild(checkboxCell);
    
                    // Agregar la fila al cuerpo de la tabla
                    tbody.appendChild(row);
                });
            } else {
                console.error('Error al obtener productos:', data.error);
            }
        } catch (error) {
            console.error('Error de red:', error);
        }
    }


    async cargarUsuarios() {
        const obtenerUsuariosUrl = '?controller=api&action=getUsuarios'; // Cambia la URL según tu API
    
        try {
            const response = await fetch(obtenerUsuariosUrl);
            const usuarios = await response.json();
    
            if (usuarios.estado === 'Exito') {
                const tbody = document.querySelector('#usuarios-table tbody'); // Asegúrate de tener un tbody en tu tabla de usuarios
    
                // Limpiar la tabla antes de agregar nuevos usuarios
                tbody.innerHTML = '';
    
                // Recorrer los datos de usuarios y crear las filas
                usuarios.data.forEach(usuario => {
                    // Crear una fila para cada usuario
                    const row = document.createElement('tr');
    
                    // Crear la celda del nombre del usuario
                    const nombreCell = document.createElement('td');
                    nombreCell.textContent = usuario.nombre; // Ajusta esto según la estructura de tu API
    
                    // Crear la celda del checkbox
                    const checkboxCell = document.createElement('td');
                    const checkbox = document.createElement('input');
                    checkbox.type = 'radio'; // Cambiar a 'radio'
                    checkbox.name = 'usuario'; // Usar el mismo nombre para agrupar
                    checkbox.value = usuario.id; // Valor del checkbox es el ID del usuario
                    checkbox.id = `usuario-${usuario.id}`;
                    checkbox.addEventListener('change', () => {
                        if (checkbox.checked) {
                            console.log(`Usuario seleccionado: ID ${usuario.id}, Nombre: ${usuario.nombre}`);
                        }
                    });
                    checkboxCell.appendChild(checkbox);
    
                    // Agregar las celdas a la fila
                    row.appendChild(nombreCell);
                    row.appendChild(checkboxCell);
    
                    // Agregar la fila al cuerpo de la tabla
                    tbody.appendChild(row);
                });
            } else {
                console.error('Error al obtener usuarios:', usuarios.error); // Cambié data por usuarios
            }
        } catch (error) {
            console.error('Error de red:', error);
        }
    }
    
    
    
    async addPedido() {
        console.log("Crear producto.");
        
        // URL para la creación de productos en la API
        const fullURL = `?controller=api&action=createPedidos`;
        
        // Crear el formulario de creación
        const content = `
            <div class="col-12 col-sm-6 col-md-6 col-lg-9 mt-0">
                <div class="card h-100 w-100">
                    <div class="card-body">
                        <form id="formulario-creacion-pedido" action="${fullURL}" method="POST">
                            <h3>Crear Pedido</h3>
                            <label>ID Usuario:</label>
                            <table id="usuarios-table" class="usuarios-table">
                                <thead>
                                    <tr>
                                        <th>Nombre de usuario</th>
                                        <th>Seleccionar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Las filas de usuarios serán agregadas dinámicamente aquí -->
                                </tbody>
                            </table>
                            <table id="productos-table" class="productos-table">
                                <thead>
                                    <tr>
                                        <th>Nombre del producto</th>
                                        <th>Cantidad</th>
                                        <th>Seleccionar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Las filas de productos serán agregadas dinámicamente aquí -->
                                </tbody>
                            </table>
                            <input type="hidden" id="id_usuario" name="id_usuario" value="" />
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
        const listaPedidos = document.getElementById("listaPedidos");
        if (listaPedidos) {
            listaPedidos.innerHTML = content;
        } else {
            console.error("No se encontró el elemento con id 'listaPedidos'.");
        }
        await this.cargarUsuarios();
        await this.cargarProductos();
    
        // Gestionar los datos, enviarlos sin recargar la página
        document.getElementById("formulario-creacion-pedido").addEventListener("submit", async function (event) {
            event.preventDefault(); // Evitar envío normal
            
            // Obtener el ID del usuario seleccionado
            const usuarioSeleccionado = document.querySelector('input[type="radio"]:checked');
            const id_usuario = usuarioSeleccionado ? usuarioSeleccionado.value : null;
    
            // Validar selección de usuario
            if (!id_usuario) {
                alert('Por favor, selecciona un usuario.');
                return;
            }
    
            const array_productos = {};
    
            // Obtener todas las filas de productos
            const productosTable = document.getElementById('productos-table');
            const filasProductos = productosTable.querySelectorAll('tbody tr');
    
            // Iterar sobre las filas de productos y verificar si están seleccionadas
            filasProductos.forEach((fila) => {
                const checkbox = fila.querySelector('input[type="checkbox"]');
                const cantidadInput = fila.querySelector('.producto-cantidad');
    
                // Verificar si el checkbox está marcado y si la cantidad es válida
                if (checkbox && checkbox.checked && cantidadInput && cantidadInput.value > 0) {
                    const productoId = checkbox.value;
                    array_productos[productoId] = cantidadInput.value; // Agregar ID y cantidad al objeto
                    console.log(`Producto ${productoId} agregado con cantidad ${cantidadInput.value}`);
                }
            });
    
            // Validación de productos seleccionados
            if (Object.keys(array_productos).length === 0) {
                alert('Por favor, selecciona al menos un producto y establece la cantidad.');
                return;
            }
    
            // Crear el objeto de datos para enviar
            const datosPedido = {
                id_usuario: id_usuario,
                productos: array_productos
            };
    
            const response = await fetch('?controller=api&action=createPedido', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(datosPedido)
            });
    
            const data = await response.json();
            console.log('Respuesta de la API:', data);
    
            if (data.estado === 'Exito') {
                alert(data.mensaje);
                window.location.href = "?controller=admin&action=pedidosConfig&funcion=get"; // Redirigir a la página del carrito
            } else {
                alert("Error: " + data.mensaje);
            }
        });
    
        // Cancelar petición
        document.getElementById("cancelCreate").addEventListener("click", () => {
            window.location.href = "?controller=admin&action=pedidosConfig&funcion=get";
        });
    }
    
    
    async cargarProductosSelect() {
        const obtenerProductoUrl = '?controller=api&action=getProductos';
    
        try {
            // Realizar la solicitud a la API
            const response = await fetch(obtenerProductoUrl);
            const productos = await response.json();
    
            // Verificar si la respuesta fue exitosa
            if (productos.estado === 'Exito') {
                const selectProducto = document.querySelector('#nuevoProducto'); // Seleccionar el <select>
    
                if (!selectProducto) {
                    console.error('Elemento con ID #nuevoProducto no encontrado.');
                    return;
                }
    
                // Limpiar el select antes de agregar los productos
                selectProducto.innerHTML = '<option value="" disabled selected>Selecciona un producto</option>';
    
                // Agregar cada producto como una opción del select
                productos.data.forEach(producto => {
                    const option = document.createElement('option');
                    option.value = producto.id; // El ID del producto
                    option.textContent = producto.nombre; // El nombre del producto
                    selectProducto.appendChild(option); // Añadir la opción al select
                });
    
                console.log('Productos cargados correctamente en el select.');
            } else {
                console.error('Error al obtener productos:', data.error);
            }
        } catch (error) {
            console.error('Error en la solicitud a la API:', error);
        }
    }
    
    

    async modifyPedido(userId, productoId, pedidoId) {
        console.log(`Modificar pedido con ID: ${pedidoId}`);
    
        if (!pedidoId) {
            console.error("No se encontró el pedidoId.");
            alert("Pedido no encontrado.");
            return;
        } else {
            // alert("Pedido encontrado: " + pedidoId);
        }
    
        const modificarPedido = `?controller=api&action=modifyPedido`;
        const modificarCantidadProducto = `?controller=api&action=modifyCantidadProducto`;
        const agregarProducto = `?controller=api&action=addProductoPedido`;
        const eliminarProducto = `?controller=api&action=removeProductoPedido`;

        // Obtener pedido
        const obtenerPedidoUrl = `?controller=api&action=getPedidos&id=${pedidoId}`;
        const respuestaPedido = await fetch(obtenerPedidoUrl);
        const pedidoUsuario = await respuestaPedido.json();
    
        if (!pedidoUsuario || pedidoUsuario.estado !== 'Exito') {
            console.error("No se encontró el pedido.");
            alert("No se encontró el pedido.");
            
        }
    
        const productosDisponibles = pedidoUsuario.data.productos; // IDs de productos asociados al pedido
        const datosProductosDisponibles = [];
    
        // Obtener los datos de cada producto utilizando su ID
        for (const productoId of productosDisponibles) {
            const obtenerProductoUrl = `?controller=api&action=getProductos&id=${productoId}`;
            const respuestaProducto = await fetch(obtenerProductoUrl);
            const producto = await respuestaProducto.json();
    
            if (producto.estado === 'Exito') {
                datosProductosDisponibles.push(producto.data); // Almacena la información detallada del producto
            } else {
                console.error(`No se encontró el producto con ID: ${productoId}`);
            }
        }
    
        // Crear el formulario para modificar el pedido
        let content = `
            <div class="col-12 col-sm-6 col-md-6 col-lg-9 mt-0 mb-5">
                <div class="card h-100 w-100">
                    <div class="card-body">
                        <form id="formulario-modificar-pedido" action="${modificarPedido}">
                            <h3 class="mb-3">Modificar Pedido (${pedidoUsuario.data.id_pedido})</h3>
                            <div class="mb-3">
                                <label for="id_usuario" class="form-label">ID Usuario:</label>
                                <input type="text" class="form-control" id="id_usuario" name="id_usuario" placeholder="${pedidoUsuario.data.id_usuario}">
                            </div>

                            <div class="mb-3">
                                <label for="fecha" class="form-label">Fecha:</label>
                                <input type="date" class="form-control" id="fecha" name="fecha" placeholder="${pedidoUsuario.data.fecha}">
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                                <button type="button" id="cancelModify" class="btn btn-secondary">Cancelar</button>
                            </div>
                        </form>

                        <h4 class="mt-4">Productos</h4>
                        <table id="productos-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody id="productos-table-body">
                            </tbody>
                        </table>
                        <form id="formulario-agregar-producto" method="POST">
                            <h4 class="mt-4">Agregar Nuevos Productos</h4>
                            <div class="input-group mb-3">
                                <select id="nuevoProducto" class="form-select w-50">
                                    <option value="" disabled selected>Selecciona un producto</option>
                                </select>
                                <input type="number" id="cantidadNuevoProducto" class="form-control w-50" placeholder="Cantidad" min="1">
                                <button type="submit" class="neutralButton-white"">Agregar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        `;
    
        document.getElementById("listaPedidos").innerHTML = content;
    
        await this.cargarProductosSelect(); // Cargar productos en el select
    
        // Llenar la tabla de productos con los detalles obtenidos
        const productosTableBody = document.getElementById("productos-table-body");
    
        // Recorremos los productos disponibles y los mostramos en la tabla
        for (const producto of datosProductosDisponibles) {
            const row = document.createElement("tr");
    
            // Obtener cantidad del producto en el pedido
            const parametros = {
                id_producto: producto.id,
                id_pedido: pedidoUsuario.data.id_pedido,
            };
    
            // Hacer la petición POST para obtener la cantidad del producto
            const respuestaCantidadProducto = await fetch('?controller=api&action=getDetallePedido', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(parametros), // Enviar los parámetros como JSON
            });
    
            const cantidadProductoDetalle = await respuestaCantidadProducto.json();
    
            if (cantidadProductoDetalle.estado !== 'Exito') {
                console.error(`No se pudo obtener la cantidad para el producto ID ${producto.id}`);
                return;
            }
            // Crear las celdas de la fila con los datos del producto
            // Dentro de tu bucle donde generas las filas
            // Añadir fila a la tabla
            row.innerHTML = `
                <td>${producto.id}</td>
                <td>${producto.nombre}</td>
                <td>${producto.descripcion}</td>
                <td>
                    <form id="formulario-modificar-cantidad-${producto.id}" action="" method="POST">
                        <input type="number" name="cantidad" class="form-control" value="${cantidadProductoDetalle.data.cantidad}" min="0">
                        <button type="submit" class="neutralButton-white modificarCantidadProductoPedido">Modificar</button>
                    </form>
                </td>
                <td>${producto.precio}€</td>
                <td><button class="btn btn-danger btn-sm eliminarProductoPedido">Eliminar</button></td>
            `;

            // Añadir la fila al cuerpo de la tabla
            productosTableBody.appendChild(row);

            // Eliminar producto del pedido
            const botonesEliminar = document.querySelectorAll(".eliminarProductoPedido");

            for (let botonEliminar of botonesEliminar) {
            botonEliminar.addEventListener("click", async function (event) {
                const datosProductoPedido = {
                    id_pedido: pedidoId,
                    id_producto: producto.id,
                };

                console.log(datosProductoPedido);
                
                const respuesta = await fetch(eliminarProducto, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(datosProductoPedido)
                });
                
                const datosRespuesta = await respuesta.json();
                if (datosRespuesta.estado === 'Exito') {
                    alert(datosRespuesta.mensaje);
                    location.reload();
                } else {
                    alert("Error: " + datosRespuesta.mensaje);
                }
            });
            }

            // Modificar cantidad del producto - escanea los formularios
            const formulario = document.getElementById(`formulario-modificar-cantidad-${producto.id}`); // Selecciona el formulario específico

            formulario.addEventListener("submit", async function (event) {
            event.preventDefault(); // Evita el comportamiento por defecto del formulario

            // Obtener la cantidad desde el input del formulario
            const cantidad = parseInt(formulario.cantidad.value); // Usa el formulario específico para obtener la cantidad
            const id_producto = producto.id; // Asegúrate de usar el ID correcto

            const datosProductoPedido = {
                id_producto: id_producto,
                cantidad: cantidad // Envía también la cantidad
            };

            console.log(datosProductoPedido);

            const respuesta = await fetch(modificarCantidadProducto, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(datosProductoPedido)
            });

            const datosRespuesta = await respuesta.json();
            if (datosRespuesta.estado === 'Exito') {
                alert(datosRespuesta.mensaje);
                location.reload();
            } else {
                alert("Error: " + datosRespuesta.mensaje);
            }
            });
        }
    
    
        // Manejo del envío del formulario
        document.getElementById("formulario-modificar-pedido").addEventListener("submit", async function (event) {
            event.preventDefault();
            
            // Obtener valores del formulario con validación
            const datosPedido = {};

            if (pedidoUsuario.data.id_pedido) {
                datosPedido.id_pedido = parseInt(pedidoUsuario.data.id_pedido); // Siempre incluye el ID del pedido
            }

            if (event.target.id_usuario.value.trim() !== "") {
                datosPedido.id_usuario = parseInt(event.target.id_usuario.value);
            }

            if (event.target.fecha.value.trim() !== "") {
                datosPedido.fecha = event.target.fecha.value;
            }


            // Si no hay datos válidos, muestra un error
            if (Object.keys(datosPedido).length <= 1) { // Solo tiene `id_pedido` por defecto
                alert("Por favor, completa al menos un campo para modificar.");
                return;
            }
            console.log(datosPedido);
        
            // Realizar la solicitud POST al servidor para modificar el pedido
            const respuesta = await fetch(modificarPedido, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(datosPedido)
            });
        
            // Procesar la respuesta del servidor
            const datosRespuesta = await respuesta.json();
            if (datosRespuesta.estado === 'Exito') {
                alert(datosRespuesta.mensaje);
                location.reload();
            } else {
                alert("Error: " + datosRespuesta.mensaje);
            }
        });
        
        
        document.getElementById("formulario-agregar-producto").addEventListener("submit", async function (event) {
            event.preventDefault();

            const datosProducto = {
                pedido: pedidoId,
                producto: event.target.nuevoProducto.value,
                cantidad: event.target.cantidadNuevoProducto.value,
            };
            
            console.log(datosProducto);
            const respuesta = await fetch(agregarProducto, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(datosProducto)
            });
    
            const datosRespuesta = await respuesta.json();
            if (datosRespuesta.estado === 'Exito') {
                alert(datosRespuesta.mensaje);
                location.reload();
            } else {
                alert("Error: " + datosRespuesta.mensaje);
            }
        });
        // Cancelar modificación
        document.getElementById("cancelModify").addEventListener("click", () => {
            window.location.href = "?controller=admin&action=pedidosConfig&funcion=get";
        });
    }
    
    async erasePedido(userId, pedidoId) {
        try {
            const confirmDelete = confirm("¿Estás seguro de que deseas eliminar este pedido?");
            if (!confirmDelete) return;
    
            const fullURL = `?controller=api&action=erasePedidos&id_usuario=${userId}&id_pedido=${pedidoId}`;
            const respuesta = await fetch(fullURL);
    
            if (!respuesta.ok) {
                throw new Error(`Error HTTP: ${respuesta.status}`);
            }
    
            const resultado = await respuesta.json();
    
            if (resultado.estado === "Exito") {
                alert(resultado.mensaje);
                // Redirigir a los pedidos del usuario
                window.location.href = `?controller=admin&action=pedidosConfig&funcion=get`;
            } else {
                alert("Error: " + resultado.mensaje);
            }
        } catch (error) {
            alert(`Ocurrió un error: ${error.message}`);
            console.error(error);
        }
    }
    
    
    // Método estático para inicializar la clase
    static init() {
        const pedido = new Pedido();
        document.addEventListener("DOMContentLoaded", async function () {
            // Obtener parámetros de la URL
            const urlParams = new URLSearchParams(window.location.search);
            const funcion = urlParams.get("funcion");

            if (funcion === "get") {
                pedido.getPedidos();
            } else if (funcion === "create") {
                pedido.addPedido();
            } else if (funcion === "modify") {
                const userId = urlParams.get("userId");
                const pedidoId = urlParams.get("pedidoId");
                const especifico = urlParams.get("especifico");
            
                if (especifico === "removeProductoPedido") {
                    // Manejo específico para eliminar producto del pedido
                    const productoId = urlParams.get("productoId");
            
                    if (productoId) {
                        await pedido.erasePedido(null, pedidoId, productoId); // Eliminar solo un producto del pedido
                    } else {
                        console.error("Faltan parámetros para eliminar producto del pedido.");
                    }
                } else {
                    // Modificación general del pedido
                    pedido.modifyPedido(userId, null, pedidoId); // Aquí no se pasa productoId
                }
            } else if (funcion === "erase") {
                const userId = urlParams.get("userId");
                const pedidoId = urlParams.get("pedidoId");
                pedido.erasePedido(userId,pedidoId);
            } else {
                console.warn("No se ha encontrado una función válida en la URL.");
            }
        });
    }
}

// Inicializar la clase al cargar el DOM
Pedido.init();
