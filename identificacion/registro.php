<?php
include('../conexion/db.php');

require('../crud_users/crud_users.php');
require('../clases/user.php');

$crudUser = new CrudUser();
$user = new User();

if (isset($_POST['submit'])) {
    if (empty($_POST['nickname']) || empty($_POST['password']) || empty($_POST['email'])) {
        echo 'Por favor rellena el formulario.';
    } else {
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

        if ($validacionConsulta) {
            header('Location: login.php');
        } else {
            echo 'falló la consulta al registrar.';
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
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <a href="javascript:history.go(-1)">Volver atrás</a>
</body>

</html>