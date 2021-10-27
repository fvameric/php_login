<?php
    session_start();
    if (isset($_SESSION['sessionID'])) {
        $id_user = $_SESSION['sessionID'];

        //obtencion users
        require_once('../crud_users/crud_users.php');
        require_once('../clases/user.php');
    
        $crudUser = new CrudUser();
        $user = new User();
        $listaUsers = $crudUser->mostrar();
        $user = $crudUser->obtenerUser($id_user);
    
        //obtencion deseados
        require_once('crud_deseados.php');
        require_once('../clases/deseados.php');
    
        $crudDeseados = new CrudDeseados();
        $deseado = new Deseados();
        $listaDeseados = $crudDeseados->mostrar();
        $deseado = $crudDeseados->obtenerDeseado($id_user);

        //obtencion plantas
        require_once('../crud_plantas/crud_plantas.php');
        require_once('../clases/planta.php');

        $crudPlanta = new CrudPlanta();
        $planta = new Planta();
        $listaPlantas = $crudPlanta->mostrar();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deseados</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<div class='header'>
        <div class='topbar'>
            <div class='header-logo'>
                <a href="index.php" class="logo">
                    <img src="../images/logo.png">
                </a>
            </div>
            <div class='header-userinfo'>
                <div class='avatar'>
                    <img src=<?php echo $user->getAvatar(); ?>>
                </div>
                <div class='header-content'>
                    <div class='nombre'>
                        <?php echo $user->getNickname(); ?>
                    </div>

                    <form method="post" action="" class="btn-carrito">
                        <button>Carrito</button>
                    </form>
                    <div class="dropdown">

                        <input id="menu-toggle" type="checkbox">
                        <label id="menu-label" for="menu-toggle">
                            <div class="triangle">
                            </div>
                        </label>
                        <ul id="collapse-menu">
                            <li><a href="login.php">Cerrar sesión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="espacio">
    </div>
    
    <div class="content">
        <div class="volver">
            <a href="javascript:history.go(-1)">Volver atrás</a>
        </div>

        <div class="scroll-plantas">
            <?php foreach($listaDeseados as $deseados) { ?>
                <?php if ($deseados->getUserId() == $id_user) { ?>
                    <?php foreach($listaPlantas as $plantas) { ?>
                        <?php if ($plantas->getId() == $deseados->getPlantaId()) { ?>
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
                                        <div class="agregar-deseado">
                                            <form method="POST" action="gestion_eliminacion.php" class="btn-carrito">
                                                <input type="hidden" name="id_deseado" value="<?php echo $deseados->getId() ?>"/>
                                                <input type="submit" name="quitar" value="Quitar"/>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="lista-plantas-crud">
                                        <div class="lista-plantas-modificar">
                                            <form method="POST" action="/crud_plantas/pagina_modificacion.php">
                                                <input type="hidden" name="id_admin" value="<?php echo $id ?>"/>
                                                <input type="hidden" name="id_planta" value="<?php echo $plantas->getId() ?>"/>
                                                <input type="submit" id="modificar" value="Modificar"/>
                                            </form>
                                        </div>
                                        <div class="lista-plantas-eliminar">
                                            <form method="POST" action="/crud_plantas/gestion_eliminacion.php">
                                                <input type="hidden" name="id_admin" value="<?php echo $id ?>"/>
                                                <input type="hidden" name="id_planta" value="<?php echo $plantas->getId() ?>"/>
                                                <input type="submit" id="eliminar" value="Eliminar"/>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="ver-detalles-planta">
                                        <form method="POST" action="ver_detalle.php">
                                            <input type="hidden" name="id_admin" value="<?php echo $id ?>"/>
                                            <input type="hidden" name="id_planta" value="<?php echo $plantas->getId() ?>"/>
                                            <input type="submit" id="detalles" value="Ver detalle"/>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</body>
</html>