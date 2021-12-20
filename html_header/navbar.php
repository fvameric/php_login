<!-- Barra de usuario -->

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="/styles/navbar.css">
</head>

<body>
    <div class='topbar'>
        <div class="menu-logo">
            <a href="/index.php" class="logo">
                <img src="/images/logo.png" />
            </a>
        </div>

        <form method="POST" action="" class="buscador">
            <input type="text" id="inputBuscador" class="barra-buscador" onkeyup="funcionBuscador()" placeholder="Buscador">
        </form>
        <!--
            Si hay sesión iniciada se muestra la información del user
            y si no hay sesión iniciada,
            muestra los botones de iniciar y registrarse
        -->
        <?php if (isset($_SESSION['userSession'])) { ?>
            <div class='header-userinfo'>
                <a href="/profile.php" class="userinfo">
                    <div class='avatar'>
                        <img src=<?php echo $userSession->getAvatar(); ?>>
                    </div>
                    <div class='nombre'>
                        <?php echo $userSession->getNickname(); ?>
                    </div>
                </a>

                <div class='header-content'>
                    <li><a href="/crud_deseados/pagina_deseados.php">Deseados</a></li>
                    <li><a href="/identificacion/cierre_sesion.php">Cerrar sesión</a></li>

                    <form method="post" action="/crud_carrito/pagina_carrito.php" class="btn-carrito">
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" width="100%" height="100%"><g xmlns="http://www.w3.org/2000/svg" data-name="Layer 2"><g data-name="shopping-cart"><path d="M21.08 7a2 2 0 0 0-1.7-1H6.58L6 3.74A1 1 0 0 0 5 3H3a1 1 0 0 0 0 2h1.24L7 15.26A1 1 0 0 0 8 16h9a1 1 0 0 0 .89-.55l3.28-6.56A2 2 0 0 0 21.08 7z" style="fill: rgb(255, 255, 255);"></path><circle cx="7.5" cy="19.5" r="1.5" style="fill: rgb(255, 255, 255);"></circle><circle cx="17.5" cy="19.5" r="1.5" style="fill: rgb(255, 255, 255);"></circle></g></g></svg>
                        </button>
                    </form>
                    <!--
                        Si en la sesión hay plantas se mostrará el contador
                        Si no hay, se inicializa la array para que no salga undefined
                    -->
                    <?php if ($contadorCarrito > 0) { ?>
                        <span class="contadorCarrito"><?php echo $contadorCarrito; ?></span>
                    <?php } else {
                        $_SESSION['arrayPlantas'] = [];
                    } ?>
                </div>
            </div>
        <?php } else { ?>
            <div class='menu-user'>
                <a class="btn-registrarse" href="/identificacion/registro.php">Regístrate</a>
                <a class="btn-iniciarsesion" href="/identificacion/login.php">Inicia sesión</a>
            </div>
        <?php } ?>
    </div>
</body>

</html>