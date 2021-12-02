<?php
include '/conexion/db.php';

// si no hay sesión iniciada, devuelve al home
session_start();
if (isset($_SESSION['sessionID'])) {
    $logueado = true;
    $_SESSION['ubicacion'] = 'perfilAdmin';
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
            <div class="menu-logo">
                <a href="index.php" class="logo">
                    <img src="images/logo.png" />
                </a>
            </div>
            <div class='header-userinfo'>
                <?php if ($user->getAdmin() == 0) { ?>
                        <a href="profile.php" class="userinfo">
                    <?php } else { ?>
                        <a href="profileAdmin.php" class="userinfo">
                    <?php } ?>
                        <div class='avatar'>
                            <img src=<?php echo $user->getAvatar(); ?>>
                        </div>
                        <div class='nombre'>
                            <?php echo $user->getNickname(); ?>
                        </div>
                    </a>


                    <div class='header-content'>
                        <li><a href="/crud_deseados/pagina_deseados.php">Deseados</a></li>
                        <li><a href="/identificacion/cierre_sesion.php">Cerrar sesión</a></li>

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
    </div>

    <div class="espacio">
    </div>

    <div class="enlaces-navegacion">
        <a href="index.php">Home</a>
        <div class="flecha-navegacion">
            ▶
        </div>
        <a href="profileAdmin.php">Perfil</a>
    </div>

    <div class="content-wrapper">
        <div class="content">
            <div class="detalle-perfil">
                Avatar:
                <div class='avatar'>
                    <img src=<?php echo $user->getAvatar(); ?>>
                </div>
                Nombre:
                <?php echo $user->getNickname(); ?><br>
                Email:
                <?php echo $user->getEmail(); ?><br>
            </div>
            <?php if ($user->getAdmin() == 1) { ?>
                <div class="lista-usuarios-crear">
                    <form method="POST" action="/crud_users/pagina_creacion.php">
                        <input type="hidden" name="id_admin" value="<?php echo $id ?>" />
                        <input type="submit" name="crear" id="crear" value="Crear usuario" />
                    </form>
                </div>

                <div class="lista-plantas-crear">
                    <form method="POST" action="/crud_plantas/pagina_creacion.php">
                        <input type="hidden" name="id_admin" value="<?php echo $id ?>" />
                        <input type="submit" name="crear" id="crear" value="Crear planta" />
                    </form>
                </div>

                <div class="scroll-usuarios">
                    <?php foreach ($listaUsers as $usuario) { ?>
                        <div class="lista-usuarios">
                            <div class="lista-usuarios-avatares">
                                <img src=<?php echo $usuario->getAvatar() ?> class="lista-avatar">
                            </div>
                            <div class="lista-usuarios-content">
                                <div class="lista-usuarios-nombre">
                                    <?php echo $usuario->getNickname() ?>
                                </div>
                                <div class="lista-usuarios-email">
                                    <?php echo $usuario->getEmail(); ?>
                                </div>
                            </div>
                            <div class="lista-usuarios-crud">
                                <div class="lista-usuarios-modificar">
                                    <form method="POST" action="/crud_users/pagina_modificacion.php">
                                        <input type="hidden" name="id_usuario_modificar" value="<?php echo $usuario->getId() ?>" />
                                        <input type="submit" value="Modificar" />
                                    </form>
                                </div>
                                <div class="lista-usuarios-eliminar">
                                    <form method="POST" action="/crud_users/gestion_eliminacion.php">
                                        <input type="hidden" name="id_usuario_eliminar" value="<?php echo $usuario->getId() ?>" />
                                        <input type="submit" value="Eliminar" />
                                    </form>
                                </div>

                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="espacio">
    </div>

    <footer class="footer">
    </footer>
</body>

</html>