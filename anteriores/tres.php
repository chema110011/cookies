<?php

try {
    $dsn = "mysql:host=localhost;dbname=prueba";
    $dbh = new PDO($dsn, 'chema', 'P@ssw0rd');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    echo $e->getMessage();
}

$digest = $_COOKIE['reloginID'];


// Comprobar el digest en la base de datos
$stmt = $dbh->prepare("SELECT username FROM users WHERE reloginDigest=?");
$stmt->execute(array($digest));
// Si se ha encontrado el usuario con el digest, mostramos su nombre:
$usuario = $stmt->fetch(PDO::FETCH_OBJ);
if($usuario){
    $nombre = $usuario->username;

    echo "Te has logeado satisfactoriamente " . $usuario->username;
} else {
    echo "Ha habido algún error en el login";
}

?>

