<?php
$servidor   = 'localhost';
$usuario    = 'root';
$pass       = 'usbw';
$bd         = 'tienda';

$con = mysqli_connect($servidor, $usuario, $pass, $bd);

if(!$con) {
    die('<br><br>No se ha podido realizar la conexion_'.mysqli_connect_error().'<br>');
} else {
    mysqli_set_charset($con,'utf8');
}
?>