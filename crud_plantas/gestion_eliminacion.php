<?php
// include cruds
include_once('crud_plantas.php');

// cruds
$crudPlanta = new CrudPlanta();

session_start();
if (isset($_POST['id_planta'])) {
    // elimina (unset) las plantas visitadas recientemente si se han eliminado a través del crud
    foreach ($_SESSION['plantasVisitadas'] as $key => $reciente) {
        if ($reciente->getId() == $_POST['id_planta']) {
            unset($_SESSION['plantasVisitadas'][$key]);
            $_SESSION['plantasVisitadas'] = array_values($_SESSION['plantasVisitadas']);
        }
    }
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