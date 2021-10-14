<?php
    include('db.php');
    
    // File upload path
    $targetDir = "uploads/";
    $filename = $_FILES["file"]["name"];
    $targetFilePath = $targetDir . $filename;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

    $nickname = $_POST['nickname'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $sql = 'INSERT INTO `usuarios`.`users` (`id` ,`nickname` ,`password`, `email`, `avatar`)VALUES (NULL , "'.$nickname.'", "'.$password.'", "'.$email.'", "'.$filename.'")';
    
    if(isset($_POST["submit"])){
        $tempname = $_FILES["file"]["tmp_name"];
        $folder = "uploads/".$filename;

        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            $consulta = mysqli_query($con,$sql);

            if (!$consulta) {
                die('<br>No se ha podido realizar el insert');
            } else {
                echo '<br>Se realizó el insert';
            }
        } else {
            echo 'no se pudo mover a uploads';
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
    </head>
        <body>
            <form action="login.html">
                <input type="submit" value="login" />
            </form>
        </body>
</html>