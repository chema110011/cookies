<?php

class ficherodatos {

    private $nombref;

    public function __construct($n) {
        
        $this->nombref = $n;
    }

    public function getnombre() {

        return $this->nombref;
    }

    public function extrae() {
        try {
            if (!file_exists($this->nombref)) {
                throw new Exception("No encuentro el fichero ".$this->nombref);
            } else {
                $fh = file($this->nombref);
            }
        } catch (Exception $e) {

            echo $e->getMessage();

            die();
        }

        foreach ($fh as $content) {
            $datos[] = trim($content);
        }
        return $datos;
    }
}
?>

