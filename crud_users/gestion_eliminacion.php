<?php
include_once('crud_users.php');

$crud = new CrudUser();

if (isset($_POST['id_usuario_eliminar'])) {
    $validacionDelete = $crud->eliminarUsuario($_POST['id_usuario_eliminar']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../sweetalert2.all.js"></script>
    <title>Usuario eliminado</title>
</head>

<body>
    <?php if ($validacionDelete) { ?>
        <script>
            Swal.fire({
                title: 'Se eliminó con éxito al usuario',
                confirmButtonText: 'Volver atrás'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `../profile.php`;
                }
            });
        </script>
    <?php } ?>
    
</body>

</html>