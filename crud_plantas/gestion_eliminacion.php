<?php
include_once('crud_plantas.php');
include_once('../clases/planta.php');
 
$crud = new CrudPlanta();
$planta = new Planta();

if (isset($_POST['id_planta'])) {
    $validacionDelete = $crud->eliminar($_POST['id_planta']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planta eliminada</title>
</head>
<body>
    <?php if ($validacionDelete) { ?>
        Se eliminó la planta con éxito.
    <?php } ?>
    <a href="../profileAdmin.php">Volver atrás</a>
</body>
</html>