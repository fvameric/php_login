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
        //$deseado = $crudDeseados->obtenerDeseado($id_user);

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
            <div class='header-userinfo'>
                <a href="profileAdmin.php" class="userinfo">
                    <div class='avatar'>
                        <img src=<?php echo $user->getAvatar(); ?>>
                    </div>
                    <div class='nombre'>
                        <?php echo $user->getNickname(); ?>
                    </div>
                </a>

                <div class='header-content'>
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
                            <li><a href="profileAdmin.php">Perfil</a></li>
                            <li><a href="/crud_deseados/pagina_deseados.php">Deseados</a></li>
                            <li><a href="cierre_sesion.php">Cerrar sesión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu-navegacion">
            <div class="menu-logo">
                <a href="../index.php" class="logo">
                    <img src="../images/logo.png"/>
                </a>
            </div>
            <div class="botones-menu">
                <div class="caja1">
                    <a>test</a>
                </div>
                <div class="caja2">
                    <a>test</a>
                </div>
                <div class="caja3">
                    <a>test</a>
                </div>
                <div class="caja4">
                    <a>test</a>
                </div>
                <div class="caja5">
                    <a>test</a>
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
        <a href="pagina_deseados.php">Deseados</a>
    </div>

    <div class="content">
        <div class="descargar-xml">
            <form method="POST" action="crear_xml.php">
                <button type="submit" name="xml">Crear XML</button>
            </form>
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
                                        <div class="agregar-deseados">
                                            <?php 
                                            $idDeseado = $crudDeseados->obtenerDeseado($plantas->getId(), $_SESSION['sessionID']);

                                            if ($idDeseado != null) { ?>
                                                <div class="quitar-deseado">
                                                    <form method="POST" action="/crud_deseados/gestion_eliminacion.php" class="btn-quitar-deseado">
                                                        <input type="hidden" name="id_deseado" value="<?php echo $idDeseado ?>"/>
                                                        <button type="submit" name="quitarDeseado">★</button>
                                                    </form>
                                                </div>
                                            <?php } else { ?>
                                                <div class="agregar-deseado">
                                                    <form method="POST" action="/crud_deseados/gestion_creacion.php" class="btn-agregar-deseado">
                                                        <input type="hidden" name="id_planta" value="<?php echo $plantas->getId() ?>"/>
                                                        <input type="hidden" name="id_user" value="<?php echo $id ?>"/>
                                                        <button type="submit" name="add">☆</button>
                                                    </form>
                                                </div>
                                            <?php } ?>
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