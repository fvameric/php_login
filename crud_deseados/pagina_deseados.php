<?php
// include clases
include_once('../clases/user.php');
include_once('../clases/planta.php');
include_once('../clases/deseados.php');

// include cruds
include_once('../crud_plantas/crud_plantas.php');
include_once('crud_deseados.php');

session_start();
if (isset($_SESSION['userSession'])) {
    
    // variables de sesión
    $userSession = $_SESSION['userSession'];

    // cruds
    $crudDeseados = new CrudDeseados();
    $crudPlanta = new CrudPlanta();

    // obtención de elementos de la BD
    $listaDeseados = $crudDeseados->obtenerDeseadosPorLogin($userSession);
    $listaPlantas = $crudPlanta->obtenerListaPlantas();

    // obtener contador del carrito
    $contadorCarrito = 0;
    if (isset($_SESSION['arrayPlantas'])) {
        $contadorCarrito = count($_SESSION['arrayPlantas']);
    }

    // obtener una lista de plantas que coincidan con el usuario logueado y la planta
    foreach ($listaDeseados as $deseado) {
        foreach ($listaPlantas as $plantas) {
            if ($plantas->getId() == $deseado->getPlantaId()) {
                $plantasDeseadas[] = $plantas;
            }
        }
    }

    // si se pulsa el botón de crear XML
    if (isset($_POST['descargarXML'])) {
       $crudDeseados->crearXML($plantasDeseadas);
    }

    // si se pulsa el botón de cargar XML y antes se ha seleccionado un archivo XML
    if (isset($_POST['cargarXML'])) {
        if (!empty($_FILES["file"]["tmp_name"])) {
            $crudDeseados->cargarXML($userSession, $_FILES["file"]["tmp_name"]);
            header('Location: pagina_deseados.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deseados</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,700" />
    <script src="/buscador.js"></script>
</head>

<body>
    <div class='header'>
        <?php include_once('../html_header/navbar.php') ?>
    </div>

    <div class="espacio">
    </div>

    <div class="enlaces-navegacion">
        <a href="../index.php">Home</a>
        <div class="flecha-navegacion">
            ▶
        </div>
        <a href="../profile.php">Perfil</a>
        <div class="flecha-navegacion">
            ▶
        </div>
        <a href="pagina_deseados.php">Deseados</a>
    </div>

    <?php if (!empty($plantasDeseadas)) { ?>
        <div class="content-wrapper">
            <div class="content">
                <div class="descargar-xml">
                    <form method="POST" action="">
                        <button type="submit" name="descargarXML">Crear XML</button>
                    </form>
                </div>
                <div class="scroll-plantas">
                    <?php foreach ($plantasDeseadas as $plantas) { ?>
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
                                    <div class="agregar-deseados">
                                        <?php $idDeseado = $crudDeseados->obtenerDeseado($plantas->getId(), $userSession->getId());

                                        if ($idDeseado != null) { ?>
                                            <div class="quitar-deseado">
                                                <form method="POST" action="gestion_eliminacion.php" class="btn-quitar-deseado">
                                                    <input type="hidden" name="id_deseado" value="<?php echo $idDeseado->getId() ?>" />
                                                    <button type="submit" name="quitarDeseado">★</button>
                                                </form>
                                            </div>
                                        <?php } else { ?>
                                            <div class="agregar-deseado">
                                                <form method="POST" action="gestion_creacion.php" class="btn-agregar-deseado">
                                                    <input type="hidden" name="id_planta" value="<?php echo $plantas->getId() ?>" />
                                                    <button type="submit" name="add">☆</button>
                                                </form>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="ver-detalles-planta">
                                    <form method="GET" action="../ver_detalle.php">
                                        <input type="hidden" name="id_planta" value="<?php echo $plantas->getId() ?>" />
                                        <input type="submit" id="detalles" value="Ver detalle" />
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="no-content">
            <h2>No tienes deseados<h2>
        </div>
        <div class="cargar-xml">
            <form method="POST" action="" enctype="multipart/form-data">
                <label>Fichero xml:</label><br>
                <input type="file" name="file"><br><br>
                <button type="submit" name="cargarXML">Cargar fichero XML</button>
            </form>
        </div>
    <?php } ?>

    <div class="espacio"></div>
    <?php include_once('../html_footer/footer.php'); ?>
</body>

</html>