<?php
include '/conexion/db.php';

require_once('/crud_users/crud_users.php');
require_once('/clases/user.php');

$nickname = $_POST['nickname'];
$password = $_POST['password'];
$crudUser = new CrudUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class='header'>
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
    <div class="espacio">
    </div>

    <?php if ($nickname != "" && $password != "") {
        $user = $crudUser->validarLogin($nickname, $password); ?>

        <?php if (is_null($user) || empty($user)) { ?>
            <label>Nombre o contraseña incorrectos.<label>
            <form action='login.php'>
                <button type='submit' value='Atrás'>Volver atrás</button>
            </form>
        <?php } else
        {
            if ($user['admin'] == 1) {
                session_start();
                $_SESSION['sessionID']=$user['id'];
                $_SESSION['isAdmin']=$user['admin'];
                header("Location: profileAdmin.php");
            } else {
                session_start();
                $_SESSION['sessionID']=$user['id'];
                $_SESSION['isAdmin']=$user['admin'];
                header("Location: profile.php");
            }
        }
        ?>
    <?php } else { ?>
        <label>Nombre o contraseña vacios.<label>
        <form action='login.php'>
            <button type='submit' value='Atrás'>Volver atrás</button>
        </form>
    <?php } ?>
</body>
</html>