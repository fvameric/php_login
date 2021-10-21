<?php
require_once('crud_users.php');
require_once('user.php');

$crud = new CrudUser();
$user = new User();

$id = $_POST['id_admin'];
echo $id;

if (isset($_POST['id_user'])) {
    $user=$crud->obtenerUser($_POST['id_user']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form action='gestion_modificacion.php' method='POST' enctype="multipart/form-data">
        <div class='modificar-user'>
            <div class='modificar-avatar'>
                <img src=<?php echo $user->getAvatar() ?>>
                <input type="file" name='file'>
            </div>
            <div class='modificar-content'>
                <div class='modificar-content-nombre'>
                    <label>Nickname:</label>
                    <input type="text" name="nickname" value="<?php echo $user->getNickname() ?>">
                </div>
                <div class='modificar-content-email'>
                    <label>Email:</label>
                    <input type="text" name="email" value="<?php echo $user->getEmail() ?>">
                </div>
            </div>
            <input type='hidden' name='id_admin' value='<?php echo $id ?>'>
            <input type='hidden' name='id_user' value='<?php echo $user->getId() ?>'>
            <input type='hidden' name='password' value='<?php echo $user->getPassword() ?>'>
            <input type='hidden' name='actualizar' value='actualizar'>
        </div>
        <div class='aceptar-modificaciones'>
            <input type='submit' name="aceptarmodif" value='Aceptar modificaciones'>
            <a href="profileAdmin.php?id=<?php echo $id ?>">Volver atrás</a>
        </div>
    </form>
</body>
</html>
