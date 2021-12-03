<?php

//obtencion deseados
include_once('crud_deseados.php');
include_once('../clases/deseados.php');

//obtencion users
include_once('../crud_users/crud_users.php');
include_once('../clases/user.php');

//obtencion plantas
include_once('../crud_plantas/crud_plantas.php');
include_once('../clases/planta.php');

session_start();
if (isset($_SESSION['userSession'])) {
    //$id_user = $_SESSION['sessionID'];
    $userSession = $_SESSION['userSession'];
    $id_planta = $_POST['id_planta'];



    $crudDeseados = new CrudDeseados();
    //$deseado = new Deseados();



    $crudUser = new CrudUser();
    //$user = new User();
    $listaUsers = $crudUser->obtenerListaUsuarios();



    $crudPlantas = new CrudPlanta();
    $planta = new Planta();

    $crudDeseados->agregarDeseado($userSession->getId(), $id_planta);
    //header("Location: pagina_deseados.php");
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
