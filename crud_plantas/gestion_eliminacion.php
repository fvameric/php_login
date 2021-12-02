<?php
include_once('crud_plantas.php');
include_once('../clases/planta.php');
 
$crudPlanta = new CrudPlanta();
$planta = new Planta();

if (isset($_POST['id_planta'])) {
    $validacionDelete = $crudPlanta->eliminarPlanta($_POST['id_planta']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../sweetalert2.all.js"></script>
    <title>Planta eliminada</title>
</head>
<body>
    <?php if ($validacionDelete) { ?>
        <script>
            Swal.fire({
                title: 'Se eliminó con éxito la planta',
                confirmButtonText: 'Volver atrás'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `../index.php`;
                }
            });
        </script>
    <?php } ?>
</body>
</html>