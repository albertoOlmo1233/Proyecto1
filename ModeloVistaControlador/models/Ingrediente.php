<?php

// Creamos una clase abstracta para....
abstract class Ingrediente {
    protected $id_ingrediente;
    protected $nombre;
    protected $precio;
    
    public function __construct($id_ingrediente,$nombre,$precio){
        $this->id_ingrediente=$id_ingrediente;
        $this->nombre=$nombre;
        $this->precio=$precio;
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
     * Get the value of id_ingrediente
     */ 
    public function getId_ingrediente()
    {
        return $this->id_ingrediente;
    }

    /**
     * Set the value of id_ingrediente
     *
     * @return  self
     */ 
    public function setId_ingrediente($id_ingrediente)
    {
        $this->id_ingrediente = $id_ingrediente;

        return $this;
    }
}

?>