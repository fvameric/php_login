<?php
    include_once('crud_deseados.php');

    //variables
    $id_deseado = $_POST['id_deseado'];

    // eliminar deseado con el crud
    $crudDeseados = new CrudDeseados();
    $crudDeseados->eliminarDeseado($id_deseado);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>