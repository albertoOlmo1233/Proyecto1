<?php 
include_once("models/Producto.php");
include_once("models/ProductoDetalle.php");
include_once("models/Usuario.php");
include_once("config/dataBase.php");
include_once("models/UsuarioDetalle.php");

class UsuarioDAO {
    public static function getAll(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM usuario");

        $stmt->execute();
        $result = $stmt->get_result();

        $usuarios = [];

        while($producto = $result->fetch_object("UsuarioDetalle")) {
            $usuarios [] = $usuario;
        }

        $con->close();

        return $usuarios ;
    }

    public static function getUsuario($correo){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM usuario WHERE correo = ?");
        $stmt->bind_param("s",$correo);

        $stmt->execute();
        $result = $stmt->get_result();

        $detalleUsuario = null;

        while($usuario = $result->fetch_object("UsuarioDetalle")) {
            $detalleUsuario = $usuario;
        }

        $con->close();

        return $detalleUsuario;
    }


    public static function store($usuario){
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO usuarios (nombre, apellidos, correo, contraseña, rol) VALUES (?,?,?,?,?);");
        $stmt->bind_param("sssss",$usuario->getNombre(),$usuario->getApellido(),$usuario->getCorreo(),$usuario->getContraseña,"Cliente");
        
        $stmt->execute();
        $con->close();
    }
// Iniciar sesion
public static function iniciarSesion($identificador,$contraseña){
    
    $con = DataBase::connect();
    $stmt = $con->prepare("SELECT * FROM usuario WHERE correo=?");
    $stmt->bind_param("s",$identificador);
    $stmt->execute();

    // Obtenemo el resultado de la query
    $result = $stmt->get_result();
    $usuario = $result->fetch_object("UsuarioDetalle");

    if($usuario){
        if (password_verify($contraseña, $usuario->getContraseña())) {
            // Iniciamos la sesión
            session_start();

            // Guardamos el ID y el nombre del usuario en la sesión
            $_SESSION["usuario"] = [
                "id" => $usuario->getID(),
                "correo" => $usuario->getCorreo(),
                "nombre" => $usuario->getNombre(),
                "direccion" => $usuario->getDireccion(),
                "rol" =>  $usuario->getRol()
            ];
            error_log(print_r($_SESSION["usuario"], true)); 
            echo '<pre>';
            print_r($_SESSION['usuario']);
            echo '</pre>';
            $confirmacion = "Inicio de sesión exitoso. Serás redirigido en breve.";
        }else {
            // La contraseña no existe
            $error = "La contraseña es incorrecta, pruebe de nuevo.";
        }
    } else {
        // El correo no existe
        $error = "No hay ninguna cuenta asociada con este correo.";
    }
    if(isset($error)) {
        $view = "views/login/Login.php";
        include_once 'views/main.php';
    }
    if(isset($confirmacion)){
        $view = "views/login/Login.php";
        include_once 'views/main.php';
    }
    $con->close();
}

   // Registrar usuario
public static function registroSesion($nombre, $apellidos, $correo, $password){
    // Validar que la contraseña tenga 8 caracteres o más
    if (strlen($password) < 8) {
        $error = "La contraseña no puede tener menos de 8 caracteres.";
    }
    // Validar que la contraseña no tenga más de 18 caracteres
    if (strlen($password) > 18) {
        $error = "La contraseña no puede tener más de 18 caracteres.";
    }

    // Verificar que no haya error en la contraseña
    if (!isset($error)) {
        $con = DataBase::connect();

        // Verificamos que el correo no exista en la base de datos
        $stmt = $con->prepare("SELECT * FROM usuario WHERE correo=?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_object("UsuarioDetalle");

        // Si ya existe un usuario con el mismo correo, mostramos el error
        if ($usuario) {
            $error = "Ya existe una cuenta con este correo asociado.";
        } else {
            //  Verificamos si el nombre y apellidos ya están registrados
            $stmt1 = $con->prepare("SELECT * FROM usuario WHERE nombre=? AND apellidos=?");
            $stmt1->bind_param("ss", $nombre, $apellidos);
            $stmt1->execute();
            $result1 = $stmt1->get_result();
            $usuarioExistente = $result1->fetch_object("UsuarioDetalle");

            // Si ya existe un usuario con el mismo nombre y apellidos, mostramos el error
            if ($usuarioExistente) {
                $error = "Ya existe una cuenta con este nombre y apellidos.";
            }
        }

        // Si no hubo error, encriptamos la contraseña y guardamos el nuevo usuario
        if (!isset($error)) {
            $passwordEncriptado = password_hash($password, PASSWORD_BCRYPT);

            // Insertamos los datos en la base de datos
            $stmt2 = $con->prepare("INSERT INTO usuario (nombre, apellidos, correo, contraseña, rol) VALUES (?, ?, ?, ?, 'Cliente')");
            $stmt2->bind_param("ssss", $nombre, $apellidos, $correo, $passwordEncriptado);

            // Si la ejecución es exitosa, redirigimos a la página de login
            if ($stmt2->execute()) {
                $confirmacion = "Registro de sesion exitoso. Serás redirigido en breve.";
                $view = "views/login/Login.php";
                include_once 'views/main.php';
            } else {
                echo "Ha habido un error en el servidor";
                return;
            }
        }
    }

    // Si hay un error, mostramos el mensaje
    if (isset($error)) {
        $view = "views/login/Register.php";
        include_once "views/main.php";
    }
    if(isset($confirmacion)){
        $view = "views/login/Login.php";
        include_once 'views/main.php';
    }
    

    $con->close();
}
    

public static function comprobarSesion(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if(!isset($_SESSION["usuario"])){
        header("Location: ?controller=user");
    }
    
}

public static function tramitar_pedido($totalPedido) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();  // Inicia la sesión si no está iniciada
    }

    // Verificar que el usuario está logueado
    if (isset($_SESSION['usuario']['id'])) {
        $id_usuario = $_SESSION['usuario']['id'];
        if (empty($_SESSION['usuario']['direccion'])) {
            $_SESSION['error'] = "Necesitas configurar una direccion a la que enviar tu pedido.";
            header("Location: ?controller=user&action=carrito");
            exit();
        }else {
            // Crear la conexión con la base de datos
            $con = DataBase::connect();

            // Definir la fecha actual
            $fecha = date("Y-m-d H:i:s");

            // Insertar pedido en la base de datos
            $stmt_pedido = $con->prepare("INSERT INTO pedido (Fecha, id_usuario, total_pedido) VALUES (?,?,?)");
            $stmt_pedido->bind_param("sid", $fecha, $id_usuario, $totalPedido);

            // Verificar si la inserción del pedido fue exitosa
            if ($stmt_pedido->execute()) {
                // Obtener el ID del pedido recién insertado
                $id_pedido = $con->insert_id;

                // Verificar si se obtuvo el ID del pedido correctamente
                if ($id_pedido) {
                    echo "Pedido agregado con ID: " . $id_pedido;
                } else {
                    echo "Error: No se obtuvo un ID válido del pedido.";
                    $con->close();
                    return; // Detener la ejecución si no se obtuvo el ID
                }
            } else {
                echo "Error al insertar el pedido: " . $stmt_pedido->error;
                $con->close();
                return; // Detener la ejecución si hay un error al insertar el pedido
            }

            // Verificar si el carrito del usuario tiene productos
            if (isset($_SESSION['carrito'][$id_usuario]) && !empty($_SESSION['carrito'][$id_usuario])) {
                // Insertar los detalles del pedido
                foreach ($_SESSION['carrito'][$id_usuario] as $id_producto => $pedido) {
                    $producto = $pedido['producto'];
                    $id_producto = $producto->getID();
                    $cantidad = $pedido['cantidad'];

                    // Asegurarse de que $id_pedido sea válido antes de insertar en detalle_producto
                    if ($id_pedido) {
                        // Preparar la consulta para insertar el detalle del producto
                        $stmt_detalleProducto = $con->prepare("INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad) VALUES (?, ?, ?)");
                        $stmt_detalleProducto->bind_param("iid", $id_pedido, $id_producto, $cantidad);

                        // Ejecutar la inserción de los detalles del producto
                        if ($stmt_detalleProducto->execute()) {
                            echo "Detalle del pedido agregado correctamente para el producto ID: " . $id_producto . "<br>";
                        } else {
                            echo "Error al insertar el detalle del pedido: " . $stmt_detalleProducto->error . "<br>";
                        }
                    } else {
                        echo "Error: El ID del pedido es nulo, no se puede insertar el detalle del pedido.<br>";
                    }
                }
            }

            // Confirmación de compra
            $_SESSION['confirmacion'] = "Pedido tramitado correctamente, recoge el pedido en X días.";
            unset($_SESSION['carrito'][$id_usuario]);
            // Redirigir a la página que muestra la confirmación de compra (confirmacion)
            header("Location: ?controller=user&action=carrito");
            exit();
            // Cerrar la conexión
            $con->close();
        }

    } else {
        echo "No hay datos de usuario en la sesión.";
    }
}

public static function modificarNombre($id,$nombre){
    // Asegúrate de que la sesión esté iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();  // Inicia la sesión si no está iniciada
    }
    $con = DataBase::connect();
    $stmt = $con->prepare("SELECT nombre FROM usuario WHERE id_usuario=?;");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $resultNombre = $stmt->get_result();
    $row = $resultNombre->fetch_array();
    $nombre_resultado = $row['nombre'];

    if($nombre_resultado && $nombre_resultado === $nombre) {
        $error = "Este nombre de usuario ya lo tienes asignada. <br> Prueba de nuevo.";
    } else {
        $stmt1 = $con->prepare("UPDATE usuario SET nombre = ? WHERE id_usuario = ?;");
        $stmt1->bind_param("si",$nombre,$id);
        $stmt1->execute();
        $_SESSION['usuario']['nombre'] = $nombre;
        $confirmacion = "El nombre se ha modificado correctamente.";
    }

    if(isset($error)) {
        $view = "views/cuenta/Cuenta.php";
        include_once 'views/main.php';
    }
    if(isset($confirmacion)){
        $view = "views/cuenta/Cuenta.php";
        include_once 'views/main.php';
    }
    $con->close();
}
public static function modificarContraseña($id,$contraseña){
    // Asegúrate de que la sesión esté iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();  // Inicia la sesión si no está iniciada
    }
    $con = DataBase::connect();
    $stmt = $con->prepare("SELECT contraseña FROM usuario WHERE id_usuario=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $resultContraseña = $stmt->get_result();
    $row = $resultContraseña->fetch_array();
    $contraseña_resultado = $row['contraseña'];

    if($contraseña_resultado && $contraseña_resultado === $contraseña) {
        $error = "Esta contraseña ya la tienes asignada. <br> Prueba de nuevo.";
    } else {
        $passwordEncriptado = password_hash($contraseña, PASSWORD_BCRYPT);
        $stmt1 = $con->prepare("UPDATE usuario SET contraseña = ? WHERE id_usuario = ?;");
        $stmt1->bind_param("si",$passwordEncriptado,$id);
        $stmt1->execute();
        $confirmacion = "La contraseña se ha modificado correctamente.";
    }

    if(isset($error)) {
        $view = "views/cuenta/Cuenta.php";
        include_once 'views/main.php';
    }
    if(isset($confirmacion)){
        $view = "views/cuenta/Cuenta.php";
        include_once 'views/main.php';
    }
    $con->close();
}
public static function modificarDireccion($id,$direccion){
    // Asegúrate de que la sesión esté iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();  // Inicia la sesión si no está iniciada
    }
    $con = DataBase::connect();
    $stmt = $con->prepare("SELECT direccion FROM usuario WHERE id_usuario=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $resultDireccion = $stmt->get_result();
    $row = $resultDireccion->fetch_array();
    $direccion_resultado = $row['direccion'];

    if($direccion_resultado && $direccion_resultado === $direccion) {
        $error = "Esta direccion ya la tienes asignada. <br> Prueba de nuevo.";
    } else {
        $stmt1 = $con->prepare("UPDATE usuario SET direccion = ? WHERE id_usuario = ?;");
        $stmt1->bind_param("si",$direccion,$id);
        $stmt1->execute();
        $_SESSION['usuario']['direccion'] = $direccion;
        $confirmacion = "La direccion se ha modificado correctamente.";
    }

    if(isset($error)) {
        $view = "views/cuenta/Cuenta.php";
        include_once 'views/main.php';
    }
    if(isset($confirmacion)){
        $view = "views/cuenta/Cuenta.php";
        include_once 'views/main.php';
    }
    $con->close();
}

public static function cerrarSesion() {
    // Iniciar la sesión
    session_start();

    // Eliminar todas las variables de sesión
    // session_unset();
    // Destruir la sesión
    // session_destroy();


    if($_SESSION["usuario"]["rol"] === "Admin") {
        header("Location: ?controller=user");
    } else {
        header("Location: ?controller=producto");
    }
    unset($_SESSION['usuario']);
    exit();
}


public static function destroy($id){
    $con = DataBase::connect();
    $stmt = $con->prepare("DELETE FROM camisetas WHERE ID =?");
    // Le pasamos un argumento numero entero, por lo tanto el bind_param sera 'i' de Integer
    $stmt->bind_param("i",$id);
    
    $stmt->execute();
    $con->close();
}
}

?>