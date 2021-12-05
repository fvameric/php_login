<?php
// include cruds
include_once('crud_deseados.php');

if (isset($_POST['id_deseado'])) {

    // eliminar deseado de la base de datos
    $crudDeseados = new CrudDeseados();
    $crudDeseados->eliminarDeseado($_POST['id_deseado']);

    // volvemos atrás
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>