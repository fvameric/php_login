<?php
// include clases
include_once('../clases/user.php');

// include cruds
include_once('../crud_users/crud_users.php');

session_start();
if (isset($_SESSION['userSession'])) {

    // variables de sesión
    $userSession = $_SESSION['userSession'];

    // cruds
    $crudUser = new CrudUser();

    // obtención de elementos de la BD
    $listaUsers = $crudUser->obtenerListaUsuarios();

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
    <title>Crear nuevo usuario</title>
    <link rel="stylesheet" href="/styles/global.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,700" />
</head>

<body>
    <div class='header'>
        <?php include_once('../html_header/navbar.php'); ?>
    </div>

    <div class="espacio">
    </div>

    <div class="content-creacion">
        <div class="enlaces-navegacion">
            <a href="../index.php">Home</a>
            <div class="flecha-navegacion">
                ▶
            </div>
            <a href="../profile.php">Perfil</a>
            <div class="flecha-navegacion">
                ▶
            </div>
            <a href="pagina_creacion.php">Creación de usuarios</a>
        </div>

        <div class="crear-nuevo-usuario">
            <h2>Crear usuario nuevo:</h2>

            <form id="formRegistro" action="../identificacion/gestion_registro.php" method="POST" enctype="multipart/form-data">
                <label>Avatar</label><br>
                <input type="file" name="file"><br><br>

                <label>Email</label><br>
                <input type="email" name="email"><br><br>

                <label>Nombre de usuario</label><br>
                <input type="text" name="nickname"><br><br>

                <label>Contraseña</label><br>
                <input type="password" name="password"><br><br>

                <button type="submit" name="submit" value="Registrarse">Registrar</button>
            </form>
        </div>
    </div>

    <div class="espacio"></div>
    <?php //include_once('../html_footer/footer.php'); 
    ?>
</body>

</html>