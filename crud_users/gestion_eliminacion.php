<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../sweetalert2.all.js"></script>
</head>
<body>
    <script type="text/javascript">
        Swal.fire({
            title: 'Do you want to save the changes?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Save',
            denyButtonText: `Don't save`,
          }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire('Saved!', '', 'success').then((result) => {
                    <?php
                        echo `header("Location: ../profileAdmin.php")`;
                    ?>
                });
                <?php
                /*
                    require_once('crud_users.php');
                    
                    $crud = new CrudUser();

                    if (isset($_POST['id_user'])) {
                        $crud->eliminar($_POST['id_user']);
                        header("Location: ../profileAdmin.php");
                    }
                    */
                ?>
                
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info');
                <?php
                /*
                    header("Location: ../profileAdmin.php");
                    */
                ?>
            }
          });
    </script>
</body>
</html>



