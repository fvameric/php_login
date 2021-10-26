<?php
    include '/conexion/db.php';
    
    $id = $_GET['id'];

    //obtencion users
    require_once('/crud_users/crud_users.php');
    require_once('/clases/user.php');

    $crudUser = new CrudUser();
    $user = new User();
    $listaUsers = $crudUser->mostrar();
    $user = $crudUser->obtenerUser($id);

    //obtencion plantas
    require_once('/crud_plantas/crud_plantas.php');
    require_once('/clases/planta.php');

    $crudPlanta = new CrudPlanta();
    $planta = new Planta();
    $listaPlantas = $crudPlanta->mostrar();
    $planta = $crudPlanta->obtenerPlanta($id);

    $contadorCarrito = 0;

    if(isset($_POST["add"])) {
        $contadorCarrito = $contadorCarrito + 1;
    }
?>