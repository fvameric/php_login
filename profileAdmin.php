<?php
    include('db.php');
    
    $id = $_GET['id'];

    require_once('crud_users.php');
    require_once('user.php');

    $crudUser = new CrudUser();
    $user = new User();

    $listaUsers = $crudUser->mostrar();
    $user = $crudUser->obtenerUser($id);
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
            <img src=<?php echo $user->getAvatar() ?>>
        </div>
        <div class='user-header-content'>
            <div class='nombre'>
                <?php echo $user->getNickname() ?>
            </div>
            <div class='email'>
                <?php echo $user->getEmail() ?>
            </div>
            <form method="post" action="login.html" class="btn-cerrar-sesion">
                <button type="submit">Cerrar sesión</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php if ($user->getAdmin() == 1) { ?>
    <hr>
    <div class="eresAdmin">
        <h3>Eres admin, puedes ver el resto de usuarios:</h3>
    </div>
    <div class="scroll-usuarios">
        <?php foreach($listaUsers as $usuario) { ?>
            <div class="lista-usuarios">
                <div class="lista-usuarios-avatares">
                    <img src=<?php echo $usuario->getAvatar() ?> class="lista-avatar">
                </div>
                <div class="lista-usuarios-content">
                    <div class="lista-usuarios-nombre">
                        <?php echo $usuario->getNickname() ?>
                    </div>
                    <div class="lista-usuarios-email">
                        <?php echo $usuario->getEmail(); ?>
                    </div>
                </div>
                <div class="lista-usuarios-crud">
                    <div class="lista-usuarios-modificar">
                        <form method="POST" action="modificar_users.php">
                            <input type="hidden" name="id_admin" value="<?php echo $id ?>"/>
                            <input type="hidden" name="id_user" value="<?php echo $usuario->getId() ?>"/>
                            <input type="submit" id="modificar" value="Modificar"/>
                        </form>
                    </div>
                    <div class="lista-usuarios-eliminar">
                        <form method="POST" action="eliminar_users.php">
                            <input type="hidden" name="id_admin" value="<?php echo $id ?>"/>
                            <input type="hidden" name="id_user" value="<?php echo $usuario->getId() ?>"/>
                            <input type="submit" id="eliminar" value="Eliminar"/>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>

