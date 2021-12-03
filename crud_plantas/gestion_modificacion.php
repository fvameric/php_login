<?php
include('../conexion/db.php');

require_once('../crud_users/crud_users.php');
require_once('../clases/user.php');
require_once('crud_plantas.php');
require_once('../clases/planta.php');

session_start();
if (isset($_SESSION['$userSession'])) {
    $logueado = true;
    //$id_user = $_SESSION['sessionID'];
    $userSession = $_SESSION['userSession'];

    if (isset($_POST['aceptarmodif'])) {
        if (isset($_POST['id_planta'])) {
            $id_planta = $_POST['id_planta'];

            $crud = new CrudPlanta();
            $plantaModif = new Planta();
            $plantaModif = $crud->obtenerPlanta($id_planta);

            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            //$foto = $_POST['foto'];
            $compradas = $_POST['compradas'];
            
            $plantaModif->setId($id_planta);
            $plantaModif->setNombre($nombre);
            $plantaModif->setDescripcion($descripcion);
            $plantaModif->setPrecio($precio);
            $plantaModif->setStock($stock);

            if (!empty($_FILES["file"]["name"])) {
                $filename = $_FILES["file"]["name"];
                $path = $_FILES["file"]["tmp_name"];
                $src = $this->convertirBase64($filename, $path);
                $plantaModif->setFoto($src);
            }
            $plantaModif->setCompradas($compradas);
            if (isset($_POST['id_planta'])) {
                $categoria = $_POST['categoria'];
                $plantaModif->setCategoria($categoria);
            }
            $validacionUpdate = $crud->modificarPlanta($plantaModif, $id_planta);
        }
    }
} else {
    $logueado = false;
    header('Location: ../index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar planta</title>
</head>
<body>
    <?php  if ($validacionUpdate) { ?>
        Se realizó la modificación con éxito. 
    <?php } ?>
    <a href="../index.php">Volver atrás</a>
</body>
</html>