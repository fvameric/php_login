<?php
//include_once '../conexion/db.php';

include_once('../crud_users/crud_users.php');
include_once('../clases/user.php');

$crudUser = new CrudUser();

session_start();
if (isset($_SESSION['userSession'])) {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda login</title>
    <link rel="stylesheet" href="../styles.css">
</head>

<body>
    <div class='header'>
        <div class='topbar'>
            <div class='header-logo'>
                <a href="../index.php" class="logo">
                    <img src="../images/logo.png">
                </a>
            </div>
            <div class='menu-user'>
                <a class="btn-registrarse" href="/identificacion/registro.html">Regístrate</a>
                <a class="btn-iniciarsesion" href="/identificacion/login.php">Inicia sesión</a>
            </div>
        </div>
    </div>
    <div class="espacio">
    </div>
    <div class="formulario-login">
        <form action="" method="POST" class="form-login">
            <h1>Login</h1>
            <input type="text" name="nickname" placeholder="Nombre"><br>
            <input type="password" name="password" placeholder="Contraseña"><br>
            <button type="submit" name="login">Iniciar sesión</button>
        </form>
        <?php
        if (isset($_POST['login'])) {
            if (!isset($_POST['nickname']) || !isset($_POST['password'])) { ?>
                Nombre o password vacios.
                <?php
            } else {
                $nickname = $crudUser->borrarEspacios($_POST['nickname']);
                $password = $crudUser->borrarEspacios($_POST['password']);
                $password_crypt = $crudUser->encriptarPassword($password);
                //$userSession = $crudUser->validarLogin($nickname, $password_crypt);
                $userSession = $crudUser->validarLoginUser($nickname, $password_crypt);

                if ($userSession != null) {
                    session_start();
                    $_SESSION['userSession'] = $userSession;
                    //$_SESSION['sessionID'] = $userSession['id'];
                    //$_SESSION['isAdmin'] = $userSession['admin'];
                    header("Location: ../index.php");
                } else { ?>
                    No se encuentra el usuario.
                <?php } ?>
            <?php } ?>
        <?php } ?>
        <a href="/identificacion/registro.html">Crear cuenta</a>
    </div>
</body>

</html>