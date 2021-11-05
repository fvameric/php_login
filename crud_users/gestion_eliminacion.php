<?php
    require_once('crud_users.php');

    $crud = new CrudUser();

    if (isset($_POST['id_user'])) {
        $crud->eliminar($_POST['id_user']);
        header("Location: ../profileAdmin.php");
    }
?>