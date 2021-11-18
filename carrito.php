<?php
    include '/conexion/db.php';
    require_once('/clases/planta.php');
    require_once('/crud_plantas/crud_plantas.php');

    $planta_id = $_POST['plant'];

    //obtencion plantas
    $crudPlantas = new CrudPlanta();
    $planta = $crudPlantas->obtenerPlanta($planta_id);
    
    session_start();
    if (isset($_SESSION['sessionID'])) {
        
        array_push($_SESSION['arrayPlantas'], $planta);

        foreach($_SESSION['arrayPlantas'] as $value) {
            echo $value->getNombre();
            echo '<br>';
        }
    } else {
        header("Location: index.php");
    }
?>