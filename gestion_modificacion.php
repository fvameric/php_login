<?php
require_once('crud_users.php');
require_once('user.php');

require_once 'modificar_users.php';

$id_admin = $_POST['id_admin'];

$id_user = $_POST['id_user'];
$nickname = $_POST['nickname'];
$password = $_POST['password'];
$email = $_POST['email'];

$crud = new CrudUser();
$userModif = new User();
$userModif = $crud->obtenerUser($id_user);

//$targetDir = "uploads/";

$targetDir = "uploads/";
$filename = $_FILES["file"]["name"];
$targetFilePath = $targetDir . $filename;

if (isset($_POST['aceptarmodif'])) {
    if ($filename == "") {
        $userModif->setId($id_user);
        $userModif->setNickname($nickname);
        $userModif->setEmail($email);
        $crud->modificarUsuario($userModif, $id_user);
        echo 'Se modificó el usuario';
    } else {
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            $src = $crud->convertirBase64($targetFilePath);
        } else {
            echo 'No se pudo mover la imagen';
        }
        $userModif->setId($id_user);
        $userModif->setNickname($nickname);
        $userModif->setEmail($email);
        $userModif->setAvatar($src);
        $crud->modificarUsuario($userModif, $id_user);
        echo 'Se modificó el usuario';
    }
}
//header("Location: profileAdmin.php?id=".$id_admin);
?>