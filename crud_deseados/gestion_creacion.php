<?php
//obtencion deseados
include_once('crud_deseados.php');

//obtencion users
include_once('../clases/user.php');

session_start();
if (isset($_SESSION['userSession'])) {
    $userSession = $_SESSION['userSession'];
    $id_planta = $_POST['id_planta'];

    $crudDeseados = new CrudDeseados();
    $crudDeseados->agregarDeseado($userSession->getId(), $id_planta);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
