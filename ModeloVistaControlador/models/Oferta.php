<?php

// Creamos una clase abstracta para....
class Oferta {
    protected $id_oferta;
    protected $categoria;
    protected $porcentaje;
    protected $fecha_inicio;
    protected $fecha_final;
    
    public function __construct($id_oferta,$categoria,$porcentaje,$fecha_inicio,$fecha_final){
        $this->id_oferta=$id_oferta;
        $this->categoria=$categoria;
        $this->porcentaje=$porcentaje;
        $this->fecha_inicio=$fecha_inicio;
        $this->fecha_final=$fecha_final;
    }
    

    /**
     * Get the value of id_oferta
     */ 
    public function getID()
    {
        return $this->id_oferta;
    }

    /**
     * Set the value of id_oferta
     *
     * @return  self
     */ 
    public function setID($id_oferta)
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
     *
     * @return  self
     */ 
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get the value of porcentaje
     */ 
    public function getPorcentaje()
    {
        return $this->porcentaje;
    }

    /**
     * Set the value of porcentaje
     *
     * @return  self
     */ 
    public function setPorcentaje($porcentaje)
    {
        $this->porcentaje = $porcentaje;

        return $this;
    }

    /**
     * Get the value of fecha_inicio
     */ 
    public function getFecha_inicio()
    {
        return $this->fecha_inicio;
    }

    /**
     * Set the value of fecha_inicio
     *
     * @return  self
     */ 
    public function setFecha_inicio($fecha_inicio)
    {
        $this->fecha_inicio = $fecha_inicio;

        return $this;
    }

    /**
     * Get the value of fecha_final
     */ 
    public function getFecha_final()
    {
        return $this->fecha_final;
    }

    /**
     * Set the value of fecha_final
     *
     * @return  self
     */ 
    public function setFecha_final($fecha_final)
    {
        $this->fecha_final = $fecha_final;

        return $this;
    }
}

?>