
<?php
setcookie("esta", 'pepe', time() + 30*24*60*60);

echo "El valor de la cookie esta es: " . $_COOKIE['esta'];

?>