<?php
include 'db.php';

require_once('crud_users.php');
require_once('user.php');

$nickname = $_POST['nickname'];
$password = $_POST['password'];

$crudUser = new CrudUser();

if ($nickname != "" && $password != "") {
    $userId = $crudUser->validarLogin($nickname, $password);

    if (is_null($userId) || empty($userId)) {
        echo 'Nombre o contraseña incorrectos.';

        echo "<form action='login.html'>";
            echo "<button type='submit' value='Atrás'>Volver atrás</button>";
        echo "</form>";
    }
} else {
    echo "Nombre o contraseña vacios";

    echo "<form action='login.html'>";
        echo "<button type='submit' value='Atrás'>Volver atrás</button>";
    echo "</form>";
}