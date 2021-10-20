<?php
include 'db.php';

require_once('crud_users.php');
require_once('user.php');

$nickname = $_POST['nickname'];
$password = $_POST['password'];

$crudUser = new CrudUser();
$userId = $crudUser->validarLogin($nickname, $password);

?>
<?php if (is_null($userId) || empty($userId)) { ?>
    <link rel="stylesheet" href="styles.css">
    <div class="loginError">
        Nombre o contraseña incorrectos.
        <form action='login.html'>
            <button type='submit' value='Atrás'>Volver atrás</button>
        </form>
    </div>
<?php } ?>