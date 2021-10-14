<?php
    include('db.php');

    $nickname = $_POST['nickname'];
    $password = $_POST['password'];
    
    $sql='SELECT * FROM `users` WHERE 1';
    $consulta = mysqli_query($con,$sql);
    
    $userExiste = false;

    while($fila=$consulta->fetch_assoc()) {
        if ($nickname == $fila['nickname'] AND $password == $fila['password']) {
            $userExiste = true;
        }
    }
        
    if(!$userExiste) {
        echo '<br>Nombre o Contraseña incorrectos';

    } else {
        header("Location: profile.php?user=".$nickname);
    }
?>