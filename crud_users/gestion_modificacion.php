<?php
// include clases
include_once('../clases/user.php');

// include cruds
include_once('crud_users.php');
if (isset($_POST['aceptarmodif'])) {
    if (isset($_POST['id_usuario_modificar'])) {

        // crud
        $crudUser = new CrudUser();
        $validacionRegistro = $crudUser->validarRegistro($_POST['nickname'], $_POST['email']);

        if ($validacionRegistro) {

            // user a modificar según la id
            $userModif = new User();
            $userModif = $crudUser->obtenerUser($_POST['id_usuario_modificar']);

            // nuevos (o mismos) valores
            $userModif->setId($_POST['id_usuario_modificar']);
            $userModif->setNickname($_POST['nickname']);
            $userModif->setEmail($_POST['email']);
            // avatar
            if (!empty($_FILES["file"]["name"])) {
                $filename = $_FILES["file"]["name"];
                $path = $_FILES["file"]["tmp_name"];
                $src = $this->convertirBase64($filename, $path);
                $userModif->setAvatar($src);
            }
            // se hace el update en base de datos
            $validacionConsulta = $crudUser->modificarUsuario($userModif);
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
    <title>Modificación user</title>
    <script src="../sweetalert2.all.js"></script>
</head>

<body>
    <?php if ($validacionRegistro) { ?>
        <?php if ($validacionConsulta) { ?>
            <script>
                Swal.fire({
                    title: 'Se creó el usuario con éxito',
                    confirmButtonText: 'Volver atrás'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `../profile.php`;
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
                    window.location.href = `../profile.php`;
                }
            });
        </script>
    <?php } ?>
</body>

</html>