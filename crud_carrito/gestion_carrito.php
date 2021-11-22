<?php
    include 'db.php';
    require_once('../clases/planta.php');
    require_once('../crud_plantas/crud_plantas.php');

    //obtencion plantas
    $crudPlantas = new CrudPlanta();

    session_start();
    if (isset($_SESSION['sessionID'])) {
        if (isset($_SESSION['arrayPlantas'])) {
            if (isset($_POST['plant'])) {
                $planta_id = $_POST['plant'];
                $planta = $crudPlantas->obtenerPlanta($planta_id);

                /*
                foreach($_SESSION['arrayPlantas'] as $elem) {
                    if ($elem == $planta) {

                    }
                }
                */
                
                array_push($_SESSION['arrayPlantas'], $planta);
                //header("Location: ../profileAdmin.php");
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        } else {
            $_SESSION['arrayPlantas'] = [];
        }
    }
