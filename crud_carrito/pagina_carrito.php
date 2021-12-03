<?php
include_once '../conexion/db.php';

//obtencion plantas
include_once('../clases/planta.php');
include_once('../crud_plantas/crud_plantas.php');

//obtencion users
include_once('../crud_users/crud_users.php');
include_once('../clases/user.php');

//obtencion plantas
include_once('../crud_plantas/crud_plantas.php');
include_once('../clases/planta.php');

session_start();
if (isset($_SESSION['userSession'])) {
    $ubicacion = $_SESSION['ubicacion'];
    //$id_user = $_SESSION['sessionID'];
    $userSession = $_SESSION['userSession'];

    $crudUser = new CrudUser();
    //$user = new User();
    //$user = $crudUser->obtenerUser($id_user);

    if (isset($_SESSION['plantaid'])) {
        $id_planta = $_SESSION['plantaid'];
        
        $crudPlanta = new CrudPlanta();
        $planta = new Planta();
        $planta = $crudPlanta->obtenerPlanta($id_planta);
    }

    $contador = 0;
    $total = 0;
    $total_unidad = 0;
    $total_cantidad = 0;
} else {
    header("Location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
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

                    <form method="post" action="" class="btn-carrito">
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

    <div class="espacio">
    </div>

    <div class="enlaces-navegacion">

        <?php if ($ubicacion == "detalle") { ?>
            <a href="../index.php">Home</a>
            <div class="flecha-navegacion">
                ▶
            </div>
            <a href="../ver_detalle.php?id_planta=<?php echo $id_planta; ?>"><?php echo $planta->getNombre(); ?></a>
            <div class="flecha-navegacion">
                ▶
            </div>
        <?php } else if ($ubicacion == "perfilAdmin") { ?>
            <a href="../index.php">Home</a>
            <div class="flecha-navegacion">
                ▶
            </div>

            <a href="../profileAdmin.php">Perfil</a>

            <div class="flecha-navegacion">
                ▶
            </div>
        <?php } else if ($ubicacion == "perfil") { ?>
            <a href="../index.php">Home</a>
            <div class="flecha-navegacion">
                ▶
            </div>

            <a href="../profile.php">Perfil</a>

            <div class="flecha-navegacion">
                ▶
            </div>
        <?php } else if ($ubicacion == "home") { ?>
            <a href="../index.php">Home</a>
            <div class="flecha-navegacion">
                ▶
            </div>
        <?php } ?>
        <a href="pagina_carrito.php">Carrito</a>
    </div>
    <?php if (!empty($_SESSION['arrayPlantas'])) { ?>
        <div class="content-wrapper">
            <div class="content-carrito">
                <div id="shopping-cart">
                    <div class="vaciar-carrito">
                        <form method="POST" action="limpiar_carrito.php">
                            <input type="submit" name="vaciar-carrito" value="Vaciar carrito" />
                        </form>
                    </div>

                    <table class="tbl-cart" cellpadding="10" cellspacing="1">
                        <tbody>
                            <tr>
                                <th style="text-align:left;">Nombre</th>
                                <th style="text-align:right;" width="5%">Cantidad</th>
                                <th style="text-align:right;" width="10%">Precio unidad</th>
                                <th style="text-align:right;" width="10%">Precio total</th>
                                <th style="text-align:center;" width="5%">Eliminar</th>
                            </tr>
                            <?php foreach ($_SESSION['arrayPlantas'] as $key => $plantas) {
                                $total_cantidad += $plantas[1];
                                $total_unidad = $plantas[0]->getPrecio() * $plantas[1];
                                $total += $total_unidad;
                            ?>
                                <tr>
                                    <td><img src="<?php echo $plantas[0]->getFoto(); ?>" class="cart-item-image" /><?php echo $plantas[0]->getNombre(); ?></td>
                                    <td style="text-align:right;"><?php echo $plantas[1]; ?></td>
                                    <td style="text-align:right;"><?php echo "€ " . $plantas[0]->getPrecio(); ?></td>
                                    <td style="text-align:right;"><?php echo "€ " . number_format($total_unidad, 2); ?></td>
                                    <td style="text-align:center;">
                                        <form method="POST" action="gestion_eliminacion.php">
                                            <input type="hidden" name="index" value="<?php echo $key ?>" />
                                            <input type="submit" id="eliminar" value="🗑️" />
                                        </form>
                                    </td>
                                </tr>

                            <?php } ?>

                            <tr>
                                <td colspan="1" align="right">Total:</td>
                                <td align="right"><?php echo $total_cantidad; ?></td>
                                <td align="right" colspan="2"><strong><?php echo "€ " . number_format($total, 2); ?></strong></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="no-content">
            <h2>No tienes productos en el carrito.</h2>
        </div>
    <?php } ?>
</body>

</html>