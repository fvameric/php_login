<?php

session_start();
if (isset($_SESSION['sessionID'])) {
    if (isset($_POST['vaciar-carrito'])) {
        unset($_SESSION['arrayPlantas']);
        header("Location: pagina_carrito.php");
    }
}
?>