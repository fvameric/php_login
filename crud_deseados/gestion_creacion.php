<?php
include_once('/conexion/db.php');

session_start();
if (isset($_SESSION['sessionID'])) {
    $id_user = $_SESSION['sessionID'];
    $id_planta = $_POST['id_planta'];

    $crudDeseados->agregarDeseado($id_user, $id_planta);
    header("Location: ../profileAdmin.php");
}
?>