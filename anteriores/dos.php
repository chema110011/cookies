
 <?php
 try {
    $dsn = "mysql:host=localhost;dbname=prueba";
    $dbh = new PDO($dsn, 'chema', 'P@ssw0rd');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    echo $e->getMessage();
}
  
$stmt= $dbh->prepare("SELECT * FROM users WHERE username='Homer'");
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_OBJ);
// Creamos el digest
$digest = sha1(strval(rand(0, microtime(true)) . $usuario->username . strval(microtime(true))));
//$digest=1;
// Insertamos en digest en la base de datos
$stmt = $dbh->prepare("UPDATE users SET reloginDigest='".$digest."' WHERE username='".$usuario->username."'");
$stmt->execute();

setcookie("reloginID", $digest, time()+60*60^4*7);
$stmt=null;





        // put your code here
        
  ?>
