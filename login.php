<?php
    include('db.php');

    $nickname = $_POST['nickname'];
    $password = $_POST['password'];
    
    $userExiste = false;

    $sql="SELECT * FROM `users` WHERE nickname = '".$nickname."'";
    $consulta = mysqli_query($con,$sql);
    $fila=$consulta->fetch_assoc();

    if ($nickname == $fila['nickname'] AND $password == $fila['password']) {
        header("Location: profile.php?id=".$fila['id']);
    } else {
        echo '<br>Nombre o Contraseña incorrectos';

        echo "<form action='login.html'>";
            echo "<button type='submit' value='Atrás'>Volver atrás</button>";
        echo "</form>";
    }
?>