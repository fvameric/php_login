<?php
    //include_once('../conexion/db.php');
    
    include_once('crud_plantas.php');
    include_once('../clases/planta.php');

    $crudPlanta= new CrudPlanta();
    $planta = new Planta();

    if(isset($_POST['submit'])) {
        if (empty($_POST['nombre']) || empty($_POST['descripcion']) || empty($_POST['precio']) || empty($_POST['stock']) || empty($_POST['compradas']) || empty($_POST['categoria']) || empty($_FILES["file"]["name"])) {
            echo 'Por favor rellena el formulario.';
        } else {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $compradas = $_POST['compradas'];
            $categoria = $_POST['categoria'];

            $filename = $_FILES["file"]["name"];
            $path = $_FILES["file"]["tmp_name"];
            $crudPlanta->agregarPlanta($nombre, $descripcion, $precio, $stock, $compradas, $categoria, $filename, $path);
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
        Se creó la planta correctamente.
        <a href="../profileAdmin.php">Volver atrás</a>
        </body>
</html>
