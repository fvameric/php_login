<?php
require_once('crud_plantas.php');
require_once('../clases/planta.php');

$crud = new CrudPlanta();
$planta = new Planta();

$id = $_POST['id_admin'];

if (isset($_POST['id_planta'])) {
    $planta=$crud->obtenerPlanta($_POST['id_planta']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar planta</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <form action='/crud_plantas/gestion_modificacion.php' method='POST' enctype="multipart/form-data">
        <div class='modificar-user'>
            <div class='modificar-avatar'>
                <img src=<?php echo $planta->getFoto() ?>>
                <input type="file" name='file'>
            </div>
            <div class='modificar-content'>
                <div class='modificar-content-nombre'>
                    <label>Nombre:</label>
                    <input type="text" name="nombre" value="<?php echo $planta->getNombre() ?>">
                </div>
                <div class='modificar-content-email'>
                    <label>Descripcion:</label>
                    <input type="text" name="descripcion" value="<?php echo $planta->getDescripcion() ?>">
                </div>
                <div class='modificar-content-email'>
                    <label>Precio:</label>
                    <input type="number" step="any" name="precio" value="<?php echo $planta->getPrecio() ?>">
                </div>
                <div class='modificar-content-email'>
                    <label>Stock:</label>
                    <input type="number" name="stock" value="<?php echo $planta->getStock() ?>">
                </div>
                <div class='modificar-content-email'>
                    <label>Compradas:</label>
                    <input type="number" name="compradas" value="<?php echo $planta->getCompradas() ?>">
                </div>
            </div>
            <input type='hidden' name='id_admin' value='<?php echo $id ?>'>
            <input type='hidden' name='id_planta' value='<?php echo $planta->getId() ?>'>
            <input type='hidden' name='actualizar' value='actualizar'>
        </div>
        <div class='aceptar-modificaciones'>
            <input type='submit' name="aceptarmodif" value='Aceptar modificaciones'>
            <a href="../profileAdmin.php?id=<?php echo $id ?>">Volver atrás</a>
        </div>
    </form>
</body>
</html>
