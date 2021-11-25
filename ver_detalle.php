<?php
include_once('/conexion/db.php');

session_start();
if (isset($_SESSION['sessionID'])) {
    $_SESSION['ubicacion'] = 'detalle';

    $id_admin = $_SESSION['sessionID'];

    //obtencion users
    include_once('/crud_users/crud_users.php');
    include_once('/clases/user.php');

    $crudUser = new CrudUser();
    $user = new User();
    $listaUsers = $crudUser->obtenerListaUsuarios();
    $user = $crudUser->obtenerUserPorId($id_admin);

    //obtencion deseados
    include_once('/crud_deseados/crud_deseados.php');
    include_once('/clases/deseados.php');

    $crudDeseados = new CrudDeseados();
    $deseado = new Deseados();

    if (!isset($listaDeseados)) {
        $listaDeseados = $crudDeseados->obtenerListaDeseados();
    }
}

if (isset($_GET['id_planta'])) {
    $id_planta = $_GET['id_planta'];
    $_SESSION['plantaid'] = $id_planta;

    //obtencion plantas
    include_once('/crud_plantas/crud_plantas.php');
    include_once('/clases/planta.php');

    $crudPlanta = new CrudPlanta();
    $planta = new Planta();
    $listaPlantas = $crudPlanta->obtenerListaPlantas();
    $planta = $crudPlanta->obtenerPlantaPorId($id_planta);

    $newPlanta;

    foreach ($listaPlantas as $planta) {
        if ($id_planta == $planta->getId()) {
            $newPlanta = $planta;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $newPlanta->getNombre(); ?></title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php if (isset($_SESSION['sessionID'])) { ?>
        <div class='header'>
            <div class='topbar'>
                <div class='header-userinfo'>
                    <?php if ($_SESSION['isAdmin'] == 0) { ?>
                        <a href="profile.php" class="userinfo">
                            <div class='avatar'>
                                <img src=<?php echo $user->getAvatar(); ?>>
                            </div>
                            <div class='nombre'>
                                <?php echo $user->getNickname(); ?>
                            </div>
                        </a>
                    <?php } else { ?>
                        <a href="profileAdmin.php" class="userinfo">
                            <div class='avatar'>
                                <img src=<?php echo $user->getAvatar(); ?>>
                            </div>
                            <div class='nombre'>
                                <?php echo $user->getNickname(); ?>
                            </div>
                        </a>
                    <?php } ?>

                    <div class='header-content'>
                        <li><a href="profileAdmin.php">Perfil</a></li>
                        <li><a href="/crud_deseados/pagina_deseados.php">Deseados</a></li>
                        <li><a href="cierre_sesion.php">Cerrar sesión</a></li>

                        <form method="POST" action="/crud_carrito/pagina_carrito.php" class="btn-carrito">
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
                    <a class="btn-registrarse" href="registro.html">Regístrate</a>
                    <a class="btn-iniciarsesion" href="login.php">Inicia sesión</a>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="espacio">
    </div>

    <div class="enlaces-navegacion">
        <a href="index.php">Home</a>
        <div class="flecha-navegacion">
            ▶
        </div>
        <a href=""><?php echo $newPlanta->getNombre(); ?></a>
    </div>

    <div class="content">
        <div class="scroll-plantas">
            <div class="lista-plantas">
                <div class="carta">
                    <div class="lista-plantas-fotos">
                        <img src="<?php echo $newPlanta->getFoto(); ?>" />
                    </div>
                    <div class="lista-plantas-content">
                        <div class="lista-plantas-nombre">
                            <?php echo $newPlanta->getNombre(); ?>
                        </div>
                        <div class="lista-plantas-precio">
                            <?php echo $newPlanta->getPrecio(); ?> €
                        </div>
                        <div>
                            <form method="POST" action="../crud_carrito/gestion_carrito.php">
                                <input type="hidden" name="plant" value="<?php echo $newPlanta->getId(); ?>" />
                                <input type="submit" value="Añadir al carrito" />
                            </form>
                        </div>
                        <div class="agregar-deseados">
                            <?php
                            $idDeseado = $crudDeseados->obtenerDeseadoPorId($newPlanta->getId(), $_SESSION['sessionID']);

                            if ($idDeseado != null) { ?>
                                <div class="quitar-deseado">
                                    <form method="POST" action="/crud_deseados/gestion_eliminacion.php" class="btn-quitar-deseado">
                                        <input type="hidden" name="id_deseado" value="<?php echo $idDeseado ?>" />
                                        <button type="submit" name="quitarDeseado">★</button>
                                    </form>
                                </div>
                            <?php } else { ?>
                                <div class="agregar-deseado">
                                    <form method="POST" action="/crud_deseados/gestion_creacion.php" class="btn-agregar-deseado">
                                        <input type="hidden" name="id_planta" value="<?php echo $newPlanta->getId() ?>" />
                                        <input type="hidden" name="id_user" value="<?php echo $id ?>" />
                                        <button type="submit" name="add">☆</button>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>