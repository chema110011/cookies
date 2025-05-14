<?php
include_once 'objconexion.php';
try {
    $link = mysqli_connect("localhost", "chema", "P@ssw0rd", "cookies"); //cadena de conexion
    if (mysqli_connect_errno()) {//si hay algun error de conexion
        throw new Exception(mysqli_connect_error());}//creamos el mensaje de error 
} catch (Exception $e) {
    $mierror = new errores();
    $mierror->muestra(0);
    die();}
if (isset($_COOKIE['reloginID'])) {    
    $digest = $_COOKIE['reloginID']; //busco la cookie
    $sql = "select usuario from usuarios where reloginDigest ='".$digest."'";
    try {
        if (!mysqli_query($link, $sql)) {//si hay errores
            throw new Exception(mysqli_error($link)); //genero una excepcion
        } else {
        $arraydatos = mysqli_query($link, $sql);} //si esta correcta lanzo la consulta         
    } catch (Exception $e) {
        echo "hay algun error en la consulta";
        die();}
    foreach ($arraydatos as $value) {
        foreach ($value as $datito) {
            echo "el usuario almacenado es ".$datito;
        }      
    }   
} else {
    echo "no hay cookie";
}    