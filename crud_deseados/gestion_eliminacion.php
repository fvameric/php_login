<?php
    $id_deseado = $_POST['id_deseado'];

    //obtencion deseados
    require_once('crud_deseados.php');

    $crudDeseados = new CrudDeseados();
    $crudDeseados->eliminarDeseado($id_deseado);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>