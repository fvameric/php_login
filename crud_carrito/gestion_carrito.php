<?php
// include clases
include_once('../clases/planta.php');

// include cruds
include_once('../crud_plantas/crud_plantas.php');

// si hay login y plantas agregadas al carrito
// creamos objeto planta para agregarlo en arrayplantas
// junto con la cantidad que se le pasa también por el POST
// si no tuvieramos nada, inicializamos igualmente arrayPlantas
// para que no aparezca undefined
session_start();
if (isset($_SESSION['userSession'])) {
    if (isset($_SESSION['arrayPlantas'])) {
        if (isset($_POST['plant']) && isset($_POST['cantidad'])) {

            // variables que obtenemos del index
            $planta_id = $_POST['plant'];
            $cantidad = $_POST['cantidad'];

            // se obtiene la planta a partir de su ID
            $crudPlantas = new CrudPlanta();
            $planta = $crudPlantas->obtenerPlanta($planta_id);

            // si existen elementos en el carrito,
            // buscamos la planta ya existente y agregamos la cantidad a esa misma planta
            // así se le puede aplicar distintas cantidades en vez de
            // añadir la misma planta y que aparezca más de una vez en la lista
            $flag = false;
            if (!empty($_SESSION['arrayPlantas'])) {
                foreach($_SESSION['arrayPlantas'] as $key => $plantas) {
                    if ($plantas[0]->getId() == $planta_id) {
                        $_SESSION['arrayPlantas'][$key][1] += $cantidad;
                        $flag = true;
                    }
                }
            }

            if (!$flag) {
                array_push($_SESSION['arrayPlantas'], array($planta, $cantidad));
            }

            // una vez agregada, volvemos atrás
            //header('Location: ' . $_SERVER['HTTP_REFERER']);
            header('Location: ../index.php');
        }
    } else {
        $_SESSION['arrayPlantas'] = [];
    }
}
