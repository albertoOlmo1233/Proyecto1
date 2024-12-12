<?php

// Creamos una clase abstracta para....
abstract class Producto {
    const TYPE_CAMISETA = 1;
    const TYPE_PANTALONES = 2;

    protected $nombre;
    protected $talla;
    protected $precio;
    
    public function __construct($nombre,$talla,$precio){
        $this->$nombre=$nombre;
        $this->$talla=$talla;
        $this->$precio=$precio;
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
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of talla
     */ 
    public function getTalla()
    {
        return $this->talla;
    }

    /**
     * Set the value of talla
     *
     * @return  self
     */ 
    public function setTalla($talla)
    {
        $this->talla = $talla;

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
     *
     * @return  self
     */ 
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }
}

?>