<?php
// include clases
include_once('/clases/user.php');
include_once('/clases/planta.php');
include_once('/clases/deseados.php');

// include cruds
include_once('/crud_users/crud_users.php');
include_once('/crud_plantas/crud_plantas.php');
include_once('/crud_deseados/crud_deseados.php');

// si no hay sesión iniciada, devuelve al home
session_start();
if (isset($_SESSION['userSession'])) {

    // variables de sesión
    $userSession = $_SESSION['userSession'];

    // cruds
    $crudUser = new CrudUser();
    $crudPlanta = new CrudPlanta();
    $crudDeseados = new CrudDeseados();

    // obtención de elementos de la BD
    if (!isset($listaUsers)) {
        $listaUsers = $crudUser->obtenerListaUsuarios();
    }
    if (!isset($listaPlantas)) {
        $listaPlantas = $crudPlanta->obtenerListaPlantas();
    }
    if (!isset($listaDeseados)) {
        $listaDeseados = $crudDeseados->obtenerListaDeseados();
    }

    // obtener contador del carrito
    $contadorCarrito = 0;
    if (isset($_SESSION['arrayPlantas'])) {
        $contadorCarrito = count($_SESSION['arrayPlantas']);
    }

    // Botones de ordenar por categorias
    if (isset($_GET['categoria'])) {
        $listaPlantas = $crudPlanta->ordenarPorCategoria($_GET['categoria'], $listaPlantas);
    }

    // Botones de ordenar por nombre, precio...
    if (isset($_GET['sort'])) {
        if ($_GET['sort'] == 1) {
            $listaPlantas = $crudPlanta->obtenerListaPlantas();
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
    <link rel="stylesheet" href="/styles/global.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,700" />
    <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
</head>

<body>
    <div class='header'>
        <?php include_once('/html_header/navbar.php') ?>
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
            <div class="detalle-perfil">
                Avatar:
                <div class='avatar-perfil'>
                    <img src=<?php echo $userSession->getAvatar(); ?>>
                </div>
                Nombre:
                <?php echo $userSession->getNickname(); ?><br>
                Email:
                <?php echo $userSession->getEmail(); ?><br>
            </div>
            <!--
                Se mostrará los botones de crear usuarios y crear plantas,
                y la lista de usuarios para modificar o eliminar,
                en caso de que el usuario sea admin
            -->
            <?php if ($userSession->getAdmin() == 1) { ?>
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

    <div class="espacio"></div>
    <?php include_once('/html_footer/footer.php'); ?>
</body>

</html>