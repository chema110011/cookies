<?php

include_once 'datosconexion.php';
 class errores{
     
     private $numero;
     private  $mensajes; 
     
     public function __construct() {
          $nuevodatos = new ficherodatos('errores.txt');
        $this->mensajes = $nuevodatos->extrae();}
     
     public function muestra($numero){
       $error=$this->mensajes[$numero];
       echo "<script> alert('".$error."');</script>";
     }
     
     
 }

class Conexion {

    private $IP;
    private $usuario;
    private $pass;
    private $base;
    private $conexion;

    public function __construct() {
        $nuevodatos = new ficherodatos('datos.txt');
        $saca = $nuevodatos->extrae();
        $this->IP = $saca[0];
        $this->usuario = $saca[1];
        $this->pass = $saca[2];
        $this->base = $saca[3];
    }

    public function entrada($usu, $pass) {
        $salida = false;
        $result = mysqli_query($this->conexion, "SELECT * FROM usuarios WHERE usuario ='$usu'AND`password`='$pass' ");
        if (mysqli_num_rows($result) == '1') {
            $salida = true;
        }
        return $salida;
    }

    public function conecta() {
        try {

            $this->conexion = mysqli_connect($this->IP, $this->usuario, $this->pass);

            if ($this->conexion->connect_errno!=0) {
                throw new Exception("No hay conexion con la base  " . $this->base);
            }
        } catch (Exception $e) {

            echo $e->getMessage();

            die();
        }
        return mysqli_select_db($this->conexion, $this->base);
    }

    public function listar_REGISTROS($tabla) {
        $sql = "SELECT * FROM " . $tabla;

        $result = mysqli_query($this->conexion, $sql);
        foreach ($result as $valor) {
            $listar[] = $valor;
        };
        return $listar;
    }

    public function graba($sql) {
        if (mysqli_query($this->conexion, $sql))
            return true;
        else
            return false;
    }

    public function saca_consulta_filtrada($sql, $campos) {
        $array = mysqli_query($this->conexion, $sql);
        foreach ($array as $valor) {
            foreach ($campos as $ndato) {
                $listar[] = $valor[$ndato];
            }
        }


        return $listar;
    }

    public function consulta($sql) {
        $array = mysqli_query($this->conexion, $sql);
        foreach ($array as $valor) {

            $listar[] = $valor;
        }
        return $listar;
    }

    public function saca_campos($array, $campos) {
        foreach ($array as $valor) {
            foreach ($campos as $ndato) {
                $listar[] = $valor[$ndato];
            }
        };
        return $listar;
    }

    public function listar_campos($tabla) {
        $sql = "SHOW COLUMNS FROM " . $tabla;

        $result = mysqli_query($this->conexion, $sql);
        foreach ($result as $valor) {
            $listar[] = $valor['Field'];
        };
        return $listar;
    }

    public function nombre_base() {
        $sql = "SELECT DATABASE()";

        $result = mysqli_query($this->conexion, $sql);
        foreach ($result as $valor) {
            $listar[] = $valor;
        };
        $salida = $valor["DATABASE()"];
        return $salida;
    }

    public function desconecta() {
        $this->conexion = null;
    }

    public function getIP() {

        return $this->IP;
    }
}

class tabla_datos {

    private $arrayd;
    private $salida;

    public function __construct($n) {

        $this->arrayd = $n;
        $this->salida = " <style> table {border-collapse: collapse;} table,th,td {border: 1px solid black;} th,td {padding: 5px;}</style><table>";
    }

    public function tabla() {
        foreach ($this->arrayd as $linea) {
            $this->salida = $this->salida . '<tr>';
            foreach ($linea as $dato)
                $this->salida = $this->salida . ' <td>' . $dato . '</td>';
            $this->salida = $this->salida . '</tr>';
        }
        $this->salida = $this->salida . '</table>';
        return $this->salida;
    }

    public function tabla_con_form() {
        $i = 1;
        foreach ($this->arrayd as $linea) {
            $this->salida = $this->salida . '<tr>';

            foreach ($linea as $dato) {
                if (count($linea) > $i)
                    $this->salida = $this->salida . ' <td>' . $dato . '</td>';
                $i = $i + 1;
            }
            $i = 1;
            $this->salida = $this->salida . "<td>";
            $this->salida = $this->salida . "<form action='graba_servicios.php'>"; {
                $this->salida = $this->salida . "<input type='hidden' name='pasa' value='" . $dato . "'/>";
            }
            $this->salida = $this->salida . "<input type='submit' value='agregar servicios'/></form>";
            $this->salida = $this->salida . "</td>";
            $this->salida = $this->salida . '</tr>';
        }
        $this->salida = $this->salida . '</table>';
        return $this->salida;
    }

    public function ver_tabla() {

        echo $this->tabla();
    }
}
?>

