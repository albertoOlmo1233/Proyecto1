<?php

// Creamos una clase abstracta para....
abstract class Log {

    public $id_log;
    protected $correo;
    protected $mensaje;
    protected $fecha;
    
    public function __construct($id_log,$correo,$mensaje,$fecha){
        $this->id_log=$id_log;
        $this->correo=$correo;
        $this->mensaje=$mensaje;
        $this->fecha=$fecha;
    }

    /**
     * Get the value of id_log
     */ 
    public function getId_log()
    {
        return $this->id_log;
    }

    /**
     * Set the value of id_log
     *
     * @return  self
     */ 
    public function setId_log($id_log)
    {
        $this->id_log = $id_log;

        return $this;
    }

    /**
     * Get the value of correo
     */ 
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set the value of correo
     *
     * @return  self
     */ 
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get the value of mensaje
     */ 
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * Set the value of mensaje
     *
     * @return  self
     */ 
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;

        return $this;
    }

    /**
     * Get the value of fecha
     */ 
    public function getFecha()
    {
        return $this->fecha;
    }
}

?>