<?php
    include('/conexion/db.php');
    
    //obtencion plantas
    require_once('/crud_plantas/crud_plantas.php');
    require_once('/clases/planta.php');

    $crudPlanta = new CrudPlanta();
    $planta = new Planta();
    $listaPlantas = $crudPlanta->mostrar();

    $id_admin = $_POST['id_admin'];
    $id_planta = $_POST['id_planta'];

    $newPlanta;

    foreach($listaPlantas as $planta) {
        if ($id_planta == $planta->getId()) {
            $newPlanta = $planta;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class='header'>
        <div class='header-logo'>
            <a href="index.php" class="logo">
                <img src="images/logo.png">
            </a>
        </div>
        <div class='menu-user'>
            <a class="btn-registrarse" href="registro.html">Regístrate</a>
            <a class="btn-iniciarsesion" href="login.php">Inicia sesión</a>
        </div>
    </div>
    <div class="espacio">
    </div>
    <?php
    echo $newPlanta->getNombre();
    ?>
</body>
</html>