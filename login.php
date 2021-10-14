<?php
    include('db.php');
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
    <?php
        $nickname = $_POST['nickname'];
        $password = $_POST['password'];

        $sql='SELECT * FROM `users` WHERE 1';
        $consulta = mysqli_query($con,$sql);
        while($fila=$consulta->fetch_assoc()) {
            if ($nickname == $fila['nickname'] AND $password == $fila['password']) {
                $correcto=true;
            } else {
                $correcto=false;
            }
        }

        if(!$correcto) {
            echo 'Nombre o Contraseña incorrectos';
        } else {
            header("Location: profile.php?user=".$nickname);
            exit();
        }
    ?>
    <form method="post" action="/login.html">
        <button type="submit">Volver atrás</button>
    </form>
</body>
</html>