<?php
include_once("models/Producto.php");

class ProductoGeneral extends Producto {
    protected $precio_oferta;

    // Constructor vacío para compatibilidad con fetch_object
    public function __construct() {
        // Dejar vacío para permitir que fetch_object lo use
    }

    // Método para inicializar las propiedades
    public function initialize($id_producto, $nombre, $categoria, $descripcion, $precio, $imagen, $id_oferta, $precio_oferta) {
        parent::__construct($id_producto, $nombre, $categoria, $descripcion, $precio, $imagen, $id_oferta);
        $this->precio_oferta = $precio_oferta;
    }

    /**
     * Get the value of precio_oferta
     */
    public function getPrecioOferta()
    {
        return $this->precio_oferta;
    }
}
?>
