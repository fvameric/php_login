<?php
include('/conexion/db.php');

session_start();
if (isset($_SESSION['sessionID'])) {
    $logueado = true;
    $_SESSION['ubicacion'] = 'perfil';
    $id_user = $_SESSION['sessionID'];

    //obtencion users
    require_once('/crud_users/crud_users.php');
    require_once('/clases/user.php');

    $crudUser = new CrudUser();
    $user = new User();
    $listaUsers = $crudUser->mostrar();
    $user = $crudUser->obtenerUser($id_user);

    //obtencion plantas
    require_once('/crud_plantas/crud_plantas.php');
    require_once('/clases/planta.php');

    $crudPlanta = new CrudPlanta();
    $planta = new Planta();
    $listaPlantas = $crudPlanta->mostrar();
    $planta = $crudPlanta->obtenerPlanta($id_user);

    if (!isset($listaPlantas)) {
        $listaPlantas = $crudPlanta->mostrar();
    }

    //obtencion deseados
    require_once('/crud_deseados/crud_deseados.php');
    require_once('/clases/deseados.php');

    $crudDeseados = new CrudDeseados();
    if (!isset($listaDeseados)) {
        $listaDeseados = $crudDeseados->mostrar();
    }
    //categorias
    if (isset($_GET['categoria'])) {
        $listaPlantas = $crudPlanta->ordenarPorCategoria($_GET['categoria'], $listaPlantas);
    }

    if (isset($_GET['sort'])) {
        if ($_GET['sort'] == 1) {
            $listaPlantas = $crudPlanta->mostrar();
        } else if ($_GET['sort'] == 2) {
            $listaPlantas = $crudPlanta->ordenarPorPrecio($listaPlantas);
        } else if ($_GET['sort'] == 3) {
            $listaPlantas = $crudPlanta->ordenarPorNombre($listaPlantas);
        } else if ($_GET['sort'] == 4) {
            $listaPlantas = $crudPlanta->ordenarPorDeseados($listaPlantas, $listaDeseados);
        }
    }
} else {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="styles.css">
    <script src="../sweetalert2.all.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>

    <script>
        function myFunction() {
            var input, filter, cartas, splitArray, textoCarta, i;
            input = document.getElementById('myInput');
            filtro = input.value.toUpperCase();
            cartas = document.getElementsByClassName('lista-plantas');

            for (i = 0; i < cartas.length; i++) {
                splitArray = cartas[i].innerText.split("\n");
                textoCarta = splitArray[0];

                if (textoCarta.toUpperCase().indexOf(filtro) > -1) {
                    cartas[i].style.display = "";
                } else {
                    cartas[i].style.display = "none";
                }
            }
        }
    </script>
</head>

<body>
    <div class='header'>
        <div class='topbar'>
            <div class='header-logo'>
                <a href="index.php" class="logo">
                    <img src="images/logo.png" />
                </a>
            </div>
            <div class='header-userinfo'>
                <a href="profile.php" class="userinfo">
                    <div class='avatar'>
                        <img src=<?php echo $user->getAvatar(); ?>>
                    </div>
                    <div class='nombre'>
                        <?php echo $user->getNickname(); ?>
                    </div>
                </a>

                <div class='header-content'>
                    <li><a href="profile.php">Perfil</a></li>
                    <li><a href="/crud_deseados/pagina_deseados.php">Deseados</a></li>
                    <li><a href="cierre_sesion.php">Cerrar sesión</a></li>

                    <form method="post" action="/crud_carrito/pagina_carrito.php" class="btn-carrito">
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
        <a href="index.php">Home</a>
        <div class="flecha-navegacion">
            ▶
        </div>
        <a href="profile.php">Perfil</a>
    </div>

    <div class="content-wrapper">
        <div class="content">
            <div class="lista-orden">
                <form method="GET" action="">
                    <button type="submit" name="sort" class="button" value="1">Ordenar por defecto</button>
                    <button type="submit" name="sort" class="button" value="2">Ordenar por precio</button>
                    <button type="submit" name="sort" class="button" value="3">Ordenar por nombre</button>
                    <button type="submit" name="sort" class="button" value="4">Ordenar por deseados</button>
                </form>
            </div>
            <div class="scroll-plantas">
                <?php foreach ($listaPlantas as $plantas) { ?>
                    <div class="lista-plantas">
                        <div class="carta">
                            <div class="lista-plantas-fotos">
                                <img src=<?php echo $plantas->getFoto() ?> class="lista-fotos">
                            </div>
                            <div class="lista-plantas-content">
                                <div class="lista-plantas-nombre">
                                    <?php echo $plantas->getNombre() ?>
                                </div>
                                <div class="lista-plantas-gestionCarrito">
                                    <div class="lista-plantas-precio">
                                        <?php echo $plantas->getPrecio() ?> €
                                    </div>
                                    <?php if ($logueado) { ?>
                                        <form method="POST" action="/crud_carrito/gestion_carrito.php" class="lista-plantas-addcarrito">
                                            <input type="hidden" name="plant" value="<?php echo $plantas->getId(); ?>" />
                                            <input type="number" min="1" name="cantidad" class="cantidadCarrito" />
                                            <input type="submit" value="&#128722;" />
                                        </form>
                                    <?php } ?>
                                </div>
                                <div class="agregar-deseados">
                                    <?php
                                    $idDeseado = $crudDeseados->obtenerDeseado($plantas->getId(), $_SESSION['sessionID']);

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
                                                <input type="hidden" name="id_planta" value="<?php echo $plantas->getId() ?>" />
                                                <input type="hidden" name="id_user" value="<?php echo $id ?>" />
                                                <button type="submit" name="add">☆</button>
                                            </form>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="ver-detalles-planta">
                                <form method="POST" action="ver_detalle.php">
                                    <input type="hidden" name="id_admin" value="<?php echo $id_user ?>" />
                                    <input type="hidden" name="id_planta" value="<?php echo $plantas->getId() ?>" />
                                    <input type="submit" id="detalles" value="Ver detalle" />
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>

</html>