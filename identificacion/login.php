<?php
// include clases
include_once('../clases/user.php');

// include cruds
include_once('../crud_users/crud_users.php');

// cruds
$crudUser = new CrudUser();

// flags de validacion
$validacionFormulario = false;
$validacionLogin = false;

// si hay sesión se reenvia al índex
// no hace falta volver a loguearse
session_start();
if (isset($_SESSION['userSession'])) {
    header("Location: index.php");
}

if (isset($_POST['login'])) {
    if (empty($_POST['nickname']) || empty($_POST['password'])) {
        $validacionFormulario = true;
    } else {
        $nickname = $crudUser->borrarEspacios($_POST['nickname']);
        $password = $crudUser->borrarEspacios($_POST['password']);
        $password_crypt = $crudUser->encriptarPassword($password);
        $userSession = $crudUser->validarLoginUser($nickname, $password_crypt);

        if ($userSession != null) {
            //session_start();
            $_SESSION['userSession'] = $userSession;
            $_SESSION['plantasVisitadas'] = [];
            header("Location: ../index.php");
        } else {
            $validacionLogin = true;
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
    <title>Tienda login</title>
    <link rel="stylesheet" href="/styles/global.css">
    <link rel="stylesheet" href="/styles/login.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,700" />
</head>

<body>
    <div class='header'>
        <?php include_once('../html_header/navbar.php'); ?>
    </div>
    <div class="espacio">
    </div>
    <div class="formulario-login">
        <form action="" method="POST" class="form-login">
            <h1>Login</h1>
            <input type="text" name="nickname" placeholder="Nombre"><br>
            <input type="password" name="password" placeholder="Contraseña"><br>
            <button type="submit" name="login">Iniciar sesión</button>
            
            <!--
                validacionLogin = valida que el usuario exista
                validacionFormulario = si se deja el nombre y pass vacios
            -->
            <?php
            if(!$validacionLogin) {
            } else { ?>
                <br>No se encuentra el usuario.
            <?php } ?>

            <?php 
            if(!$validacionFormulario) {
            } else { ?>
                <br>Por favor rellena el formulario.
            <?php } ?>
        </form>
        <a href="/identificacion/registro.php">Crear cuenta</a>
    </div>
    <div class="espacio"></div>
    <?php include_once('../html_footer/footer.php'); ?>
</body>

</html>