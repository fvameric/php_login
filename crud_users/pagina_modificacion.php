<?php
include_once('crud_users.php');
include_once('../clases/user.php');

$crud = new CrudUser();
//$user = new User();

session_start();
if (isset($_SESSION['userSession'])) {
    $logueado = true;
    //$id_user = $_SESSION['sessionID'];
    $userSession = $_SESSION['userSession'];

    //obtencion users
    include_once('../crud_users/crud_users.php');
    include_once('../clases/user.php');

    $crudUser = new CrudUser();
    //$user = new User();
    $listaUsers = $crudUser->obtenerListaUsuarios();
    //$user = $crudUser->obtenerUser($id_user);

    if (isset($_POST['id_usuario_modificar'])) {
        $usuario_modificar = $crud->obtenerUser($_POST['id_usuario_modificar']);
    }
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
    <title>Modificar usuario</title>
    <link rel="stylesheet" href="../styles.css">
</head>

<body>
    <div class='header'>
        <div class='topbar'>
            <div class="menu-logo">
                <a href="../index.php" class="logo">
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
                        <?php
                        if (isset($_SESSION['arrayPlantas'])) {
                            if (count($_SESSION['arrayPlantas']) > 0) { ?>
                                <span class="contadorCarrito"><?php echo count($_SESSION['arrayPlantas']); ?></span>
                            <?php } ?>
                        <?php } else {
                            $_SESSION['arrayPlantas'] = [];
                        } ?>
                    </div>
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
                            <a class="btn-registrarse" href="/identificacion/registro.html">Regístrate</a>
                            <a class="btn-iniciarsesion" href="/identificacion/login.php">Inicia sesión</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="menu-navegacion">
            <form method="GET" action="" class="botones-menu">
                <div class="caja1">
                    <button type="submit" name="categoria" class="button" value="1">Aeonium</button>
                </div>
                <div class="caja2">
                    <button type="submit" name="categoria" class="button" value="2">Cotyledon</button>
                </div>
                <div class="caja3">
                    <button type="submit" name="categoria" class="button" value="3">Crassula</button>
                </div>
                <div class="caja4">
                    <button type="submit" name="categoria" class="button" value="4">Echeveria</button>
                </div>
                <div class="caja5">
                    <button type="submit" name="categoria" class="button" value="5">Euphorbia</button>
                </div>
                <div class="caja6">
                    <button type="submit" name="categoria" class="button" value="6">Haworthia</button>
                </div>
                <div class="caja7">
                    <button type="submit" name="categoria" class="button" value="7">Senecio</button>
                </div>
            </form>

            <form method="POST" action="" class="buscador">
                <input type="text" id="myInput" class="barra-buscador" onkeyup="myFunction()" placeholder="Buscador">
            </form>
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
        <a href="pagina_modificacion.php">Modificación de usuarios</a>
    </div>

    <div class="content-wrapper">
        <div class="content">
            <form action='/crud_users/gestion_modificacion.php' method='POST' enctype="multipart/form-data">
                <div class='modificar-user'>
                    <div class='modificar-avatar'>
                        <img src=<?php echo $usuario_modificar->getAvatar() ?>>
                        <input type="file" name='file'>
                    </div>
                    <div class='modificar-content'>
                        <div class='modificar-content-nombre'>
                            <label>Nickname:</label>
                            <input type="text" name="nickname" value="<?php echo $usuario_modificar->getNickname() ?>">
                        </div>
                        <div class='modificar-content-email'>
                            <label>Email:</label>
                            <input type="email" name="email" value="<?php echo $usuario_modificar->getEmail() ?>">
                        </div>
                    </div>
                    <input type='hidden' name='id_user_modificar' value='<?php echo $usuario_modificar->getId() ?>'>
                    <input type='hidden' name='actualizar' value='actualizar'>
                </div>
                <div class='aceptar-modificaciones'>
                    <input type='submit' name="aceptarmodif" value='Aceptar modificaciones'>
                </div>
            </form>
        </div>
    </div>
</body>

</html>