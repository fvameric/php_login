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
    <h1>Crear usuario nuevo:</h1>

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
    <br>
    <a href="../profileAdmin.php?id=<?php echo $id_admin ?>">Volver atrás</a>
</body>
</html>