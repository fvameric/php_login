<?php
require_once('crud_plantas.php');
require_once('../clases/planta.php');
 
$crud = new CrudPlanta();
$planta = new Planta();

if (isset($_POST['id_planta'])) {
    $crud->eliminar($_POST['id_planta']);
    header("Location: ../profileAdmin.php");
}
?>