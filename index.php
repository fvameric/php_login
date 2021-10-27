<?php
    include('/conexion/db.php');
    
    //obtencion plantas
    require_once('/crud_plantas/crud_plantas.php');
    require_once('/clases/planta.php');

    $crudPlanta = new CrudPlanta();
    $planta = new Planta();
    $listaPlantas = $crudPlanta->mostrar();

    $flagSession = false;
    session_start();
    if (isset($_SESSION['sessionID'])) {
        $flagSession = true;

        //obtencion users
        require_once('/crud_users/crud_users.php');
        require_once('/clases/user.php');

        $crudUser = new CrudUser();
        $user = new User();
        $listaUsers = $crudUser->mostrar();
        $user = $crudUser->obtenerUser($_SESSION['sessionID']);
    }
?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php if ($flagSession) { ?>
        <div class='header'>
            <div class='topbar'>
                <div class='header-logo'>
                    <a href="index.php" class="logo">
                        <img src="images/logo.png">
                    </a>
                </div>
                <div class='header-userinfo'>
                    <?php if ($_SESSION['isAdmin'] == 0) { ?>
                        <a href="profile.php" class="userinfo">
                            <div class='avatar'>
                                <img src=<?php echo $user->getAvatar(); ?>>
                            </div>
                            <div class='nombre'>
                                <?php echo $user->getNickname(); ?>
                            </div>
                        </a>
                    <?php } else { ?>
                        <a href="profileAdmin.php" class="userinfo">
                            <div class='avatar'>
                                <img src=<?php echo $user->getAvatar(); ?>>
                            </div>
                            <div class='nombre'>
                                <?php echo $user->getNickname(); ?>
                            </div>
                        </a>
                    <?php } ?>
                    
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
                                <?php if ($_SESSION['isAdmin'] == 0) { ?>
                                    <li><a href="profile.php">Perfil</a></li>
                                <?php } else { ?>
                                    <li><a href="profileAdmin.php">Perfil</a></li>
                                <?php } ?>
                                
                                <li><a href="cierre_sesion.php">Cerrar sesión</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class='header'>
            <div class='topbar'>
                <div class='header-logo'>
                    <a href="index.php" class="logo">
                        <img src="images/logo.png">
                    </a>
                </div>
                <div class='menu-user'>
                    <a class="btn-registrarse" href="registro.html">Regístrate</a>
                    <a class="btn-iniciarsesion" href="login.php">Inicia sesión</a>
                </div>
            </div>
        </div>
    <?php } ?>

    <div class="presentacion">
    </div>

    <div class="content">
        <div class="scroll-plantas">
            <?php foreach($listaPlantas as $plantas) { ?>
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
                                <input type="hidden" name="index_flag" value="true"/>
                                <input type="hidden" name="id_planta" value="<?php echo $plantas->getId() ?>"/>
                                <input type="submit" id="detalles" value="Ver detalle"/>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>