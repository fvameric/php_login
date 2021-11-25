<?php

class db {
    private $servidor   = 'localhost';
    private $usuario    = 'root';
    private $pass       = 'usbw';
    private $bd         = 'tienda';
    private $con;

    function __construct() {
        $this->iniciarConexion();
    }

    function iniciarConexion() {
        $this->con = mysqli_connect(
            $this->servidor,
            $this->usuario,
            $this->pass,
            $this->bd
        );

        if ($this->con) {
            mysqli_set_charset($this->con,'utf8');
        } else {
            die("Con se ha podido realizar la conexión: ". mysqli_connect_error() . "<br>");
        }
    }

    function obtenerConexion() {
        return $this->con;
    }
}
?>