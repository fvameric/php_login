<?php
include_once('crud_plantas.php');
include_once('../clases/planta.php');
 
$crud = new CrudPlanta();
$planta = new Planta();

if (isset($_POST['id_planta'])) {
    $crud->eliminar($_POST['id_planta']);
    header("Location: ../profileAdmin.php");
}
?>