<?php
//include_once('../conexion/db.php');

    //obtencion users
    include_once('../crud_users/crud_users.php');
    include_once('../clases/user.php');

session_start();
if (isset($_SESSION['userSession'])) {
    $logueado = true;
    //$id_user = $_SESSION['sessionID'];
    $userSession = $_SESSION['userSession'];

    $crudUser = new CrudUser();
    //$user = new User();
    $listaUsers = $crudUser->obtenerListaUsuarios();
    //$user = $crudUser->obtenerUser($id_user);
} else {
    $logueado = false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear nuevo usuario</title>
    <link rel="stylesheet" href="../styles.css">
</head>

<body>
    <div class='header'>
        <div class='topbar'>
            <div class="menu-logo">
                <a href="..index.php" class="logo">
                    <img src="../images/logo.png" />
                </a>
            </div>
            <?php if ($logueado) { ?>
                <div class='header-userinfo'>
                    <?php if ($userSession->getAdmin() == 0) { ?>
                        <a href="../profile.php" class="userinfo">
                            <div class='avatar'>
                                <img src=<?php echo $userSession->getAvatar(); ?>>
                            </div>
                            <div class='nombre'>
                                <?php echo $userSession->getNickname(); ?>
                            </div>
                        </a>
                    <?php } else { ?>
                        <a href="../profileAdmin.php" class="userinfo">
                            <div class='avatar'>
                                <img src=<?php echo $userSession->getAvatar(); ?>>
                            </div>
                            <div class='nombre'>
                                <?php echo $userSession->getNickname(); ?>
                            </div>
                        </a>
                    <?php } ?>

                    <div class='header-content'>
                        <li><a href="../crud_deseados/pagina_deseados.php">Deseados</a></li>
                        <li><a href="../identificacion/cierre_sesion.php">Cerrar sesión</a></li>

                        <form method="post" action="../crud_carrito/pagina_carrito.php" class="btn-carrito">
                            <button>&#128722;</button>
                        </form>
                    </div>
                    <?php
                    if (isset($_SESSION['arrayPlantas'])) {
                        if (count($_SESSION['arrayPlantas']) > 0) { ?>
                            <span class="contadorCarrito"><?php echo count($_SESSION['arrayPlantas']); ?></span>
                        <?php } ?>
                    <?php } else {
                        $_SESSION['arrayPlantas'] = [];
                    } ?>
                </div>
            <?php } else { ?>
                <div class='header'>
                    <div class='topbar'>
                        <div class='header-logo'>
                            <a href="index.php" class="logo">
                                <img src="images/logo.png">
                            </a>
                        </div>
                        <div class='menu-user'>
                            <a class="btn-registrarse" href="../identificacion/registro.html">Regístrate</a>
                            <a class="btn-iniciarsesion" href="../identificacion/login.php">Inicia sesión</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="espacio">
    </div>
    <div class="enlaces-navegacion">
        <a href="../index.php">Home</a>
        <div class="flecha-navegacion">
            ▶
        </div>
        <a href="../profileAdmin.php">Perfil</a>
        <div class="flecha-navegacion">
            ▶
        </div>
        <a href="pagina_creacion.php">Creación de usuarios</a>
    </div>

    <div class="content">
        <div class="crear-nuevo-usuario">
            <h2>Crear usuario nuevo:</h2>

            <form id="formRegistro" action="../identificacion/registro.php" method="POST" enctype="multipart/form-data">
                <label>Avatar</label><br>
                <input type="file" name="file"><br><br>

                <label>Email</label><br>
                <input type="email" name="email"><br><br>

                <label>Nombre de usuario</label><br>
                <input type="text" name="nickname"><br><br>

                <label>Contraseña</label><br>
                <input type="password" name="password"><br><br>

                <button type="submit" name="submit" value="Registrarse">Registrar</button>
            </form>
        </div>
    </div>
</body>

</html>