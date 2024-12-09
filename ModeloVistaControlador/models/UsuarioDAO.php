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
                "apellidos" => $usuario->getApellidos(),
                "direccion" => $usuario->getDireccion(),
                "rol" =>  $usuario->getRol()
            ];
            $_SESSION['confirmacion'] = "Inicio de sesión exitoso. Serás redirigido en breve.";
            self::agregarLog($_SESSION["usuario"]["correo"],$_SESSION["usuario"]["nombre"] . " " . $_SESSION["usuario"]["apellidos"] . " ha iniciado sesión.");
        }else {
            // La contraseña no existe
            $_SESSION['error'] = "La contraseña es incorrecta, pruebe de nuevo.";
            self::agregarLog($usuario->getCorreo(), $usuario->getNombre() . " " . $usuario->getApellidos() . " ha intentado iniciar sesión");
        }
        $view="views/login/Login.php";
        include_once 'views/main.php';
    } else {
        // El correo no existe
        $_SESSION['error'] = "No hay ninguna cuenta asociada con este correo.";
        $view="views/login/Login.php";
        include_once 'views/main.php';
    }
    $con->close();
}

public static function registroSesion($nombre, $apellidos, $correo, $password){
    // Validar que la contraseña tenga 8 caracteres o más
    if (strlen($password) < 8) {
        $_SESSION['error'] = "La contraseña no puede tener menos de 8 caracteres.";
        $view = "views/login/Register.php";
        include_once 'views/main.php';
        return;
    }
    
    // Validar que la contraseña no tenga más de 18 caracteres
    if (strlen($password) > 18) {
        $_SESSION['error'] = "La contraseña no puede tener más de 18 caracteres.";
        $view = "views/login/Register.php";
        include_once 'views/main.php';
        return;
    }

    //  Pasar todo a minusculas en el caso que sea todo mayusculas
    if ($nombre === strtoupper($nombre)) {
        $nombre = ucfirst(strtolower($nombre)); // Convierte a minúsculas y luego la primera letra a mayúscula
    }
    if ($apellidos === strtoupper($apellidos)) {
        $apellidos = ucfirst(strtolower($apellidos)); // Lo mismo para apellidos
    }
    if ($correo === strtoupper($correo)) {
        $correo = ucfirst(strtolower($correo));
    }

    // Conexión a la base de datos
    $con = DataBase::connect();

    // Verificar que el correo no exista en la base de datos
    $stmt = $con->prepare("SELECT * FROM usuario WHERE correo=?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_object("UsuarioDetalle");

    // Si ya existe un usuario con el mismo correo, mostramos el error
    if ($usuario) {
        $_SESSION['error'] = "Ya existe una cuenta con este correo asociado.";
        $view = "views/login/Register.php";
        include_once 'views/main.php';
        return;
    }

    // Si no existe, procedemos a insertar el nuevo usuario
    $passwordEncriptado = password_hash($password, PASSWORD_DEFAULT);

    // Insertamos los datos en la base de datos
    $stmt2 = $con->prepare("INSERT INTO usuario (nombre, apellidos, correo, contraseña, rol) VALUES (?, ?, ?, ?, 'Cliente')");
    $stmt2->bind_param("ssss", $nombre, $apellidos, $correo, $passwordEncriptado);

    // Si la ejecución es exitosa, mostramos el mensaje de confirmación
    if ($stmt2->execute()) {
        $_SESSION['confirmacion'] = "Registro de sesión exitoso. Serás redirigido en breve.";
        self::agregarLog($correo, $nombre . " " . $apellidos . " se ha registrado");
        $view = "views/login/Register.php";
        include_once 'views/main.php';
    } else {
        // Si hay un error en la base de datos
        $_SESSION['error'] = "Ha habido un error en el servidor. Intenta de nuevo.";
        $view = "views/login/Register.php";
        include_once 'views/main.php';
    }

    // Cerrar la conexión
    $con->close();
}

public static function agregarLog($correo,$mensaje) {
    $correo_usuario = $correo ?? null;
    $mensaje_usuario = $mensaje ?? null;

    // Conexión a la base de datos
    $con = DataBase::connect();
    $stmt = $con->prepare("INSERT INTO log (correo, mensaje) VALUES (?, ?)");
    $stmt->bind_param("ss", $correo_usuario, $mensaje_usuario);
    $stmt->execute();
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
                            $_SESSION['confirmacion'] = "Pedido tramitado correctamente, gracias por contar con nosotros, para comprar tu comida!";
                        } else {
                            $_SESSION['error'] = "Error al insertar el detalle del pedido, contacta con un administrador";
                        }
                    } else {
                        echo "Error: El ID del pedido es nulo, no se puede insertar el detalle del pedido.<br>";
                    }
                }
                self::agregarLog($_SESSION["usuario"]["correo"],$_SESSION["usuario"]["nombre"] . " " . $_SESSION["usuario"]["apellidos"] . " ha tramitado un pedido.");
            }

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
        $_SESSION['error'] = "Este nombre de usuario ya lo tienes asignado. <br> Prueba de nuevo.";
    } else {
        $stmt1 = $con->prepare("UPDATE usuario SET nombre = ? WHERE id_usuario = ?;");
        $stmt1->bind_param("si",$nombre,$id);
        $stmt1->execute();
        $_SESSION['usuario']['nombre'] = $nombre;
        $_SESSION['confirmacion']= "El nombre se ha modificado correctamente.";
        self::agregarLog($_SESSION["usuario"]["correo"],$_SESSION["usuario"]["nombre"] . " " . $_SESSION["usuario"]["apellidos"] . " ha modificado su nombre de usuario.");
    }

    // Redirigir a nuestro perfil (confirmacion)
    header("Location: ?controller=user");
    exit();
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
        $_SESSION['error'] = "Esta contraseña ya la tienes asignada. <br> Prueba de nuevo.";
    } else {
        $passwordEncriptado = password_hash($contraseña, PASSWORD_BCRYPT);
        $stmt1 = $con->prepare("UPDATE usuario SET contraseña = ? WHERE id_usuario = ?;");
        $stmt1->bind_param("si",$passwordEncriptado,$id);
        $stmt1->execute();
        $_SESSION['confirmacion'] = "La contraseña se ha modificado correctamente.";
        self::agregarLog($_SESSION["usuario"]["correo"],$_SESSION["usuario"]["nombre"] . " " . $_SESSION["usuario"]["apellidos"] . " ha modificado su contraseña.");
    }
    // Redirigir a nuestro perfil (confirmacion)
    header("Location: ?controller=user");
    exit();

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
        $_SESSION['error'] = "Esta direccion ya la tienes asignada. <br> Prueba de nuevo.";
    } else {
        $stmt1 = $con->prepare("UPDATE usuario SET direccion = ? WHERE id_usuario = ?;");
        $stmt1->bind_param("si",$direccion,$id);
        $stmt1->execute();
        $_SESSION['usuario']['direccion'] = $direccion;
        $_SESSION['confirmacion'] = "La direccion se ha modificado correctamente.";
        self::agregarLog($_SESSION["usuario"]["correo"],$_SESSION["usuario"]["nombre"] . " " . $_SESSION["usuario"]["apellidos"] . " ha modificado la direccion de entrega.");
    }
    // Redirigir a nuestro perfil (confirmacion)
    header("Location: ?controller=user");
    exit();

    $con->close();
}

public static function cerrarSesion() {
    // Iniciar la sesión
    session_start();
    if($_SESSION["usuario"]["rol"] === "Admin") {
        header("Location: ?controller=user");
    } else {
        header("Location: ?controller=producto");
    }
    self::agregarLog($_SESSION["usuario"]["correo"],$_SESSION["usuario"]["nombre"] . " " . $_SESSION["usuario"]["apellidos"] . " ha cerrado sesion.");
    unset($_SESSION['usuario']);
    exit();
}

}

?>