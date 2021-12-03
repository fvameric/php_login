<?php
include_once('/conexion/db.php');

//obtencion users
include_once('/crud_users/crud_users.php');
include_once('/clases/user.php');

//obtencion deseados
include_once('/crud_deseados/crud_deseados.php');
include_once('/clases/deseados.php');

//obtencion plantas
include_once('/crud_plantas/crud_plantas.php');
include_once('/clases/planta.php');
session_start();
if (isset($_SESSION['userSession'])) {
    $_SESSION['ubicacion'] = 'detalle';

    //$id_admin = $_SESSION['sessionID'];
    $userSession = $_SESSION['userSession'];

    $crudUser = new CrudUser();
    //$user = new User();
    $listaUsers = $crudUser->obtenerListaUsuarios();
    //$user = $crudUser->obtenerUser($id_admin);

    $crudDeseados = new CrudDeseados();
    $deseado = new Deseados();

    if (!isset($listaDeseados)) {
        $listaDeseados = $crudDeseados->obtenerListaDeseados();
    }
}

if (isset($_GET['id_planta'])) {
    $logueado = true;
    $id_planta = $_GET['id_planta'];
    $_SESSION['plantaid'] = $id_planta;



    $crudPlanta = new CrudPlanta();
    $planta = new Planta();
    $listaPlantas = $crudPlanta->obtenerListaPlantas();
    $planta = $crudPlanta->obtenerPlanta($id_planta);

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
    <?php if (isset($_SESSION['userSession'])) { ?>
        <div class='header'>
            <div class='topbar'>
                <div class='header-userinfo'>
                    <?php if ($userSession->getAdmin() == 0) { ?>
                        <a href="profile.php" class="userinfo">
                            <div class='avatar'>
                                <img src=<?php echo $userSession->getAvatar(); ?>>
                            </div>
                            <div class='nombre'>
                                <?php echo $userSession->getNickname(); ?>
                            </div>
                        </a>
                    <?php } else { ?>
                        <a href="profileAdmin.php" class="userinfo">
                            <div class='avatar'>
                                <img src=<?php echo $userSession->getAvatar(); ?>>
                            </div>
                            <div class='nombre'>
                                <?php echo $userSession->getNickname(); ?>
                            </div>
                        </a>
                    <?php } ?>

                    <div class='header-content'>
                        <li><a href="/crud_deseados/pagina_deseados.php">Deseados</a></li>
                        <li><a href="/identificacion/cierre_sesion.php">Cerrar sesión</a></li>

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
        <div class="detalle-planta">
            <div class="lista-plantas-fotos">
                <img src="<?php echo $newPlanta->getFoto(); ?>" />
            </div>
            <?php if ($logueado) { ?>
                <div class="agregar-deseados">
                    <?php
                    $idDeseado = $crudDeseados->obtenerDeseado($newPlanta->getId(), $userSession->getId());

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
            <?php } ?>
            <div class="planta-info">
                <div class="planta-nombre">
                    <?php echo $newPlanta->getNombre(); ?>
                </div>

                <div class="planta-nombre">
                    <?php echo $newPlanta->getDescripcion(); ?>
                </div>


                <?php echo $newPlanta->getPrecio(); ?> €
                <?php if ($logueado) { ?>
                    <form method="POST" action="../crud_carrito/gestion_carrito.php" class="lista-plantas-addcarrito">
                        <input type="hidden" name="plant" value="<?php echo $newPlanta->getId(); ?>" />
                        <input type="number" min="1" value="1" name="cantidad" class="cantidadCarrito" />
                        <input type="submit" value="&#128722;" />
                    </form>
                <?php } ?>
            </div>
        </div>
        <?php if ($logueado && $userSession->getAdmin() == 1) { ?>
            <div class="lista-plantas-crud">
                <div class="lista-plantas-modificar">
                    <form method="POST" action="/crud_plantas/pagina_modificacion.php">
                        <input type="hidden" name="id_planta" value="<?php echo $newPlanta->getId() ?>" />
                        <input type="submit" id="modificar" value="Modificar" />
                    </form>
                </div>
                <div class="lista-plantas-eliminar">
                    <form method="POST" action="/crud_plantas/gestion_eliminacion.php">
                        <input type="hidden" name="id_planta" value="<?php echo $newPlanta->getId() ?>" />
                        <input type="submit" id="eliminar" value="Eliminar" />
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
</body>

</html>