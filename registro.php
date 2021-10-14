<?php
    include('db.php');
    
    $targetDir = "uploads/";
    $filename = $_FILES["file"]["name"];
    $targetFilePath = $targetDir . $filename;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

    $nickname = $_POST['nickname'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if(isset($_POST["submit"])){
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath))
        {
            if($fileType == 'jpg' || $fileType == 'png' || $fileType == 'gif') {
                $imageData = base64_encode(file_get_contents($targetFilePath));
                $src = 'data:'.$fileType.';base64,' . $imageData;
    
                $sql='SELECT * FROM `users` WHERE 1';
                $consultaUsersExistentes = mysqli_query($con,$sql);
    
                $userExiste = false;
                if (trim($nickname) != "" && trim($password) != "") {
                    while($fila=$consultaUsersExistentes->fetch_assoc()) {
                        if ($nickname == $fila['nickname'] AND $password == $fila['password']) {
                            $userExiste = true;
                        }
                    }
                } else {
                    die('El nombre o contraseña están vacíos');
                }
    
                if (!$userExiste) {
                    $sql = 'INSERT INTO `usuarios`.`users` (`id` ,`nickname` ,`password`, `email`, `avatar`)VALUES (NULL , "'.$nickname.'", "'.$password.'", "'.$email.'", "'.$src.'")';
                    $consulta = mysqli_query($con,$sql);
    
                    if (!$consulta) {
                        die('<br>No se ha podido realizar el insert');
                    } else {
                        echo '<br>Se realizó el insert';
                    }
                } else {
                    echo 'El usuario ya existe';
                    echo '<button >Volver atrás</button>';
    
                    echo "<form action='index.html'>";
                        echo "<button type='submit' value='Login'>Volver atrás</button>";
                    echo "</form>";
                }
            } else {
              echo "No es una imagen.";
            }
        } else {
            echo 'No se pudo mover a la carpeta uploads';
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
            <form action="login.html">
                <input type="submit" value="Volver atrás" />
            </form>
        </body>
</html>
