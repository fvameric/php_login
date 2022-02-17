<?php
// include clases
include_once('../clases/user.php');
include_once('../clases/planta.php');

// include cruds
include_once('../crud_users/crud_users.php');
include_once('crud_plantas.php');

session_start();
if (isset($_SESSION['userSession'])) {

    // variables de sesión
    $userSession = $_SESSION['userSession'];

    // cruds
    $crudUser = new CrudUser();
    $crudPlanta = new CrudPlanta();

    // objetos
    $planta = new Planta();

    // obtención de elementos de la BD
    $listaUsers = $crudUser->obtenerListaUsuarios();

    // obtener contador del carrito
    $contadorCarrito = 0;
    if (isset($_SESSION['arrayPlantas'])) {
        $contadorCarrito = count($_SESSION['arrayPlantas']);
    }

    // obtener planta por su ID
    if (isset($_POST['id_planta'])) {
        $planta = $crudPlanta->obtenerPlanta($_POST['id_planta']);
        $cat = $planta->getCategoria();
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
    <link rel="stylesheet" href="/styles/global.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,700" />
    <script src="../jquery-3.6.0.js"></script>
    <script src="../preview.js"></script>
</head>

<body>
    <div class='header'>
        <?php include_once('../html_header/navbar.php'); ?>
    </div>

    <div class="espacio">
    </div>

    <div class="content-wrapper">
        <div class="content">
            <div class="enlaces-navegacion">
                <a href="../index.php">Home</a>
                <div class="flecha-navegacion">
                    ▶
                </div>
                <a href="../profile.php">Perfil</a>
            </div>
            <div class="modificar-usuario-estilo">
                <form action='/crud_plantas/gestion_modificacion.php' method='POST' enctype="multipart/form-data">
                    <div class='modificar-user'>
                        <div class='modificar-avatar'>
                            <div id="preview"><img src=<?php echo $planta->getFoto() ?>></div>
                            <input onChange="previsualizar(this)" type="file" name="file" id="#imagen"><br><br>
                        </div>
                        <div class='modificar-content'>
                            <div class="modif-atributos">
                                <div class='modificar-content-nombre'>
                                    <label>Nombre:</label><br>
                                    <input type="text" name="nombre" value="<?php echo $planta->getNombre() ?>">
                                </div>
                                <div class='modificar-content-email'>
                                    <label>Descripcion:</label><br>
                                    <input type="text" name="descripcion" value="<?php echo $planta->getDescripcion() ?>">
                                </div>
                                <div class='modificar-content-email'>
                                    <label>Precio:</label><br>
                                    <input type="number" step="any" name="precio" value="<?php echo $planta->getPrecio() ?>">
                                </div>
                                <div class='modificar-content-email'>
                                    <label>Stock:</label><br>
                                    <input type="number" name="stock" value="<?php echo $planta->getStock() ?>">
                                </div>
                                <div class='modificar-content-email'>
                                    <label>Compradas:</label><br>
                                    <input type="number" name="compradas" value="<?php echo $planta->getCompradas() ?>">
                                </div>
                            </div>
                            <div class='modificar-content-categoria'>
                                <p>Categoria:</p>
                                <?php if ($cat == 1) { ?>
                                    <input type="radio" id="Aeonium" name="categoria" value="1" checked>
                                <?php } else { ?>
                                    <input type="radio" id="Aeonium" name="categoria" value="1">
                                <?php } ?>
                                <label for="Aeonium">Aeonium</label><br>

                                <?php if ($cat == 2) { ?>
                                    <input type="radio" id="Cotyledon" name="categoria" value="2" checked>
                                <?php } else { ?>
                                    <input type="radio" id="Cotyledon" name="categoria" value="2">
                                <?php } ?>
                                <label for="Cotyledon">Cotyledon</label><br>

                                <?php if ($cat == 3) { ?>
                                    <input type="radio" id="Crassula" name="categoria" value="3" checked>
                                <?php } else { ?>
                                    <input type="radio" id="Crassula" name="categoria" value="3">
                                <?php } ?>
                                <label for="Crassula">Crassula</label><br>

                                <?php if ($cat == 4) { ?>
                                    <input type="radio" id="Echeveria" name="categoria" value="4" checked>
                                <?php } else { ?>
                                    <input type="radio" id="Echeveria" name="categoria" value="4">
                                <?php } ?>
                                <label for="Echeveria">Echeveria</label><br>

                                <?php if ($cat == 5) { ?>
                                    <input type="radio" id="Euphorbia" name="categoria" value="5" checked>
                                <?php } else { ?>
                                    <input type="radio" id="Euphorbia" name="categoria" value="5">
                                <?php } ?>
                                <label for="Euphorbia">Euphorbia</label><br>

                                <?php if ($cat == 6) { ?>
                                    <input type="radio" id="Haworthia" name="categoria" value="6" checked>
                                <?php } else { ?>
                                    <input type="radio" id="Haworthia" name="categoria" value="6">
                                <?php } ?>
                                <label for="Haworthia">Haworthia</label><br>

                                <?php if ($cat == 7) { ?>
                                    <input type="radio" id="Senecio" name="categoria" value="7" checked>
                                <?php } else { ?>
                                    <input type="radio" id="Senecio" name="categoria" value="7">
                                <?php } ?>
                                <label for="Senecio">Senecio</label><br>
                            </div>
                        </div>
                        <input type='hidden' name='id_planta' value='<?php echo $planta->getId() ?>'>
                    </div>
                    <div class='aceptar-modificaciones'>
                        <input type='submit' name="aceptarmodif" value='Aceptar modificaciones'>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="espacio"></div>
    <?php //include_once('../html_footer/footer.php'); 
    ?>
</body>

</html>