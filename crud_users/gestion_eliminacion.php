<?php
    require_once('crud_users.php');

    $crud = new CrudUser();

    if (isset($_POST['id_usuario_eliminar'])) {
        $validacionDelete = $crud->eliminar($_POST['id_usuario_eliminar']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario eliminado</title>
</head>
<body>
    <?php if ($validacionDelete) { ?>
        Se eliminó al usuario con éxito.
    <?php } ?>
    <a href="../profileAdmin.php">Volver atrás</a>
</body>
</html>