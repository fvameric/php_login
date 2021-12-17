<?php
// include clases
include_once('/clases/user.php');
include_once('/clases/planta.php');
include_once('/clases/deseados.php');

// include cruds
include_once('/crud_plantas/crud_plantas.php');
include_once('/crud_deseados/crud_deseados.php');

session_start();
if (isset($_SESSION['userSession'])) {

    // variables de sesión
    $userSession = $_SESSION['userSession'];

    // cruds
    $crudDeseados = new CrudDeseados();

    // obtención de elementos de la BD
    $contadorDeseados = 0;
    $listaDeseados = $crudDeseados->obtenerDeseadosPorLogin($userSession);
    $contadorDeseados = count($listaDeseados);

    // obtener contador del carrito
    $contadorCarrito = 0;
    if (isset($_SESSION['arrayPlantas'])) {
        $contadorCarrito = count($_SESSION['arrayPlantas']);
    }

    // plantas visitadas recientemente
    if (isset($_SESSION['plantasVisitadas'])) {
        $plantasRecientes = $_SESSION['plantasVisitadas'];
    }
}

// también se quiere que se muestre el listado de plantas
// para usuarios que no se han registrado o iniciado sesión
$crudPlanta = new CrudPlanta();
$listaPlantas = $crudPlanta->obtenerListaPlantas();

// Botones de ordenar por categorias
if (isset($_GET['categoria'])) {
    $listaPlantas = $crudPlanta->ordenarPorCategoria($_GET['categoria'], $listaPlantas);
    $strCategoria = $crudPlanta->stringCategoria($_GET['categoria']);
}

// Botones de ordenar por nombre, precio...
if (isset($_POST['sort'])) {
    if ($_POST['sort'] == 1) {
        $listaPlantas = $crudPlanta->ordenarPorPrecio($listaPlantas);
    } else if ($_POST['sort'] == 2) {
        $listaPlantas = $crudPlanta->ordenarPorNombre($listaPlantas);
    } else if ($_POST['sort'] == 3) {
        $listaPlantas = $crudPlanta->ordenarPorDeseados($listaPlantas, $listaDeseados);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if (isset($_GET['categoria'])) { ?>
        <title>Tienda > <?php echo $strCategoria; ?></title>
    <?php } else { ?>
        <title>Tienda</title>
    <?php } ?>
    <link rel="stylesheet" href="/styles/global.css">
    <link rel="stylesheet" href="/styles/index.css">
    <link rel="stylesheet" href="/styles/sidepanel.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,700" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.8.0/gsap.min.js"></script>
    <script src="/buscador.js"></script>
</head>

<body>
    <div class='header'>
        <?php include_once('/html_header/navbar.php'); ?>
    </div>

    <div class="espacio"></div>

    <div class="content-wrapper">
        <?php if (!empty($plantasRecientes)) { ?>
            <div class="content">
                <h3>Plantas visitadas recientemente:</h3>
                <div class="scroll-plantas">
                    <?php foreach ($plantasRecientes as $reciente) { ?>
                        <div class="plantas-recientes">
                            <form method="GET" action="ver_detalle.php">
                                <input type="hidden" name="id_planta" value="<?php echo $reciente->getId(); ?>" />
                                <button type="submit" class="carta-reciente">
                                    <div class="fotos-recientes">
                                        <img src=<?php echo $reciente->getFoto(); ?>>
                                    </div>
                                    <div class="nombres-recientes">
                                        <?php echo $reciente->getNombre(); ?>
                                    </div>
                                </button>
                            </form>
                        </div>
                    <?php } ?>

                </div>
            </div>
        <?php } ?>
    </div>

    <div class="content-wrapper">
        <div class="content">
            <div class="enlaces-navegacion">
                <a href="index.php">Home</a>
                <?php if (isset($_GET['categoria'])) { ?>
                    <div class="flecha-navegacion">
                        ▶
                    </div>
                    <a href=""><?php echo $strCategoria; ?></a>
                <?php } ?>
            </div>
            <div class="sidepanel-container">
                <?php include_once('/html_content/sidepanel.php'); ?>
            </div>
            <div class="scroll-plantas">
                <?php foreach ($listaPlantas as $plantas) { ?>
                    <div class="lista-plantas">
                        <div class="carta">
                            <div class="lista-plantas-fotos">
                                <img src=<?php echo $plantas->getFoto(); ?>>
                            </div>
                            <div class="lista-plantas-content">
                                <div class="lista-plantas-nombre">
                                    <?php echo $plantas->getNombre(); ?>
                                </div>
                                <div class="lista-plantas-gestionCarrito">
                                    <div class="lista-plantas-precio">
                                        <?php echo $plantas->getPrecio(); ?> €
                                    </div>
                                    <!--
                                        Si hay sesión iniciada, se muestra
                                        el botón del carrito
                                    -->
                                    <?php if (isset($_SESSION['userSession'])) { ?>
                                        <form method="POST" action="/crud_carrito/gestion_carrito.php" class="lista-plantas-addcarrito">
                                            <input type="hidden" name="plant" value="<?php echo $plantas->getId(); ?>" />
                                            <input type="number" min="1" value="1" name="cantidad" class="cantidadCarrito" />
                                            <input type="submit" value="&#128722;" />
                                        </form>
                                    <?php } ?>
                                </div>
                                <?php if (isset($_SESSION['userSession'])) { ?>
                                    <div class="agregar-deseados">
                                        <?php
                                        // mediante la id de la planta y la id del usuario logueado,
                                        // compruebo si la planta ha sido deseada o no
                                        $idDeseado = $crudDeseados->obtenerDeseado($plantas->getId(), $userSession->getId());

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
                                                    <input type="hidden" name="id_planta" value="<?php echo $plantas->getId(); ?>" />
                                                    <button type="submit" name="add">☆</button>
                                                </form>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="ver-detalles-planta">
                                <form method="GET" action="ver_detalle.php">
                                    <input type="hidden" name="id_planta" value="<?php echo $plantas->getId(); ?>" />
                                    <input type="submit" id="detalles" value="Ver detalle" />
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="espacio"></div>

    <?php include_once('/html_footer/footer.php'); ?>
</body>

</html>