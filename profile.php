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
    <div class='user-header'>
        <div class='avatar'>
            <img src=<?php echo $filaUser['avatar']; ?>>
        </div>
        <div class='user-header-content'>
            <div class='nombre'>
                <?php echo $filaUser['nickname']; ?>
            </div>
            <div class='email'>
                <?php echo $filaUser['email']; ?>
            </div>
            <form method="post" action="login.html" class="btn-cerrar-sesion">
                <button type="submit">Cerrar sesión</button>
            </form>
        </div>
    </div>

    <?php if ($filaUser['admin'] == 1) { ?> <!--inicio si el usuario que ha iniciado sesión es admin  -->
    <hr>
    <div class="eresAdmin">
        <h3>Eres admin, puedes ver el resto de usuarios:</h3>
    </div>
    <div class="scroll-usuarios">
        <?php
            $sqlAllUsers="SELECT * FROM `users` WHERE 1";
            $consultaAllUsers = mysqli_query($con,$sqlAllUsers);
            while ($filaAllUsers = $consultaAllUsers->fetch_assoc()) { // inicio while usuarios
                if ($filaAllUsers['admin']==0) { ?> <!--inicio if usuarios normales -->
                    <div class="lista-usuarios">
                        <div class="lista-usuarios-avatares">
                            <img src=<?php echo $filaAllUsers['avatar']; ?> class="lista-avatar">
                        </div>
                        <div class="lista-usuarios-content">
                            <div class="lista-usuarios-nombre">
                                <?php echo $filaAllUsers['nickname']; ?>
                            </div>
                            <div class="lista-usuarios-email">
                                <?php echo $filaAllUsers['email']; ?>
                            </div>
                        </div>
                    </div>
                <?php } ?> <!--cierre if usuarios normales -->
            <?php } ?> <!--cierre while usuarios -->
        <?php } ?> <!--cierre si el usuario que ha iniciado sesión es admin  -->
    </div>

    <div class="listaProductos">

    </div>
</body>
</html>