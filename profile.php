<?php
    // Include the database configuration file
   include 'db.php';

   $nickname = $_GET['user'];


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
    <div id="content">
    <?php
        $sql='SELECT * FROM `users` WHERE 1';
        $consulta = mysqli_query($con,$sql);

        while ($fila = $consulta->fetch_assoc()) {
            if ($nickname == $fila['nickname']) {
                echo "<div class='content'>";
                    echo "Id: ".$fila['id'];
                    echo "<br>Nombre: ".$fila['nickname'];
                    echo "<br>Contraseña: ".$fila['password'];
                    echo "<br>Email: ".$fila['email'];
                    echo "<br>Avatar: <br><br>";
                    echo "<img src='uploads/".$fila['avatar']."' >";
                echo "</div>";
            }
        }
    ?>
    </div>
</body>
</html>


