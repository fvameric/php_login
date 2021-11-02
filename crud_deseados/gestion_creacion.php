<?php
    session_start();
    if (isset($_SESSION['sessionID'])) {
        $id_user = $_SESSION['sessionID'];
        $id_planta = $_POST['id_planta'];
    
        //obtencion deseados
        require_once('crud_deseados.php');
        require_once('../clases/deseados.php');
    
        $crudDeseados = new CrudDeseados();
        $deseado = new Deseados();
    
        //obtencion users
        require_once('../crud_users/crud_users.php');
        require_once('../clases/user.php');
    
        $crudUser = new CrudUser();
        $user = new User();
        $listaUsers = $crudUser->mostrar();
    
        //obtencion plantas
        require_once('../crud_plantas/crud_plantas.php');
        require_once('../clases/planta.php');
    
        $crudPlantas = new CrudPlanta();
        $planta = new Planta();
        
        $crudDeseados->agregarDeseado($id_user, $id_planta);
        header("Location: pagina_deseados.php");
    }
?>