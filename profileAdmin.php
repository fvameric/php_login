<?php
    include '/conexion/db.php';
    
    $id = $_GET['id'];

    //obtencion users
    require_once('/crud_users/crud_users.php');
    require_once('/clases/user.php');

    $crudUser = new CrudUser();
    $user = new User();
    $listaUsers = $crudUser->mostrar();
    $user = $crudUser->obtenerUser($id);

    //obtencion plantas
    require_once('/crud_plantas/crud_plantas.php');
    require_once('/clases/planta.php');

    $crudPlanta = new CrudPlanta();
    $planta = new Planta();
    $listaPlantas = $crudPlanta->mostrar();
    $planta = $crudPlanta->obtenerPlanta($id);
?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class='user-header'>
        <div class='avatar'>
            <img src=<?php echo $user->getAvatar() ?>>
        </div>
        <div class='user-header-content'>
            <div class='nombre'>
                <?php echo $user->getNickname() ?>
            </div>
            <div class='email'>
                <?php echo $user->getEmail() ?>
            </div>
            <form method="post" action="login.html" class="btn-cerrar-sesion">
                <button type="submit">Cerrar sesión</button>
            </form>
        </div>
    </div>

<?php if ($user->getAdmin() == 1) { ?>
    <hr>
    <div class="eresAdmin">
        <h3>Eres admin, puedes ver el resto de usuarios:</h3>
    </div>

    <div class="lista-usuarios-crear">
        <form method="POST" action="/crud_users/pagina_creacion.php">
            <input type="hidden" name="id_admin" value="<?php echo $id ?>"/>
            <input type="submit" name="crear" id="crear" value="Crear usuario"/>
        </form>
    </div>

    <div class="scroll-usuarios">
        <?php foreach($listaUsers as $usuario) { ?>
            <div class="lista-usuarios">
                <div class="lista-usuarios-avatares">
                    <img src=<?php echo $usuario->getAvatar() ?> class="lista-avatar">
                </div>
                <div class="lista-usuarios-content">
                    <div class="lista-usuarios-nombre">
                        <?php echo $usuario->getNickname() ?>
                    </div>
                    <div class="lista-usuarios-email">
                        <?php echo $usuario->getEmail(); ?>
                    </div>
                </div>
                <div class="lista-usuarios-crud">
                    <div class="lista-usuarios-modificar">
                        <form method="POST" action="/crud_users/pagina_modificacion.php">
                            <input type="hidden" name="id_admin" value="<?php echo $id ?>"/>
                            <input type="hidden" name="id_user" value="<?php echo $usuario->getId() ?>"/>
                            <input type="submit" id="modificar" value="Modificar"/>
                        </form>
                    </div>
                    <div class="lista-usuarios-eliminar">
                        <form method="POST" action="/crud_users/gestion_eliminacion.php">
                            <input type="hidden" name="id_admin" value="<?php echo $id ?>"/>
                            <input type="hidden" name="id_user" value="<?php echo $usuario->getId() ?>"/>
                            <input type="submit" id="eliminar" value="Eliminar"/>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>

<div class="lista-plantas-crear">
    <form method="POST" action="/crud_plantas/pagina_creacion.php">
        <input type="hidden" name="id_admin" value="<?php echo $id ?>"/>
        <input type="submit" name="crear" id="crear" value="Crear planta"/>
    </form>
</div>

<div class="scroll-plantas">
    <?php foreach($listaPlantas as $plantas) { ?>
        <div class="lista-plantas">
            <div class="carta">
                <div class="lista-plantas-fotos">
                    <img src=<?php echo $plantas->getFoto() ?> class="lista-fotos">
                </div>
                <div class="lista-plantas-content">
                    <div class="lista-plantas-nombre">
                        <?php echo $plantas->getNombre() ?>
                    </div>
                    <div class="lista-plantas-precio">
                        <?php echo $plantas->getPrecio() ?> €
                    </div>
                </div>
                <div class="lista-plantas-crud">
                    <div class="lista-plantas-modificar">
                        <form method="POST" action="/crud_plantas/pagina_modificacion.php">
                            <input type="hidden" name="id_admin" value="<?php echo $id ?>"/>
                            <input type="hidden" name="id_planta" value="<?php echo $plantas->getId() ?>"/>
                            <input type="submit" id="modificar" value="Modificar"/>
                        </form>
                    </div>
                    <div class="lista-plantas-eliminar">
                        <form method="POST" action="/crud_plantas/gestion_eliminacion.php">
                            <input type="hidden" name="id_admin" value="<?php echo $id ?>"/>
                            <input type="hidden" name="id_planta" value="<?php echo $plantas->getId() ?>"/>
                            <input type="submit" id="eliminar" value="Eliminar"/>
                        </form>
                    </div>
                </div>
                <div class="ver-detalles-planta">
                    <form method="POST" action="">
                        <input type="hidden" name="id_admin" value="<?php echo $id ?>"/>
                        <input type="hidden" name="id_planta" value="<?php echo $plantas->getId() ?>"/>
                        <input type="submit" id="detalles" value="Ver detalle"/>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
</body>
</html>