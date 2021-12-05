<?php
include_once('../crud_users/crud_users.php');
include_once('../clases/user.php');

$crudUser = new CrudUser();
$user = new User();

if (isset($_POST['submit'])) {
    if (empty($_POST['nickname']) || empty($_POST['password']) || empty($_POST['email'])) {
        echo 'Por favor rellena el formulario.';
    } else {
        $validacionRegistro = $crudUser->validarRegistro($_POST['nickname'], $_POST['email']);
        if ($validacionRegistro) {
            $email = $_POST['email'];
            $nickname = $_POST['nickname'];
            $password = $_POST['password'];
            $password_hash = $crudUser->encriptarPassword($password);

            // avatar en caso de no haber puesto se le pondrá uno por defecto
            if (!empty($_FILES["file"]["name"])) {
                $filename = $_FILES["file"]["name"];
                $path = $_FILES["file"]["tmp_name"];
            } else {
                $filename = 'avatardefault.png';
                $path = realpath('../images/avatardefault.png');
            }

            $validacionConsulta = $crudUser->agregarUser($nickname, $password_hash, $email, $filename, $path);
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
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,700" />
    <script src="../sweetalert2.all.js"></script>
</head>

<body>
    <?php if ($validacionRegistro) { ?>
        <?php if ($validacionConsulta) { ?>
            <script>
                Swal.fire({
                    title: 'Ya estas ready!',
                    confirmButtonText: 'Cerrar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = document.referrer;
                    }
                });
            </script>
        <?php } ?>
    <?php } else { ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Este nick o email ya está en uso.'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = document.referrer;
                }
            });
        </script>
    <?php } ?>
</body>

</html>