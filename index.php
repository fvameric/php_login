<?php
    include('/conexion/db.php');
    
    //obtencion plantas
    require_once('/crud_plantas/crud_plantas.php');
    require_once('/clases/planta.php');

    $crudPlanta = new CrudPlanta();
    $planta = new Planta();
    $listaPlantas = $crudPlanta->mostrar();
?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
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

    <div class="presentacion">
    </div>

    <div class="content">
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
                        <div class="ver-detalles-planta">
                            <form method="POST" action="ver_detalle.php">
                                <input type="hidden" name="id_admin" value="<?php echo $id ?>"/>
                                <input type="hidden" name="id_planta" value="<?php echo $plantas->getId() ?>"/>
                                <input type="submit" id="detalles" value="Ver detalle"/>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>