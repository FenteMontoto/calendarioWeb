<?php

function conexion(){
    $servidor="localhost";
    $usuario="root";
    $pass="";
    $bbdd="bbdd_calendarioweb";

    $conex=mysqli_connect($servidor,$usuario,$pass,$bbdd) or die ("No se pudo conectar a bbdd");
    mysqli_set_charset($conex,'utf8');
    return $conex;
}

?>