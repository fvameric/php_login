<?php
    include 'db.php';
    require_once('../clases/planta.php');
    require_once('../crud_plantas/crud_plantas.php');

    //obtencion plantas
    $crudPlantas = new CrudPlanta();

    session_start();
    if (isset($_SESSION['sessionID'])) {
        if (isset($_SESSION['arrayPlantas'])) {
            if (isset($_POST['index'])) {
                unset($_SESSION['arrayPlantas'][$_POST['index']]);
                header("Location: pagina_carrito.php");
            }
        } else {
            $_SESSION['arrayPlantas'] = [];
        }
    }
?>