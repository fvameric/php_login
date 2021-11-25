<?php
include_once('crud_plantas.php');
include_once('../clases/planta.php');

include_once 'pagina_modificacion.php';

$id_admin = $_POST['id_admin'];

$id_planta = $_POST['id_planta'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];
//$foto = $_POST['foto'];
$compradas = $_POST['compradas'];

$crud = new CrudPlanta();
$plantaModif = new Planta();
$plantaModif = $crud->obtenerPlantaPorId($id_planta);

$targetDir = "../uploads/";
$filename = $_FILES["file"]["name"];
$targetFilePath = $targetDir . $filename;


if (isset($_POST['aceptarmodif'])) {
    if ($filename == "") {
        
        $plantaModif->setId($id_planta);
        $plantaModif->setNombre($nombre);
        $plantaModif->setDescripcion($descripcion);
        $plantaModif->setPrecio($precio);
        $plantaModif->setStock($stock);
        $plantaModif->setCompradas($compradas);
        $crud->modificarPlanta($plantaModif, $id_planta);
        
        echo 'Se modificó la planta';

        /*
        echo 'id planta: '.$id_planta.'<br>';
        echo 'nombre: '.$nombre.'<br>';
        echo 'descripcion: '.$descripcion.'<br>';
        echo 'precio: '.$precio.'<br>';
        echo 'stock: '.$stock.'<br>';
        echo 'compradas: '.$compradas.'<br>';
        */

    } else {

        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            $src = $crud->convertirBase64($targetFilePath);
        } else {
            echo 'No se pudo mover la imagen';
        }

        
        $plantaModif->setId($id_planta);
        $plantaModif->setNombre($nombre);
        $plantaModif->setDescripcion($descripcion);
        $plantaModif->setPrecio($precio);
        $plantaModif->setStock($stock);
        $plantaModif->setFoto($src);
        $plantaModif->setCompradas($compradas);
        $crud->modificarPlanta($plantaModif, $id_planta);
        echo 'Se modificó la planta';
        
        /*
        echo 'id planta: '.$id_planta.'<br>';
        echo 'nombre: '.$nombre.'<br>';
        echo 'descripcion: '.$descripcion.'<br>';
        echo 'precio: '.$precio.'<br>';
        echo 'foto: '.$src.'<br>';
        echo 'stock: '.$stock.'<br>';
        echo 'compradas: '.$compradas.'<br>';
        */
    }
}
?>