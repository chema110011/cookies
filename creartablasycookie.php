<?php 
include_once 'objconexion.php';
//conexion a la base
try {
    $link = mysqli_connect("localhost", "chema", "P@ssw0rd", "cookies"); //cadena de conexion

    if (mysqli_connect_errno()) {//si hay algun error de conexion
        throw new Exception(mysqli_connect_error()); //creamos el mensaje de error de la excepcion
    }
} catch (Exception $e) {
    $mierror= new errores();
    $mierror->muestra(0); 
    die();
}

//una linea mas
//crear la tabla

$sql = "CREATE TABLE usuarios (id INT NOT NULL AUTO_INCREMENT"
        . ", usuario VARCHAR(60), password VARCHAR(80) ,"
        . " reloginDigest VARCHAR(255) ,"
        . " PRIMARY KEY (id));";
try {
    if (!mysqli_query($link, $sql)) {//si hay errores
        throw new Exception(mysqli_error($link));//genero una excepcion
    } 
} catch (Exception $e) {
    echo "hay algun error en la consulta";
    die();
}

//inserto un regisro
$sql="INSERT INTO usuarios (usuario, password) VALUES ('Homer', 'homerpass')";
try {
    if (!mysqli_query($link, $sql)) {//si hay errores
        throw new Exception(mysqli_error($link));//genero una excepcion
    } 
} catch (Exception $e) {
    echo "hay algun error en la consulta";
    die();
}



$sql="INSERT INTO usuarios (usuario, password) VALUES ('Garfiel', 'casita')";
try {
    if (!mysqli_query($link, $sql)) {//si hay errores
        throw new Exception(mysqli_error($link));//genero una excepcion
    } 
} catch (Exception $e) {
    echo "hay algun error en la consulta";
    die();
}


// Creamos el digest


 
$usuario ='Homer';
$digest = sha1(strval(rand(0, microtime(true)) . $usuario . strval(microtime(true))));
echo $digest."<br>";
$sql="UPDATE usuarios SET reloginDigest='".$digest."' WHERE usuario='".$usuario."'";
try {
    if (!mysqli_query($link, $sql)) {//si hay errores
        throw new Exception(mysqli_error($link));//genero una excepcion
    } 
} catch (Exception $e) {
    echo "hay algun error en la consulta";
    die();
}

$usuario ='Garfiel';
$digest = sha1(strval(rand(0, microtime(true)) . $usuario . strval(microtime(true))));
echo $digest."<br>";
$sql="UPDATE usuarios SET reloginDigest='".$digest."' WHERE usuario='".$usuario."'";
try {
    if (!mysqli_query($link, $sql)) {//si hay errores
        throw new Exception(mysqli_error($link));//genero una excepcion
    } 
} catch (Exception $e) {
    echo "hay algun error en la consulta 2";
    die();
}
setcookie("reloginID", $digest, time()+60*60^4*7);
echo " cookie creada ".$digest;