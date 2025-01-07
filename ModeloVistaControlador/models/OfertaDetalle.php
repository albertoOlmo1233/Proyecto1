<?php
include_once("models/Producto.php");
include_once("models/Oferta.php");
class OfertaDetalle extends Producto {
    protected $id_oferta;
    protected $categoria;
    public function __construct(){
    }

    /**
     * Get the value of id_oferta
     */
    public function getIdOferta()
    {
        return $this->id_oferta;
    }

    /**
     * Set the value of id_oferta
     */
    public function setIdOferta($id_oferta): self
    {
        $this->id_oferta = $id_oferta;

        return $this;
    }

    /**
     * Get the value of categoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set the value of categoria
     */
    public function setCategoria($categoria): self
    {
        $this->categoria = $categoria;

        return $this;
    }
}
?>