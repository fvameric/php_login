<?php
// include clases
include_once('/clases/user.php');
include_once('/clases/planta.php');
include_once('/clases/deseados.php');

// include cruds
include_once('/crud_users/crud_users.php');
include_once('/crud_plantas/crud_plantas.php');
include_once('/crud_deseados/crud_deseados.php');

// también se quiere que se muestre el detalle de la planta
// para usuarios que no se han registrado o iniciado sesión
$crudPlanta = new CrudPlanta();

// mediante la planta enviada, obtenemos su información
// y creamos un objeto planta
// se podría pasar directamente el objeto, pero
// en este caso quiero ver en el enlace el código
if (isset($_GET['id_planta'])) {

    // variables de sesión
    $_SESSION['plantaid'] = $_GET['id_planta'];

    // crud
    $planta = new Planta();

    // obtener la planta de la bd
    $planta = $crudPlanta->obtenerPlanta($_GET['id_planta']);

    //obtener el nombre de la categoria en string
    $strCategoria = $crudPlanta->stringCategoria($planta->getCategoria());
}

session_start();
if (isset($_SESSION['userSession'])) {

    // variables de sesión
    $userSession = $_SESSION['userSession'];

    // cruds
    $crudUser = new CrudUser();
    $crudDeseados = new CrudDeseados();

    // obtención de elementos de la BD
    if (!isset($listaUsers)) {
        $listaUsers = $crudUser->obtenerListaUsuarios();
    }
    if (!isset($listaDeseados)) {
        $listaDeseados = $crudDeseados->obtenerListaDeseados();
    }

    // obtener contador del carrito
    $contadorCarrito = 0;
    if (isset($_SESSION['arrayPlantas'])) {
        $contadorCarrito = count($_SESSION['arrayPlantas']);
    }

    // se agrega la planta visitada
    // maximo 5 plantas
    if (isset($_SESSION['plantasVisitadas'])) {
        if (array_search($planta, $_SESSION['plantasVisitadas']) === false) {
            if (count($_SESSION['plantasVisitadas']) <= 4) {
                array_push($_SESSION['plantasVisitadas'], $planta);
            } else if(count($_SESSION['plantasVisitadas']) > 4) {
                array_shift($_SESSION['plantasVisitadas']);
                array_push($_SESSION['plantasVisitadas'], $planta);
            }
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
    <title><?php echo $planta->getNombre(); ?></title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,700" />
</head>

<body>
    <div class='header'>
        <?php include_once('/html_header/navbar.php'); ?>
    </div>

    </div>

    <div class="espacio">
    </div>

    <div class="enlaces-navegacion">
        <a href="index.php">Home</a>
        <div class="flecha-navegacion">
            ▶
        </div>
        <a href=""><?php echo $planta->getNombre(); ?></a>
    </div>

    <div class="content">
        <div class="detalle-planta">
            <div class="lista-plantas-fotos">
                <img src="<?php echo $planta->getFoto(); ?>" />
            </div>
            <?php if (isset($_SESSION['userSession'])) { ?>
                <div class="agregar-deseados">
                    <?php
                    $idDeseado = $crudDeseados->obtenerDeseado($planta->getId(), $userSession->getId());

                    if ($idDeseado != null) { ?>
                        <div class="quitar-deseado">
                            <form method="POST" action="/crud_deseados/gestion_eliminacion.php" class="btn-quitar-deseado">
                                <input type="hidden" name="id_deseado" value="<?php echo $idDeseado->getId(); ?>" />
                                <button type="submit" name="quitarDeseado">★</button>
                            </form>
                        </div>
                    <?php } else { ?>
                        <div class="agregar-deseado">
                            <form method="POST" action="/crud_deseados/gestion_creacion.php" class="btn-agregar-deseado">
                                <input type="hidden" name="id_planta" value="<?php echo $_GET['id_planta']; ?>" />
                                <button type="submit" name="add">☆</button>
                            </form>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
            <div class="planta-info">
                <div class="planta-nombre">
                    <?php echo $planta->getNombre(); ?>
                </div>

                <div class="planta-nombre">
                    <?php echo $planta->getDescripcion(); ?>
                </div>
                <?php echo $planta->getPrecio(); ?> €
                <br>
                Categoria: <?php echo $strCategoria; ?>
                <?php if (isset($_SESSION['userSession'])) { ?>
                    <form method="POST" action="../crud_carrito/gestion_carrito.php" class="lista-plantas-addcarrito">
                        <input type="hidden" name="plant" value="<?php echo $planta->getId(); ?>" />
                        <input type="number" min="1" value="1" name="cantidad" class="cantidadCarrito" />
                        <input type="submit" value="&#128722;" />
                    </form>
                <?php } ?>
            </div>
        </div>
        <!--
            Si se ha iniciado sesión y además es admin,
            mostramos el crud para modificar o quitar plantas
        -->
        <?php if (isset($_SESSION['userSession']) && $userSession->getAdmin() == 1) { ?>
            <div class="lista-plantas-crud">
                <div class="lista-plantas-modificar">
                    <form method="POST" action="/crud_plantas/pagina_modificacion.php">
                        <input type="hidden" name="id_planta" value="<?php echo $planta->getId(); ?>" />
                        <input type="submit" id="modificar" value="Modificar" />
                    </form>
                </div>
                <div class="lista-plantas-eliminar">
                    <form method="POST" action="/crud_plantas/gestion_eliminacion.php">
                        <input type="hidden" name="id_planta" value="<?php echo $planta->getId(); ?>" />
                        <input type="submit" id="eliminar" value="Eliminar" />
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="espacio"></div>
    
    <?php include_once('/html_footer/footer.php'); ?>
</body>

</html>