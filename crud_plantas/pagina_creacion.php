<?php
//include_once('../conexion/db.php');

//obtencion users
include_once('../crud_users/crud_users.php');
include_once('../clases/user.php');

session_start();
if (isset($_SESSION['userSession'])) {
    $logueado = true;
    //$id_user = $_SESSION['sessionID'];
    $userSession = $_SESSION['userSession'];
    $crudUser = new CrudUser();
    //$user = new User();
    $listaUsers = $crudUser->obtenerListaUsuarios();
    //$user = $crudUser->obtenerUser($id_user);
} else {
    $logueado = false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear planta</title>
    <link rel="stylesheet" href="../styles.css">
</head>

<body>
    <div class='header'>
        <div class='topbar'>
            <div class="menu-logo">
                <a href="..index.php" class="logo">
                    <img src="../images/logo.png" />
                </a>
            </div>
            <?php if ($logueado) { ?>
                <div class='header-userinfo'>
                    <?php if ($userSession->getAdmin() == 0) { ?>
                        <a href="../profile.php" class="userinfo">
                            <div class='avatar'>
                                <img src=<?php echo $userSession->getAvatar(); ?>>
                            </div>
                            <div class='nombre'>
                                <?php echo $userSession->getNickname(); ?>
                            </div>
                        </a>
                    <?php } else { ?>
                        <a href="../profileAdmin.php" class="userinfo">
                            <div class='avatar'>
                                <img src=<?php echo $userSession->getAvatar(); ?>>
                            </div>
                            <div class='nombre'>
                                <?php echo $userSession->getNickname(); ?>
                            </div>
                        </a>
                    <?php } ?>

                    <div class='header-content'>
                        <li><a href="../crud_deseados/pagina_deseados.php">Deseados</a></li>
                        <li><a href="../identificacion/cierre_sesion.php">Cerrar sesión</a></li>

                        <form method="post" action="../crud_carrito/pagina_carrito.php" class="btn-carrito">
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
            <?php } else { ?>
                <div class='header'>
                    <div class='topbar'>
                        <div class='header-logo'>
                            <a href="index.php" class="logo">
                                <img src="images/logo.png">
                            </a>
                        </div>
                        <div class='menu-user'>
                            <a class="btn-registrarse" href="../identificacion/registro.html">Regístrate</a>
                            <a class="btn-iniciarsesion" href="../identificacion/login.php">Inicia sesión</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
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
        <a href="pagina_creacion.php">Creación de plantas</a>
    </div>

    <div class="content-wrapper">
        <div class="content">
            <h1>Crear planta nueva:</h1>
            <form id="formRegistro" action="registrar_planta.php" method="POST" enctype="multipart/form-data">
                <label>Nombre</label><br>
                <textarea type="text" id="nombre" name="nombre"></textarea><br><br>

                <label>Descripcion</label><br>
                <textarea type="text" id="descripcion" name="descripcion"></textarea><br><br>

                <label>Precio</label><br>
                <input type="number" step="any" id="precio" name="precio"><br><br>

                <label>Stock</label><br>
                <input type="number" id="stock" name="stock"><br><br>

                <label>Compradas</label><br>
                <input type="number" id="compradas" name="compradas"><br><br>

                <label>Foto</label><br>
                <input type="file" name="file"><br><br>

                <p>Categoria:</p>
                <input type="radio" id="Aeonium" name="categoria" value="1">
                <label for="Aeonium">Aeonium</label><br>
                <input type="radio" id="Cotyledon" name="categoria" value="2">
                <label for="Cotyledon">Cotyledon</label><br>
                <input type="radio" id="Crassula" name="categoria" value="3">
                <label for="Crassula">Crassula</label><br>
                <input type="radio" id="Echeveria" name="categoria" value="4">
                <label for="Echeveria">Echeveria</label><br>
                <input type="radio" id="Euphorbia" name="categoria" value="5">
                <label for="Euphorbia">Euphorbia</label><br>
                <input type="radio" id="Haworthia" name="categoria" value="6">
                <label for="Haworthia">Haworthia</label><br>
                <input type="radio" id="Senecio" name="categoria" value="7">
                <label for="Senecio">Senecio</label><br><br>

                <button type="submit" name="submit" value="Registrarse">Registrar</button>
            </form>
        </div>
    </div>
</body>

</html>