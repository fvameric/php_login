<?php
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
                $userSession = $crudUser->validarLoginUser($nickname, $password_crypt);

                if ($userSession != null) {
                    session_start();
                    $_SESSION['userSession'] = $userSession;
                    header("Location: ../index.php");
                } else { ?>
                    No se encuentra el usuario.
                <?php } ?>
            <?php } ?>
        <?php } ?>
        <a href="/identificacion/registro.php">Crear cuenta</a>
    </div>

    <div class="espacio"></div>
    <?php include_once('../html_footer/footer.php'); ?>
</body>

</html>