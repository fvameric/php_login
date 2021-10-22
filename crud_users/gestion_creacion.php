<?php
require_once('crud_users.php');
require_once('/clases/user.php');

$crud = new CrudUser();
$user = new User();

$id = $_POST['id_admin'];

if (isset($_POST['crear'])) {
    $user=$crud->obtenerUser($_POST['id_user']);
}
?>