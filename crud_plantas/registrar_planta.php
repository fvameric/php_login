<?php
    include('db.php');
    
    require('crud_plantas.php');
    require('../clases/planta.php');

    $crudPlanta= new CrudPlanta();
    $planta = new Planta();

    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $compradas = $_POST['compradas'];

    $targetDir = "uploads/";
    $filename = $_FILES["file"]["name"];
    $targetFilePath = $targetDir . $filename;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

    if(isset($_POST['submit']))
    {
        if ($crudPlanta->agregarPlanta($nombre, $descripcion, $precio, $stock, $compradas) != NULL) {
            echo 'Se registró correctamente.';
        }

        /*
        $validacion = $crudUser->validarRegistro($nickname, $email, $fileType);
        if ($validacion == "") {
            if ($crudUser->agregarUser($nickname, $password, $email, $fileType) != NULL) {
                echo 'Se registró correctamente.';
            }
            
        } else {
            echo $validacion;
        }
        */
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
            <a href="javascript:history.go(-1)">Volver atrás</a>
        </body>
</html>
