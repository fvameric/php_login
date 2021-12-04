<?php
//obtencion users
include_once('../crud_users/crud_users.php');
include_once('../clases/user.php');

include_once('crud_plantas.php');
include_once('../clases/planta.php');

session_start();
if (isset($_SESSION['userSession'])) {
    $userSession = $_SESSION['userSession'];

    $crudUser = new CrudUser();
    $listaUsers = $crudUser->obtenerListaUsuarios();

    // obtener contador del carrito
    $contadorCarrito = 0;
    if (isset($_SESSION['arrayPlantas'])) {
        $contadorCarrito = count($_SESSION['arrayPlantas']);
    }

    $crud = new CrudPlanta();
    $planta = new Planta();
    if (isset($_POST['id_planta'])) {
        $planta = $crud->obtenerPlanta($_POST['id_planta']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar planta</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,700" />
</head>

<body>
    <div class='header'>
        <?php include_once('../html_header/navbar.php'); ?>
    </div>

    <div class="espacio">
    </div>

    <div class="enlaces-navegacion">
        <a href="../index.php">Home</a>
        <div class="flecha-navegacion">
            ▶
        </div>
        <a href="../profile.php">Perfil</a>
    </div>
    <div class="content-wrapper">
        <div class="content">
            <form action='/crud_plantas/gestion_modificacion.php' method='POST' enctype="multipart/form-data">
                <div class='modificar-user'>
                    <div class='modificar-avatar'>
                        <img src=<?php echo $planta->getFoto() ?>>
                        <input type="file" name='file'>
                    </div>
                    <div class='modificar-content'>
                        <div class='modificar-content-nombre'>
                            <label>Nombre:</label>
                            <input type="text" name="nombre" value="<?php echo $planta->getNombre() ?>">
                        </div>
                        <div class='modificar-content-email'>
                            <label>Descripcion:</label>
                            <input type="text" name="descripcion" value="<?php echo $planta->getDescripcion() ?>">
                        </div>
                        <div class='modificar-content-email'>
                            <label>Precio:</label>
                            <input type="number" step="any" name="precio" value="<?php echo $planta->getPrecio() ?>">
                        </div>
                        <div class='modificar-content-email'>
                            <label>Stock:</label>
                            <input type="number" name="stock" value="<?php echo $planta->getStock() ?>">
                        </div>
                        <div class='modificar-content-email'>
                            <label>Compradas:</label>
                            <input type="number" name="compradas" value="<?php echo $planta->getCompradas() ?>">
                        </div>
                        <div class='modificar-content-categoria'>
                            <p>Categoria actual: <?php
                                                    $cat = $planta->getCategoria();
                                                    $categoriaActual = $crud->stringCategoria($cat);
                                                    echo $categoriaActual;
                                                    ?></p>
                            <p>Categoria:</p>
                            <input type="radio" id="Aeonium" name="categoria" value="1">
                            <label for="Aeonium">Aeonium</label><br>
                            <input type="radio" id="Cotyledon" name="categoria" value="2">
                            <label for="Cotyledon">Cotyledon</label><br>
                            <input type="radio" id="Crassula" name="categoria" value="3">
                            <label for="Crassula">Crassula</label><br>
                            <input type="radio" id="Echeveria" name="categoria" value="4">
                            <label for="Echeveria">Echeveria</label><br>
                            <input type="radio" id="Euphorbia" name="categoria" value="5">
                            <label for="Euphorbia">Euphorbia</label><br>
                            <input type="radio" id="Haworthia" name="categoria" value="6">
                            <label for="Haworthia">Haworthia</label><br>
                            <input type="radio" id="Senecio" name="categoria" value="7">
                            <label for="Senecio">Senecio</label><br><br>
                        </div>
                    </div>
                    <input type='hidden' name='id_planta' value='<?php echo $planta->getId() ?>'>
                    <input type='hidden' name='actualizar' value='actualizar'>
                </div>
                <div class='aceptar-modificaciones'>
                    <input type='submit' name="aceptarmodif" value='Aceptar modificaciones'>
                </div>
            </form>
        </div>
    </div>

    <div class="espacio"></div>
    <?php include_once('../html_footer/footer.php'); ?>
</body>

</html>