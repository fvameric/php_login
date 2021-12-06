<?php
// en caso de que tengamos sesión y se haya pulsado el botón de vaciar
// hacemos unset sin especificar index
// así se borra todo el array
session_start();
if (isset($_SESSION['userSession'])) {
    if (isset($_POST['vaciar-carrito'])) {
        unset($_SESSION['arrayPlantas']);
        header("Location: pagina_carrito.php");
    }
}
?>
