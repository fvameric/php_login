<?php
//obtencion deseados
include_once('crud_deseados.php');
include_once('../clases/deseados.php');

//obtencion deseados
include_once('../clases/user.php');

//obtencion plantas
include_once('../crud_plantas/crud_plantas.php');
include_once('../clases/planta.php');

session_start();
if (isset($_SESSION['userSession'])) {
    //variables
    $userSession = $_SESSION['userSession'];

    //cruds
    $crudDeseados = new CrudDeseados();
    $listaDeseados = $crudDeseados->obtenerListaDeseados();

    $crudPlanta = new CrudPlanta();
    $planta = new Planta();
    $listaPlantas = $crudPlanta->obtenerListaPlantas();

    foreach ($listaDeseados as $deseado) {
        if ($deseado->getUserId() == $userSession->getId()) {
            foreach ($listaPlantas as $plantas) {
                if ($plantas->getId() == $deseado->getPlantaId()) {
                    $plantasDeseadas[] = $plantas;
                }
            }
        }
    }

    if (isset($_POST['descargarXML'])) {
        $xml = new SimpleXMLElement('<xml/>');
        foreach ($plantasDeseadas as $p) {
            $planta = $xml->addChild('planta');
            $planta->addChild('id', $p->getId());
            $planta->addChild('nombre', $p->getNombre());
            $planta->addChild('descripcion', $p->getDescripcion());
            $planta->addChild('precio', $p->getPrecio());
            $planta->addChild('stock', $p->getStock());
            $planta->addChild('foto', $p->getFoto());
            $planta->addChild('compradas', $p->getCompradas());
            $planta->addChild('categoria', $p->getCategoria());
        }

        $xml->preserveWhiteSpace = false;
        $xml->formatOutput = true;

        $contenidoXML = $xml->asXML();
        $file = fopen('../plantas.xml', 'w');
        fwrite($file, $contenidoXML);
        fclose($file);
    }
    $validacionFichero = false;
    if (isset($_POST['cargarXML'])) {
        if (!empty($_FILES["file"]["tmp_name"])) {
            $validacionFichero = true;
            $path = $_FILES["file"]["tmp_name"];
            $xml = simplexml_load_file($path);

            foreach ($xml as $valor) {
                if ($valor->id != 0) {
                    $crudDeseados->agregarDeseado($userSession->getId(), $valor->id);
                }
            }

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

    <script>
        function myFunction() {
            var input, filter, cartas, splitArray, textoCarta, i;
            input = document.getElementById('myInput');
            filtro = input.value.toUpperCase();
            cartas = document.getElementsByClassName('lista-plantas');

            for (i = 0; i < cartas.length; i++) {
                splitArray = cartas[i].innerText.split("\n");
                textoCarta = splitArray[0];

                if (textoCarta.toUpperCase().indexOf(filtro) > -1) {
                    cartas[i].style.display = "";
                } else {
                    cartas[i].style.display = "none";
                }
            }
        }
    </script>
</head>

<body>
    <div class='header'>
        <div class='topbar'>
            <div class="menu-logo">
                <a href="../index.php" class="logo">
                    <img src="../images/logo.png" />
                </a>
            </div>
            <div class='header-userinfo'>
                <?php if ($userSession->getId() == 0) { ?>
                    <a href="../profile.php" class="userinfo">
                        <div class='avatar'>
                            <img src=<?php echo $userSession->getAvatar(); ?>>
                        </div>
                        <div class='nombre'>
                            <?php echo $userSession->getNickname(); ?>
                        </div>
                    </a>
                <?php } else { ?>
                    <a href="../profileAdmin.php" class="userinfo">
                        <div class='avatar'>
                            <img src=<?php echo $userSession->getAvatar(); ?>>
                        </div>
                        <div class='nombre'>
                            <?php echo $userSession->getNickname(); ?>
                        </div>
                    </a>
                <?php } ?>

                <div class='header-content'>
                    <li><a href="/crud_deseados/pagina_deseados.php">Deseados</a></li>
                    <li><a href="../identificacion/cierre_sesion.php">Cerrar sesión</a></li>

                    <form method="post" action="/crud_carrito/pagina_carrito.php" class="btn-carrito">
                        <button>&#128722;</button>
                    </form>
                </div>
                <?php
                if (isset($_SESSION['arrayPlantas'])) {
                    if (count($_SESSION['arrayPlantas']) > 0) { ?>
                        <span class="contadorCarrito"><?php echo count($_SESSION['arrayPlantas']); ?></span>
                    <?php } ?>
                <?php } else {
                    $_SESSION['arrayPlantas'] = [];
                } ?>
            </div>
        </div>

        <div class="menu-navegacion">
            <form method="POST" action="" class="buscador">
                <input type="text" id="myInput" class="barra-buscador" onkeyup="myFunction()" placeholder="Buscador">
            </form>
        </div>
    </div>

    <div class="espacio">
    </div>

    <div class="enlaces-navegacion">
        <a href="../index.php">Home</a>
        <div class="flecha-navegacion">
            ▶
        </div>
        <?php if ($userSession->getAdmin() == 0) { ?>
            <a href="../profile.php">Perfil</a>
        <?php } else { ?>
            <a href="../profileAdmin.php">Perfil</a>
        <?php } ?>
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
                                        <?php
                                        $idDeseado = $crudDeseados->obtenerDeseado($plantas->getId(), $userSession->getId());

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

            <?php if (!$validacionFichero) { ?>
                <div>
                    Selecciona un fichero XML.
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</body>

</html>