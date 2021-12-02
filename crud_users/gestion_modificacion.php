<?php
include_once('crud_users.php');
include_once('../clases/user.php');

session_start();
if (isset($_SESSION['sessionID'])) {
    $logueado = true;
    $id_user = $_SESSION['sessionID'];

    $crudUser = new CrudUser();
    $user = new User();
    $listaUsers = $crudUser->obtenerListaUsuarios();
    $user = $crudUser->obtenerUser($id_user);

    if (isset($_POST['aceptarmodif'])) {
        if (isset($_POST['id_user_modificar'])) {
            $id_user_modificar = $_POST['id_user_modificar'];
            $nickname = $_POST['nickname'];
            $email = $_POST['email'];

            $userModif = new User();
            $userModif = $crudUser->obtenerUser($id_user_modificar);

            $userModif->setId($id_user_modificar);
            $userModif->setNickname($nickname);
            $userModif->setEmail($email);

            if (!empty($_FILES["file"]["name"])) {
                $filename = $_FILES["file"]["name"];
                $path = $_FILES["file"]["tmp_name"];
                $src = $this->convertirBase64($filename, $path);
                $userModif->setAvatar($src);
            }
            $validacionConsulta = $crudUser->modificarUsuario($userModif, $id_user_modificar);
        }
    }
} else {
    $logueado = false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificación user</title>
</head>

<body>
    <?php if ($validacionConsulta) { ?>
        Se realizó la modificación.
    <?php } ?>
    <a href="../profileAdmin.php">Volver atrás</a>
</body>

</html>