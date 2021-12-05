<?php
// include clases
include_once('/clases/planta.php');

// include cruds
include_once('/crud_plantas/crud_plantas.php');

// Si hay sesión y tenemos arrayPlantas llena, cogemos el index del POST
// y hacemos unset en ese index (unset elimina elementos de array).
// inicializamos arrayPlantas igualmente si no tenemos elementos, para que no salga undefined
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