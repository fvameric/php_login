<?php
    include('/conexion/db.php');

    $test = false;

    session_start();
    if (isset($_SESSION['sessionID'])) {
        $id_admin = $_SESSION['sessionID'];
        $id_planta = $_POST['id_planta'];
        
        //obtencion users
        require_once('/crud_users/crud_users.php');
        require_once('/clases/user.php');

        $crudUser = new CrudUser();
        $user = new User();
        $listaUsers = $crudUser->mostrar();
        $user = $crudUser->obtenerUser($id_admin);

        //obtencion plantas
        require_once('/crud_plantas/crud_plantas.php');
        require_once('/clases/planta.php');

        $crudPlanta = new CrudPlanta();
        $planta = new Planta();
        $listaPlantas = $crudPlanta->mostrar();
        $planta = $crudPlanta->obtenerPlanta($id_planta);

        $newPlanta;

        foreach($listaPlantas as $planta) {
            if ($id_planta == $planta->getId()) {
                $newPlanta = $planta;
            }
        }
    } else {
        $test = true;

        $id_planta = $_POST['id_planta'];

        //obtencion plantas
        require_once('/crud_plantas/crud_plantas.php');
        require_once('/clases/planta.php');

        $crudPlanta = new CrudPlanta();
        $planta = new Planta();
        $listaPlantas = $crudPlanta->mostrar();
        $planta = $crudPlanta->obtenerPlanta($id_planta);

        $newPlanta;

        foreach($listaPlantas as $planta) {
            if ($id_planta == $planta->getId()) {
                $newPlanta = $planta;
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
    <title><?php echo $newPlanta->getNombre(); ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php if ($test == false) { ?>
        <div class='header'>
            <div class='topbar'>
                <div class='header-logo'>
                    <a href="index.php" class="logo">
                        <img src="images/logo.png">
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
                                <li><a href="login.php">Salir</a></li>
                                <li><a href="login.php">Cerrar sesión</a></li>
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

    <div class="espacio">
    </div>

    <div class="volver">
        <a href="javascript:history.go(-1)">Volver atrás</a>
    </div>

    <div class="content">
        <div class="foto-planta-detalle">
            <img src="<?php echo $newPlanta->getFoto(); ?>"/>
        </div>
        <div class="nombre-planta-detalle">
            <?php echo $newPlanta->getNombre(); ?>
        </div>
        <div class="precio-planta-detalle">
            <?php echo $newPlanta->getPrecio(); ?> €
        </div>
        <div class="comprar-planta-detalle">
            <button>Comprar</button>
        </div>
    </div>
</body>
</html>