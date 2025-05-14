<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
      
try {
    $dsn = "mysql:host=localhost;dbname=prueba";
    $dbh = new PDO($dsn, 'chema', 'P@ssw0rd');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    echo $e->getMessage();
}
// Crear tabla usuarios
$stmt = $dbh->prepare("CREATE TABLE users (
id INT NOT NULL AUTO_INCREMENT,
username VARCHAR(60),
password VARCHAR(80),
reloginDigest VARCHAR(255),
PRIMARY KEY (id)
)");
$stmt->execute();
// Crear usuario Homer. Contraseña desprotegida para centrarnos en el sistema login
$stmt = $dbh->prepare("INSERT INTO users (username, password) VALUES ('Homer', 'homerpass')");
$stmt->execute();
        
$stmt= $dbh->prepare("SELECT * FROM users WHERE username='Homer'");
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_OBJ);
// Creamos el digest
$digest = sha1(strval(rand(0, microtime(true)) . $usuario->username . strval(microtime(true))));
// Insertamos en digest en la base de datos
$stmt = $dbh->prepare("UPDATE users SET reloginDigest='".$digest."' WHERE username='".$usuario->username."'");
$stmt->execute();
// Creamos la cookie con el digest
setcookie('reloginID', $digest, time()+60*60^4*7, '/', 'prueba.dev', false, true);
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


        // put your code here
        ?>
    </body>
</html>
