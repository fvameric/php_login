<?php
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
        <h1>Perfil:</h1>
        <?php
            $sql='SELECT * FROM `users` WHERE 1';
            $consulta = mysqli_query($con,$sql);

            while ($fila = $consulta->fetch_assoc())
            {
                if ($nickname == $fila['nickname'])
                {
                    echo "<div class='content'>";
                        echo "<div class='nombre'>".$fila['nickname']."</div>";
                        echo "<div class='email'>".$fila['email']."</div>";
                        echo "<br><img src='".$fila['avatar']."' >";
                    echo "</div>";
                }
            }
        ?>
        <form method="post" action="/login.html">
            <button type="submit">Cerrar sesión</button>
        </form>
        <hr>
        <h1>Eres admin, puedes ver el resto de usuarios:</h1>
        <?php
            $sql='SELECT * FROM `users` WHERE 1';
            $consulta = mysqli_query($con,$sql);

            while ($fila = $consulta->fetch_assoc())
            {
                if ($fila['admin']==0) {
                    echo "<div class='content'>";
                        echo "<div class='nombre'>".$fila['nickname']."</div>";
                        echo "<div class='email'>".$fila['email']."</div>";
                        echo "<br><img src='".$fila['avatar']."' >";
                    echo "</div>";
                }
            }
        ?>
    </div>
</body>
</html>
