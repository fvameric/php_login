<!-- Barra de usuario -->

<div class='topbar'>
    <div class="menu-logo">
        <a href="/index.php" class="logo">
            <img src="/images/logo.png" />
        </a>
    </div>
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
                    <button>&#128722;</button>
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