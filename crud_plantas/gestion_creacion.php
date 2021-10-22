<?php
require_once('crud_plantas.php');
require_once('../clases/planta.php');

$crud = new CrudPlanta();
$planta = new Planta();

//$id = $_POST['id_admin'];

if (isset($_POST['crear'])) {
    $planta=$crud->obtenerPlanta($_POST['id_planta']);
}
?>