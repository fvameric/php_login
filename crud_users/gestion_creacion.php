<?php
include_once('crud_users.php');
include_once('/clases/user.php');

$crud = new CrudUser();
$user = new User();

if (isset($_POST['crear'])) {
    $user=$crud->obtenerUserPorId($_POST['id_user']);
}
?>