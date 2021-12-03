<?php
//include_once('/conexion/db.php');
include_once('/clases/planta.php');
include_once('/crud_plantas/crud_plantas.php');
session_start();
if (isset($_SESSION['userSession'])) {
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