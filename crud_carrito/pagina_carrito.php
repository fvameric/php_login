<?php
    include 'db.php';
    require_once('../clases/planta.php');
    require_once('../crud_plantas/crud_plantas.php');

    //obtencion plantas
    $crudPlantas = new CrudPlanta();

    session_start();
    if (isset($_SESSION['sessionID'])) {

        $id_user = $_SESSION['sessionID'];

        //obtencion users
        require_once('../crud_users/crud_users.php');
        require_once('../clases/user.php');
        $crudUser = new CrudUser();
        $user = new User();
        $user = $crudUser->obtenerUser($id_user);
    
        //obtencion plantas
        require_once('../crud_plantas/crud_plantas.php');
        require_once('../clases/planta.php');
    
        $crudPlanta = new CrudPlanta();

        $contador = 0;
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
    <script src="../sweetalert2.all.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
</head>

<body>
    <div class='header'>
        <div class='topbar'>
            <div class='header-userinfo'>
                <a href="../profileAdmin.php" class="userinfo">
                    <div class='avatar'>
                        <img src=<?php echo $user->getAvatar(); ?>>
                    </div>
                    <div class='nombre'>
                        <?php echo $user->getNickname(); ?>
                    </div>
                </a>

                <div class='header-content'>
                    <li><a href="../profileAdmin.php">Perfil</a></li>
                    <li><a href="../crud_deseados/pagina_deseados.php">Deseados</a></li>
                    <li><a href="../cierre_sesion.php">Cerrar sesión</a></li>

                    <!--
                    <div class="dropdown">
                        <input id="menu-toggle" type="checkbox">
                        <label id="menu-label" for="menu-toggle">
                            <div class="triangle">
                            </div>
                        </label>
                        <ul id="collapse-menu">
                            <li><a href="profileAdmin.php">Perfil</a></li>
                            <li><a href="/crud_deseados/pagina_deseados.php">Deseados</a></li>
                            <li><a href="cierre_sesion.php">Cerrar sesión</a></li>
                        </ul>
                    </div>
                    -->

                    <form method="post" action="" class="btn-carrito">
                        <button>&#128722;</button>
                        <label></label>
                    </form>

                    <?php
                    if (isset($_SESSION['arrayPlantas'])) { ?>
                        <span class="dot"><?php echo count($_SESSION['arrayPlantas']); ?></span>
                    <?php } else {
                        $_SESSION['arrayPlantas'] = [];
                    } ?>
                </div>
            </div>
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
        <a href="pagina_carrito.php">Carrito</a>
    </div>

    <div class="content-wrapper">
        <div class="content">
            <div class="scroll-plantas">
                <?php

                foreach ($_SESSION['arrayPlantas'] as $key => $plantas) {
                    $contador += $plantas->getPrecio();
                    ?>
                    <div class="lista-plantas">
                        <div class="carta">
                            <div class="lista-plantas-fotos">
                                <img src=<?php echo $plantas->getFoto() ?> class="lista-fotos">
                            </div>
                            <div class="lista-plantas-content">
                                <div class="lista-plantas-nombre">
                                    <?php echo $plantas->getNombre() ?>
                                </div>
                                <div class="lista-plantas-precio">
                                    <?php echo $plantas->getPrecio() ?> €
                                </div>
                            </div>
                            <div class="ver-detalles-planta">
                                <form method="POST" action="ver_detalle.php">
                                    <input type="hidden" name="id_admin" value="<?php echo $id ?>" />
                                    <input type="hidden" name="id_planta" value="<?php echo $plantas->getId() ?>" />
                                    <input type="submit" id="detalles" value="Ver detalle" />
                                </form>
                            </div>
                            <div class="ver-detalles-planta">
                                <form method="POST" action="gestion_eliminacion.php">
                                    <input type="hidden" name="index" value="<?php echo $key ?>" />
                                    <input type="submit"  id="eliminar" value="Quitar del carro" />
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div>
                <br>
                <br>
                <h2>Total: <?php echo $contador; ?> €<h2>
            </div>
        </div>
    </div>
</body>

</html>