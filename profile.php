<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
        include 'db.php';
        $id = $_GET['id'];
        $administrador = false;

        $sqlUserId="SELECT * FROM `users` WHERE id = '".$id."'";
        $consultaUser = mysqli_query($con, $sqlUserId);
        $filaUser = $consultaUser->fetch_assoc();
    ?>

    <h1>Perfil</h1>
    <div class='user-header'>
        <div class='nombre'>
            <h3><?php echo $filaUser['nickname']; ?></h3>
        </div>
        <div class='email'>
            <?php echo $filaUser['email']; ?>
        </div>
        <div class='avatar'>
            <img src=<?php echo $filaUser['avatar']; ?>>
        </div>
        <form method="post" action="login.html">
            <button type="submit">Cerrar sesión</button>
        </form>
    </div>

    <?php if ($filaUser['admin'] == 1) { ?>
    <hr>
    <h1>Eres admin, puedes ver el resto de usuarios:</h1>

    <div class="scroll-usuarios">
        <?php
            $sqlAllUsers="SELECT * FROM `users` WHERE 1";
            $consultaAllUsers = mysqli_query($con,$sqlAllUsers);
            while ($filaAllUsers = $consultaAllUsers->fetch_assoc()) {
                if ($filaAllUsers['admin']==0) { ?>
                    <div class="lista-users">
                        <ul class="lista">
                            <li class="lista-item">
                                <div>
                                    <img src=<?php echo $filaAllUsers['avatar']; ?> class="lista-avatar">
                                </div>
                                <div class="lista-item-contenido">
                                    <h5><?php echo $filaAllUsers['nickname']; ?></h5>
                                    <h6><?php echo $filaAllUsers['email']; ?></h6>
                                </div>    
                            </li>
                        </ul>
                    </div>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    </div>
</body>
</html>