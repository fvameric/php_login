<?php
    include('/conexion/db.php');
    
    require('/crud_users/crud_users.php');
    require('/clases/user.php');

    $crudUser = new CrudUser();
    $user = new User();

    $nickname = $_POST['nickname'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $targetDir = "uploads/";
    $filename = $_FILES["file"]["name"];
    $targetFilePath = $targetDir . $filename;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

    if(isset($_POST['submit']))
    {
        $validacion = $crudUser->validarRegistro($nickname, $email, $fileType);
        if ($validacion == "") {
            if ($crudUser->agregarUser($nickname, $password, $email, $fileType) != NULL) {
                echo 'Se registró correctamente.';
            }
        } else {
            echo $validacion;
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
            <!--<form action="index.html"><input type="submit" value="Volver atrás" /></form>-->
        </body>
</html>
