<?php
include_once('crud_users.php');
include_once('../clases/user.php');

$crud = new CrudUser();

session_start();
if (isset($_SESSION['userSession'])) {
    $userSession = $_SESSION['userSession'];

    //obtencion users
    include_once('../crud_users/crud_users.php');
    include_once('../clases/user.php');

    $crudUser = new CrudUser();
    $listaUsers = $crudUser->obtenerListaUsuarios();

    if (isset($_POST['id_usuario_modificar'])) {
        $usuario_modificar = $crud->obtenerUser($_POST['id_usuario_modificar']);
    }

    // obtener contador del carrito
    $contadorCarrito = 0;
    if (isset($_SESSION['arrayPlantas'])) {
        $contadorCarrito = count($_SESSION['arrayPlantas']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar usuario</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,700" />
</head>

<body>
    <div class='header'>
        <?php include_once('../html_header/navbar.php'); ?>
    </div>

    <div class="espacio">
    </div>

    <div class="enlaces-navegacion">
        <a href="../index.php">Home</a>
        <div class="flecha-navegacion">
            ▶
        </div>
        <a href="../profile.php">Perfil</a>
        <div class="flecha-navegacion">
            ▶
        </div>
        <a href="pagina_modificacion.php">Modificación de usuarios</a>
    </div>

    <div class="content-wrapper">
        <div class="content">
            <form action='/crud_users/gestion_modificacion.php' method='POST' enctype="multipart/form-data">
                <div class='modificar-user'>
                    <div class='modificar-avatar'>
                        <img src=<?php echo $usuario_modificar->getAvatar() ?>>
                        <input type="file" name='file'>
                    </div>
                    <div class='modificar-content'>
                        <div class='modificar-content-nombre'>
                            <label>Nickname:</label>
                            <input type="text" name="nickname" value="<?php echo $usuario_modificar->getNickname() ?>">
                        </div>
                        <div class='modificar-content-email'>
                            <label>Email:</label>
                            <input type="email" name="email" value="<?php echo $usuario_modificar->getEmail() ?>">
                        </div>
                    </div>
                    <input type='hidden' name='id_user_modificar' value='<?php echo $usuario_modificar->getId() ?>'>
                    <input type='hidden' name='actualizar' value='actualizar'>
                </div>
                <div class='aceptar-modificaciones'>
                    <input type='submit' name="aceptarmodif" value='Aceptar modificaciones'>
                </div>
            </form>
        </div>
    </div>

    <div class="espacio"></div>
    <?php include_once('../html_footer/footer.php'); ?>
</body>

</html>