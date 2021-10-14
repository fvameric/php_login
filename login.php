<?php
    include('db.php');

    $nickname = $_POST['nickname'];
    $password = $_POST['password'];
    
    $sql='SELECT * FROM `users` WHERE 1';
    $consulta = mysqli_query($con,$sql);
    
    $userExiste = false;
    $esAdmin = false;

    while($fila=$consulta->fetch_assoc()) {
        if ($nickname == $fila['nickname'] AND $password == $fila['password']) {
            $userExiste = true;
            if ($fila['admin']==1) {
                $esAdmin = true;
            }
        }
    }
        
    if(!$userExiste) {
        echo '<br>Nombre o Contraseña incorrectos';

        echo "<form action='login.html'>";
            echo "<button type='submit' value='Atrás'>Volver atrás</button>";
        echo "</form>";
    } else {
        if ($esAdmin) {
            header("Location: profileAdmin.php?user=".$nickname);
        } else {
            header("Location: profile.php?user=".$nickname);
        }
        
    }
?>