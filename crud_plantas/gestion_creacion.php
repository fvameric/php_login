<?php
// include clases
include_once('../clases/planta.php');

// include cruds
include_once('crud_plantas.php');

// cruds
$crudPlanta = new CrudPlanta();

// flags de validación
$validacionFormulario = false;
$validacionConsulta = false;

// si se pulsa en crear pero faltan datos por rellenar, se vuelven a pedir
if (isset($_POST['submit'])) {
    if (empty($_POST['nombre']) || empty($_POST['descripcion']) || $_POST['precio'] == null || $_POST['stock'] == null || $_POST['compradas'] == null || empty($_POST['categoria']) || empty($_FILES["file"]["name"])) {
        $validacionFormulario = true;
    } else {
        $filename = $_FILES["file"]["name"];
        $path = $_FILES["file"]["tmp_name"];
        $validacionImagen = $crudPlanta->validarImagen($filename);

        if ($validacionImagen) {
            $validacionConsulta = $crudPlanta->agregarPlanta($_POST['nombre'], $_POST['descripcion'], $_POST['precio'], $_POST['stock'], $_POST['compradas'], $_POST['categoria'], $_FILES["file"]["name"], $_FILES["file"]["tmp_name"]);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planta creada</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,700" />
    <script src="../sweetalert2.all.js"></script>
</head>

<body>
    <?php if ($validacionFormulario) { ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Por favor rellena todo el formulario'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = document.referrer;
                }
            });
        </script>
    <?php } else if (!$validacionConsulta || $validacionConsulta = null) { ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Hubo un error insertando en la base de datos'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = document.referrer;
                }
            });
        </script>
    <?php } else { ?>
        <script>
            Swal.fire({
                title: 'La planta está ready!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../profile.php';
                }
            });
        </script>
    <?php } ?>
</body>

</html>