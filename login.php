<?php
    session_start();
    if (isset($_SESSION['sessionID']) == true) {
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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
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
    <div class="espacio">
    </div>
    <div class="formulario-login">
        <form action="gestion_login.php" method="POST" class="form-login">
            <h1>Login</h1>
            <input type="text" name="nickname" placeholder="Nombre"><br>
            <input type="password" name="password" placeholder="Contraseña"><br>
            <button type="submit" value="Sign in">Sign in</button>
        </form>
        <a href="registro.html">Crear cuenta</a>
    </div>
</body>
</html>