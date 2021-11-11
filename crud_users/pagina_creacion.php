<?php
$id_admin = $_POST['id_admin'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="enlaces-navegacion">
        <a href="../index.php">Home</a>
        <div class="flecha-navegacion">
            ▶
        </div>
        <a href="../profileAdmin.php">Perfil</a>
        <div class="flecha-navegacion">
            ▶
        </div>
        <a href="pagina_creacion.php">Creación de usuarios</a>
    </div>

    <div class="content">
        <div class="crear-nuevo-usuario">
            <h2>Crear usuario nuevo:</h2>

            <form id="formRegistro" action="../registro.php" method="POST" enctype="multipart/form-data">
                <label>Avatar</label>
                <input type="file" name="file"><br><br>

                <label>Email</label>
                <input type="email" id="email" name="email"><br><br>

                <label>Nickname</label>
                <input type="text" id="nickname" name="nickname"><br><br>
                
                <label>Contraseña</label>
                <input type="password" id="password" name="password"><br><br>
                
                <button type="submit" name="submit" value="Registrarse">Registrar</button>
            </form>
        </div>
    </div>
</body>
</html>