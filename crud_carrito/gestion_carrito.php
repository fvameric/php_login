<?php
include 'db.php';
require_once('../clases/planta.php');
require_once('../crud_plantas/crud_plantas.php');

//obtencion plantas
$crudPlantas = new CrudPlanta();

session_start();
if (isset($_SESSION['sessionID'])) {
    if (isset($_SESSION['arrayPlantas'])) {
        if (isset($_POST['plant']) && isset($_POST['cantidad'])) {
            $planta_id = $_POST['plant'];
            $cantidad = $_POST['cantidad'];
            $planta = $crudPlantas->obtenerPlanta($planta_id);

            /*
                foreach($_SESSION['arrayPlantas'] as $elem) {
                    if ($elem == $planta) {

                    }
                }
                */

            array_push($_SESSION['arrayPlantas'], array($planta, $cantidad));
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    } else {
        $_SESSION['arrayPlantas'] = [];
    }
}
