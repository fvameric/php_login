<?php
// include clases
include_once('../clases/user.php');

// include cruds
include_once('../crud_users/crud_users.php');

// cruds
$crudUser = new CrudUser();

// objetos
$user = new User();

// flags de validación
$validacionFormulario = false;
$validacionNick  = false;
$validacionEmail = false;
$validacionTamañoImagen  = false;
$validacionConsulta = false;

if (isset($_POST['submit'])) {
    if (empty($_POST['nickname']) || empty($_POST['password']) || empty($_POST['email'])) {
        $validacionFormulario = true;
    } else {
        $validacionNick = $crudUser->validarNick($_POST['nickname']);
        $validacionEmail = $crudUser->validarEmail($_POST['email']);
        if ($validacionNick && $validacionEmail) {
            $email = $_POST['email'];
            $nickname = $_POST['nickname'];
            $password = $_POST['password'];
            $password_hash = $crudUser->encriptarPassword($password);

            // avatar en caso de no haber puesto se le pondrá uno por defecto
            if (!empty($_FILES["file"]["name"])) {
                $size = $_FILES["file"]["size"];
                $filename = $_FILES["file"]["name"];
                $path = $_FILES["file"]["tmp_name"];

                $validacionTamañoImagen = $crudUser->validarSizeImagen($size);
                $validacionImagen = $crudUser->validarImagen($filename);
                if ($validacionImagen && $validacionTamañoImagen) {
                    $validacionConsulta = $crudUser->agregarUser($nickname, $password_hash, $email, $filename, $path);
                }
            } else {
                $validacionImagen = true;
                $validacionTamañoImagen = true;
                $filename = 'avatardefault.png';
                $path = realpath('../images/avatardefault.png');
                $validacionConsulta = $crudUser->agregarUser($nickname, $password_hash, $email, $filename, $path);
            }
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
    <title>Registro finalizado</title>
    <link rel="stylesheet" href="/styles/global.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,700" />
    <script src="../sweetalert2.all.js"></script>
</head>

<!--
    Se mostrará una notificación con SweetAlert2
    dependiendo de si las validaciones de arriba son true o false

    validacionFormulario = valida que se haya rellenado todo el formulario
    validacionNick = valida que el nick no esté en uso
    validacionEmail = valida que el email no esté en uso
    validacionImagen = valida que la imagen sea del formato correcto
    validacionTamañoImagen = valida que la imagen no sea excesivamente grande/pesada
    validacionConsulta = valia que el insert a base de datos se haya cumplido
-->

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
    <?php } else if (!$validacionNick) { ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Este nick ya está en uso'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = document.referrer;
                }
            });
        </script>
    <?php } else if (!$validacionEmail) { ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Este email ya está en uso'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = document.referrer;
                }
            });
        </script>
    <?php } else if (!$validacionImagen) { ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'La imagen no es válida',
                footer: 'Formatos permitidos: jpeg, jpg, png, gif'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = document.referrer;
                }
            });
        </script>
    <?php } else if (!$validacionTamañoImagen) { ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'La imagen es demasiado grande!'
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
                title: 'Ya estas ready!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../index.php';
                }
            });
        </script>
    <?php } ?>
</body>

</html>