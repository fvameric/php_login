<?php
require_once('crud_users.php');
require_once('user.php');

include 'modificar_users.php';

$id = $_POST['id'];
$nickname = $_POST['nickname'];
$password = $_POST['password'];
$email = $_POST['email'];
$avatar = $_POST['avatar'];

echo 'id: '.$id;
echo '<br>';
echo 'nickname: '.$nickname;
echo '<br>';
echo 'password: '.$password;
echo '<br>';
echo 'email: '.$email;
echo '<br>';
echo 'avatar: '.$avatar;

$crud = new CrudUser();
$userModif = new User();

/*
if (isset($_POST['id_user'])) {
    $userModif->
    $userModif->setNickname($nickname);
    $userModif->setEmail($email);
    $crud->modificarUsuario($userModif);
    header("Location: profileAdmin.php?id=".$_POST['id_admin']);
}
*/
?>