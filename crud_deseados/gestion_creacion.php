<?php
// include clases
include_once('../clases/user.php');

// include cruds
include_once('crud_deseados.php');

session_start();
if (isset($_SESSION['userSession'])) {

    // variables de sesión
    $userSession = $_SESSION['userSession'];

    // cruds
    $crudDeseados = new CrudDeseados();

    // se recoge la id de la planta del POST y se agrega a base de datos
    if (isset($_POST['id_planta'])) {
        $crudDeseados->agregarDeseado($userSession->getId(), $_POST['id_planta']);
    }

    // volvemos atrás
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>