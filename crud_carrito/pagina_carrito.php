<?php
// include clases
include_once('../clases/planta.php');
include_once('../clases/user.php');

// include cruds
include_once('../crud_plantas/crud_plantas.php');

// aseguramos que no se entre en la página del carrito si no hay sesión
session_start();
if (isset($_SESSION['userSession'])) {

    // variables de sesión
    $userSession = $_SESSION['userSession'];

    // cruds
    $crudPlanta = new CrudPlanta();
    $planta = new Planta();

    // variables para calcular los precios y unidades
    $contador = 0;
    $total = 0;
    $total_unidad = 0;
    $total_cantidad = 0;

    // obtener contador del carrito
    $contadorCarrito = 0;
    if (isset($_SESSION['arrayPlantas'])) {
        $contadorCarrito = count($_SESSION['arrayPlantas']);
    }

    // obtener planta para especificarla en los enlaces de navegación
    if (isset($_SESSION['plantaid'])) {
        $id_planta = $_SESSION['plantaid'];
        $planta = $crudPlanta->obtenerPlanta($id_planta);
    }
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
    <title>Carrito</title>
    <link rel="stylesheet" href="/styles/global.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,700" />
</head>

<body>
    <div class='header'>
        <?php include_once('../html_header/navbar.php'); ?>
    </div>

    <div class="espacio"></div>

    <!--
        Si hay cosas en el carrito se mostrarán
    -->
    <?php if (!empty($_SESSION['arrayPlantas'])) { ?>
        <div class="content-wrapper">
            <div class="content">
                <div class="enlaces-navegacion">
                    <a href="../index.php">Home</a>
                    <div class="flecha-navegacion">
                        ▶
                    </div>
                    <a href="../profile.php">Perfil</a>
                    <div class="flecha-navegacion">
                        ▶
                    </div>
                    <a href="pagina_carrito.php">Carrito</a>
                </div>
                <div class="flex-contenido">
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
                                <?php
                                // array[planta][cantidad]
                                // con += $plantas[1] sumo las cantidades especificadas en total_cantidad
                                // con $plantas[0]->getPrecio() * $plantas[1] multiplico el precio de las plantas por la cantidad especificada
                                // $total += $total_unidad suma todas las multiplicaciones
                                foreach ($_SESSION['arrayPlantas'] as $key => $plantas) {
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
        </div>
    <?php } else { ?>
        <div class="no-content">
            <h2>No tienes productos en el carrito.</h2>
        </div>
    <?php } ?>

    <div class="espacio"></div>
    <?php include_once('../html_footer/footer.php'); ?>
</body>

</html>