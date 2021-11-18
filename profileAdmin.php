<?php
    include '/conexion/db.php';
    
    session_start();
    if (isset($_SESSION['sessionID'])) {
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
        //$planta = $crudPlanta->obtenerPlanta($id);

        //obtencion deseados
        require_once('/crud_deseados/crud_deseados.php');
        require_once('/clases/deseados.php');
    
        $crudDeseados = new CrudDeseados();
        $deseado = new Deseados();
        $listaDeseados = $crudDeseados->mostrar();

        //ordenes
        if (isset($_POST['sort'])) {
            if ($_POST['sort'] == 1) {
                $listaPlantas = $crudPlanta->mostrar();
            } else if($_POST['sort'] == 2) {
                $listaPlantas = $crudPlanta->ordenarPorPrecio($listaPlantas);
            } else if ($_POST['sort'] == 3) {
                $listaPlantas = $crudPlanta->ordenarPorNombre($listaPlantas);
            } else if ($_POST['sort'] == 4) {
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

                    <form method="post" action="" class="btn-carrito">
                        <button>&#128722;</button>
                        <label></label>
                    </form>
                    
                </div>
            </div>
        </div>
        <div class="menu-navegacion">
            <div class="menu-logo">
                <a href="index.php" class="logo">
                    <img src="images/logo.png"/>
                </a>
            </div>
            <div class="botones-menu">
                <div class="caja1">
                    <a>Aeonium</a>
                </div>
                <div class="caja2">
                    <a>Cotyledon</a>
                </div>
                <div class="caja3">
                    <a>Crassula</a>
                </div>
                <div class="caja4">
                    <a>Echeveria</a>
                </div>
                <div class="caja5">
                    <a>Euphorbia</a>
                </div>
                <div class="caja6">
                    <a>Haworthia</a>
                </div>
                <div class="caja7">
                    <a>Senecio</a>
                </div>
            </div>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="buscador">
                <input type="search" name="search" class="barra-buscador" placeholder="Buscador">
                <!--<button type="submit" name="buscar" class="btn-buscador" value="0">Buscar</button>-->

                <?php
                if (isset($_POST['search'])) {
                    $search = $_POST['search'];
                    $listaPlantas = $crudPlanta->busqueda($search, $listaPlantas);
                }
                ?>
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
        <a href="../profileAdmin.php">Perfil</a>
    </div>

    <div class="content-wrapper">
        <div class="side-panel">

        </div>
        <div class="content">
            <?php if ($user->getAdmin() == 1) { ?>
                <div class="lista-usuarios-crear">
                    <form method="POST" action="/crud_users/pagina_creacion.php">
                        <input type="hidden" name="id_admin" value="<?php echo $id ?>"/>
                        <input type="submit" name="crear" id="crear" value="Crear usuario"/>
                    </form>
                </div>

                <div class="scroll-usuarios">
                    <?php foreach($listaUsers as $usuario) { ?>
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
                                        <input type="hidden" name="id_admin" value="<?php echo $id ?>"/>
                                        <input type="hidden" name="id_user" value="<?php echo $usuario->getId() ?>"/>
                                        <input type="submit" id="modificar" value="Modificar"/>
                                    </form>
                                </div>
                                <div class="lista-usuarios-eliminar">
                                    <form method="POST" action="/crud_users/gestion_eliminacion.php">
                                        <input type="hidden" name="id_admin" value="<?php echo $id ?>"/>
                                        <input type="hidden" name="id_user" value="<?php echo $usuario->getId() ?>"/>
                                        <input type="submit" id="eliminar" value="Eliminar"/>
                                    </form>
                                </div>

                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>

            <div class="lista-plantas-crear">
                <form method="POST" action="/crud_plantas/pagina_creacion.php">
                    <input type="hidden" name="id_admin" value="<?php echo $id ?>"/>
                    <input type="submit" name="crear" id="crear" value="Crear planta"/>
                </form>
            </div>

            <!--
            <div class="descargar-xml">
                <form method="POST" action="crear_xml.php">
                    <button type="submit" name="xml">Crear XML</button>
                </form>
            </div>
            -->
            
            <div class="lista-orden">
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <button type="submit" name="sort" class="button" value="1">Ordenar por defecto</button>
                    <button type="submit" name="sort" class="button" value="2">Ordenar por precio</button>
                    <button type="submit" name="sort" class="button" value="3">Ordenar por nombre</button>
                    <button type="submit" name="sort" class="button" value="4">Ordenar por deseados</button>
                </form>
            </div>

            <div class="scroll-plantas">
                <?php
                
                foreach($listaPlantas as $plantas) { ?>
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
            </div>
        </div>
    </div>
</body>
</html>