<?php
    include('db.php');
    $id = $_GET['id'];
    $administrador = false;

    $sqlUserId="SELECT * FROM `users` WHERE id = '".$id."'";
    $consultaUser = mysqli_query($con, $sqlUserId);
    $filaUser = $consultaUser->fetch_assoc();

    require_once('crud_users.php');
    require_once('user.php');

    $crudUser = new CrudUser();
    $user = new User();

    $listaUsers = $crudUser->mostrar();
?>
    
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
            <?php foreach($listaUsers as $user) { ?>
                <div class="lista-usuarios">
                    <div class="lista-usuarios-avatares">
                        <img src=<?php echo $user->getAvatar() ?> class="lista-avatar">
                    </div>
                    <div class="lista-usuarios-content">
                        <div class="lista-usuarios-nombre">
                            <?php echo $user->getNombre() ?>
                        </div>
                        <div class="lista-usuarios-email">
                            <?php echo $user->getEmail(); ?>
                        </div>
                        <div class="lista-usuarios-eliminar">
                            <a href="administrar_usuario.php?id=<?php echo $user->getId(); ?>&action=e">Eliminar</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</body>
</html>
