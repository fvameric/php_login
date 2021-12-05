<?php
// include clases
include_once('../clases/planta.php');

// include cruds
include_once('crud_plantas.php');

// cruds
$crudPlanta = new CrudPlanta();

// si se pulsa en crear pero faltan datos por rellenar, se vuelven a pedir
if (isset($_POST['submit'])) {
    if (empty($_POST['nombre']) || empty($_POST['descripcion']) || empty($_POST['precio']) || empty($_POST['stock']) || empty($_POST['compradas']) || empty($_POST['categoria']) || empty($_FILES["file"]["name"])) {
        echo 'Por favor rellena el formulario.';
    } else {
        $validacionInsert = $crudPlanta->agregarPlanta($_POST['nombre'], $_POST['descripcion'], $_POST['precio'], $_POST['stock'], $_POST['compradas'], $_POST['categoria'], $_FILES["file"]["name"], $_FILES["file"]["tmp_name"]);
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
<?php if ($validacionInsert) { ?>
        <script>
            Swal.fire({
                title: 'Se creó con éxito la planta',
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