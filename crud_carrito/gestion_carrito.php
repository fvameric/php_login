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
            if (empty($_SESSION['arrayPlantas'])) {
                
            }
            */

            $flag = false;
            $aux;

            foreach($_SESSION['arrayPlantas'] as $key => $plantas) {
                if ($plantas[0]->getId() == $planta_id) {
                    if (empty($_SESSION["arrayPlantas"][$key][$cantidad])) {
                        $_SESSION["arrayPlantas"][$key][$cantidad] = 0;
                    }
                    $plantas[1] += $cantidad;
                }
            }

            if (!$flag) {
                array_push($_SESSION['arrayPlantas'], array($planta, $cantidad));
            }

            /////////////

            if(!empty($_SESSION["arrayPlantas"])) {
                if(in_array($productByCode[0]["code"],array_keys($_SESSION["arrayPlantas"]))) {
                    foreach($_SESSION["arrayPlantas"] as $k => $v) {
                            if($productByCode[0]["code"] == $k) {
                                if(empty($_SESSION["arrayPlantas"][$k]["quantity"])) {
                                    $_SESSION["arrayPlantas"][$k]["quantity"] = 0;
                                }
                                $_SESSION["arrayPlantas"][$k]["quantity"] += $_POST["quantity"];
                            }
                    }
                } else {
                    $_SESSION["arrayPlantas"] = array_merge($_SESSION["arrayPlantas"], $cantidad);
                }
            } else {
                $_SESSION["arrayPlantas"] = $itemArray;
            }
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    } else {
        $_SESSION['arrayPlantas'] = [];
    }
}
