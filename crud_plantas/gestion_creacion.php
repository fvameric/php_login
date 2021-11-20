<?php
require_once('crud_plantas.php');
require_once('../clases/planta.php');

$crud = new CrudPlanta();
$planta = new Planta();

if (isset($_POST['crear'])) {
    $planta=$crud->obtenerPlanta($_POST['id_planta']);
}
?>