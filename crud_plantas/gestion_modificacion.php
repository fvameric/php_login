<?php
// include clases
include_once('../clases/planta.php');

// include cruds
include_once('crud_plantas.php');

if (isset($_POST['aceptarmodif'])) {
    if (isset($_POST['id_planta'])) {

        // crud
        $crudPlanta = new CrudPlanta();

        // planta a modificar según la id
        $plantaModif = new Planta();
        $plantaModif = $crudPlanta->obtenerPlanta($_POST['id_planta']);

        // nuevos (o mismos) valores
        $plantaModif->setId($_POST['id_planta']);
        $plantaModif->setNombre($_POST['nombre']);
        $plantaModif->setDescripcion($_POST['descripcion']);
        $plantaModif->setPrecio($_POST['precio']);
        $plantaModif->setStock($_POST['stock']);
        $plantaModif->setCompradas($_POST['compradas']);
        $plantaModif->setCategoria($_POST['categoria']);
        // avatar
        if (!empty($_FILES["file"]["name"])) {
            $filename = $_FILES["file"]["name"];
            $path = $_FILES["file"]["tmp_name"];
            $src = $this->convertirBase64($filename, $path);
            $plantaModif->setFoto($src);
        }
        // se hace el update en base de datos
        $validacionUpdate = $crudPlanta->modificarPlanta($plantaModif, $_POST['id_planta']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar planta</title>
    <script src="../sweetalert2.all.js"></script>
</head>

<body>
    <?php if ($validacionUpdate) { ?>
        <script>
            Swal.fire({
                title: 'Se modificó la planta con éxito',
                confirmButtonText: 'Volver atrás'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `../profile.php`;
                }
            });
        </script>
    <?php } ?>
</body>

</html>