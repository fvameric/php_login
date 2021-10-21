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

$filename = $_FILES["file"]["name"];

//$targetDir = "uploads/";

if (isset($_POST['aceptarmodif'])) {
    if ($filename == "") {
        $userModif->setId($id_user);
        $userModif->setNickname($nickname);
        $userModif->setEmail($email);
        $crud->modificarUsuario($userModif, $id_user);
    } else {
        $userModif->setId($id_user);
        $userModif->setNickname($nickname);
        $userModif->setEmail($email);
        $userModif->setAvatar($_FILES["file"]["name"]);
        $crud->modificarUsuario($userModif, $id_user);
    }
}
//header("Location: profileAdmin.php?id=".$id_admin);
?>