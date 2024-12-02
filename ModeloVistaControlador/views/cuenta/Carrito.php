<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once("views/header/header.php");
?>
<div class="container-fluid p-0">
    <div class="row">
        <div class="col-sm-12 p-0">
            <div id="seccion-titulo-carrito">
                <h1 class="m-0">Carrito</h1>
            </div>
        </div>
        <div id="seccion-productos-carrito" class="col-sm-12 col-md-10 col-lg-8 mx-auto p-0">
        <?php
            $id_usuario = $_SESSION['usuario']['id'] ?? null;

            // Comprobamos si el carrito existe y contiene productos para este usuario
            if ($id_usuario && isset($_SESSION['carrito'][$id_usuario]) && !empty($_SESSION['carrito'][$id_usuario])) {
                $total = 0; // Para calcular el total del carrito

                foreach ($_SESSION['carrito'][$id_usuario] as $id_producto => $productoPedido) {
                    $producto = $productoPedido['producto'];
                    $cantidad = $productoPedido['cantidad'];
                    $total += $producto->getPrecio() * $cantidad;
        ?>
                <div class="row plantilla-pedido py-5" id="pedido-<?=$producto->getID();?>">
                    <div class="col-10">
                        <div class="contenido-producto d-flex ps-5">
                            <img src="<?=$producto->getImagen();?>" alt="<?=$producto->getNombre();?>">
                            <div class="contenido-texto-producto d-flex flex-column">
                                <p class="h2 p"><?=$producto->getNombre();?></p>
                                <p><?=$producto->getPrecio();?>€</p>
                            
                            <div class="botones-pedido izquierda">
                                <a href="?controller=producto&id_producto=<?= $producto->getId(); ?>&action=restar" class="primaryButton-yellow-1 estilo-boton-pequeño text-center">-</a>
                                <input type="text" class="primaryButton-yellow-1 estilo-boton-pequeño cantidad-input text-center" value="<?= $cantidad; ?>">
                                <a href="?controller=producto&id_producto=<?= $producto->getId(); ?>&action=sumar" class="primaryButton-yellow-1 estilo-boton-pequeño text-center">+</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 d-flex justify-content-center align-items-center">
                        <div class="cantidad-pedido">
                            <div class="botones-pedido derecha">
                                <a href="?controller=producto&id_producto=<?= $producto->getId(); ?>&action=restar" class="primaryButton-yellow-1 estilo-boton-pequeño text-center">-</a>
                                <input type="text" class="primaryButton-yellow-1 estilo-boton-pequeño cantidad-input text-center" value="<?= $cantidad; ?>">
                                <a href="?controller=producto&id_producto=<?= $producto->getId(); ?>&action=sumar" class="primaryButton-yellow-1 estilo-boton-pequeño text-center">+</a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
                <div class="row w-100">
                    <div class="col-6 d-flex py-5">
                        <div class="direccion d-flex ps-5">
                            <label for="">Se te enviara a la siguiente direccion: </label>
                            <input type="text" class="form-control custom-border" id="direccion" name="direccion" placeholder="<?=$_SESSION['usuario']['direccion']?>" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 d-flex flex-column justify-content-center">
                        <div class="total text-start ps-5">
                            <p>Subtotal:</p>
                            <p>Total:</p>
                        </div>
                    </div>

                    <div class="col-6 d-flex flex-column justify-content-center">
                        <div class="precio-total text-end pe-5">
                            <p><b><?php 
                                if (isset($total)) {
                                    echo $total;
                                }
                                ?>€</b></p>
                            <p><b>
                                <?php 
                                if (isset($total)) {
                                    // Formatear el número para mostrarlo pero sin afectar el cálculo
                                    $numeroLimitado = number_format($total, 2, '.', ''); // Usar '.' como separador decimal para cálculos
                                    $numeroLimitado = (float)$numeroLimitado; // Convertir a número para operaciones matemáticas
                                    $totalConIVA = $numeroLimitado + (0.21 * $numeroLimitado); // Calcular el total con IVA
                                    $totalPedido = number_format($totalConIVA, 2);
                                    echo $totalPedido; // Mostrar el resultado formateado
                                }
                                ?>€</b></p>
                        </div>
                    </div>

                    <div class="col-12 d-flex flex-column align-items-center justify-content-center mt-4 pb-5">
                        <div class="tramitar-pedido gap-4 ps-5">
                            <a href="?controller=producto&action=tramitacion_pedidos&totalPedido=<?= $totalPedido; ?>" class="primaryButton-yellow-1">Tramitar pedido</a>
                            <a href="?controller=producto&action=menu"><u>SEGUIR COMPRANDO</u></a>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <?php
        } else if(isset($_SESSION['confirmacion-compra'])){
    ?>
        <div class="fondo-carrito d-flex align-items-center justify-content-center mx-auto">
            <?php if (isset($_SESSION['confirmacion-compra']) && $_SESSION['confirmacion-compra'] != ""): ?>
                <div class="alert alert-success mt-3 w-100 h-100 text-center d-flex flex-column justify-content-center">
                    <h2><?php echo $_SESSION['confirmacion-compra']; ?></h2>
                </div>
            <?php 
            unset($_SESSION['confirmacion-compra']); // Cuando el usuario abandona la pagina, el mensaje desaparece
            endif; 
            
            ?>
        </div>
    <?php
        }else {
    ?>
        <div class="fondo-carrito d-flex align-items-center justify-content-center mx-auto">
            <h2 class='text-center'>El carrito está vacío.</h2>
        </div>
    <?php
        }
    ?>
</div>
<?php 
include_once("views/footer/footer.php");
?>
