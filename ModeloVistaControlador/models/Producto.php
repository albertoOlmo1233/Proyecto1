<?php


// Creamos una clase abstracta para....
abstract class Producto {
    protected $id_producto;
    protected $nombre;
    protected $categoria;
    protected $descripcion;
    protected $precio;
    protected $imagen;
    protected $id_oferta;
    
    public function __construct($id_producto,$nombre,$categoria,$descripcion,$precio,$imagen,$id_oferta){
        $this->id_producto=$id_producto;
        $this->nombre=$nombre;
        $this->categoria=$categoria;
        $this->descripcion=$descripcion;
        $this->imagen=$imagen;
        $this->id_oferta=$id_oferta;
    }


    /**
     * Get the value of ID
     */
    public function getID()
    {
        return $this->id_producto;
    }

    /**
     * Set the value of ID
     */
    public function setID($id_producto): self
    {
        $this->id_producto = $id_producto;

        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre($nombre): self
    {
        $this->nombre = $nombre;

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

    /**
     * Get the value of descripcion
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     */
    public function setDescripcion($descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get the value of precio
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set the value of precio
     */
    public function setPrecio($precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get the value of imagen
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set the value of imagen
     */
    public function setImagen($imagen): self
    {
        $this->imagen = $imagen;

        return $this;
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
}

?>