<?php
    $id_deseado = $_POST['id_deseado'];

    //obtencion deseados
    require_once('crud_deseados.php');
    require_once('../clases/deseados.php');

    $crudDeseados = new CrudDeseados();
    $deseado = new Deseados();

    $crudDeseados->eliminarDeseado($id_deseado);
    
    header("Location: pagina_deseados.php");
?>