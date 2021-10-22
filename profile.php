<?php
    include('/conexion/db.php');

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
            <img src=<?php echo $user->getAvatar(); ?>>
        </div>
        <div class='user-header-content'>
            <div class='nombre'>
                <?php echo $user->getNickname(); ?>
            </div>
            <div class='email'>
                <?php echo $user->getEmail(); ?>
            </div>
            <form method="post" action="login.html" class="btn-cerrar-sesion">
                <button type="submit">Cerrar sesión</button>
            </form>
        </div>
    </div>

    <?php foreach($listaPlantas as $plantas) { ?>
        <div class="lista-plantas">
            <div class="lista-plantas-fotos">
                <img src=<?php echo $plantas->getFoto() ?> class="lista-fotos">
            </div>
            <div class="lista-plantas-content">
                <div class="lista-usuarios-nombre">
                    <?php echo $plantas->getNombre() ?>
                </div>
                <div class="lista-usuarios-precio">
                    <?php echo $plantas->getPrecio() ?> €
                </div>
                <div class="lista-plantas-descripcion">
                    <?php echo $plantas->getDescripcion(); ?>
                </div>
            </div>
            <div class="lista-plantas-crud">
                <div class="lista-usuarios-modificar">
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
        </div>
    <?php } ?>
</body>
</html>
