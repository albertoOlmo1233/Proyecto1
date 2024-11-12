<?php

class DataBase{
    public static function connect($host="localhost:3307", $user="root", $pass="Asdqwe!23",$db="OlmoAlberto_BD_Proyecto1"){
        $con = new mysqli($host,$user,$pass,$db);
        if($con == false){
            die("ERROR: no te puedes conectar: ".$con->connect_error);
        }
        return $con;
    }
}


?>