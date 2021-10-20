<?php
require_once('crud_users.php');
require_once('user.php');
 
$crud = new CrudUser();
$user = new User();

if (isset($_POST['id_user'])) {
    $crud->eliminar($_POST['id_user']);
    header("Location: profileAdmin.php?id=".$_POST['id_admin']);
}
?>