<?php
    $id_user = $_POST['id_user'];

    //obtencion users
    require_once('../crud_users/crud_users.php');
    require_once('../clases/user.php');

    $crudUser = new CrudUser();
    $user = new User();
    $listaUsers = $crudUser->mostrar();
    $user = $crudUser->obtenerUser($id_user);

    //obtencion deseados
    require_once('crud_deseados.php');
    require_once('../clases/deseados.php');

    $crudDeseados = new CrudDeseados();
    $deseado = new Deseados();
    $listaDeseados = $crudDeseados->mostrar();
    $deseado = $crudDeseados->obtenerDeseado($id_user);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deseados</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<div class='header'>
        <div class='topbar'>
            <div class='header-logo'>
                <a href="index.php" class="logo">
                    <img src="../images/logo.png">
                </a>
            </div>
            <div class='header-userinfo'>
                <div class='avatar'>
                    <img src=<?php echo $user->getAvatar(); ?>>
                </div>
                <div class='header-content'>
                    <div class='nombre'>
                        <?php echo $user->getNickname(); ?>
                    </div>

                    <form method="post" action="" class="btn-carrito">
                        <button>Carrito</button>
                    </form>
                    <div class="dropdown">

                        <input id="menu-toggle" type="checkbox">
                        <label id="menu-label" for="menu-toggle">
                            <div class="triangle">
                            </div>
                        </label>
                        <ul id="collapse-menu">
                            <li><a href="login.php">Cerrar sesión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="espacio">
    </div>

    <div class="volver">
        <a href="javascript:history.go(-1)">Volver atrás</a>
    </div>

    <div class="content">
        <?php foreach($listaDeseados as $deseado) { ?>
            Id deseado: <?php echo $deseado->getId(); ?><br>
            Id user: <?php echo $deseado->getUserId(); ?><br>
            Id planta: <?php echo $deseado->getPlantaId(); ?><br><br>
        <?php } ?>
        
    </div>
</body>
</html>