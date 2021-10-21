<?php
    include('db.php');

    $id = $_GET['id'];
    
    require_once('crud_users.php');
    require_once('user.php');

    $crudUser = new CrudUser();
    $filaUser = $crudUser->obtenerUser($id);
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
            <img src=<?php echo $filaUser->getAvatar(); ?>>
        </div>
        <div class='user-header-content'>
            <div class='nombre'>
                <?php echo $filaUser->getNickname(); ?>
            </div>
            <div class='email'>
                <?php echo $filaUser->getEmail(); ?>
            </div>
            <form method="post" action="login.html" class="btn-cerrar-sesion">
                <button type="submit">Cerrar sesión</button>
            </form>
        </div>
    </div>
</body>
</html>
