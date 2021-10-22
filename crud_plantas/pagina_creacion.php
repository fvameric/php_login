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
    <h1>Crear planta nueva:</h1>

    <form id="formRegistro" action="registrar_planta.php" method="POST" enctype="multipart/form-data">
        <label>Nombre</label>
        <input type="text" id="nombre" name="nombre"><br><br>
        
        <label>Descripcion</label>
        <input type="text" id="descripcion" name="descripcion"><br><br>

        <label>Precio</label>
        <input type="number" step="any" id="precio" name="precio"><br><br>

        <label>Stock</label>
        <input type="number" id="stock" name="stock"><br><br>

        <label>Compradas</label>
        <input type="number" id="compradas" name="compradas"><br><br>
        
        <label>Foto</label>
        <input type="file" name="file"><br><br>

        <button type="submit" name="submit" value="Registrarse">Registrar</button>
    </form>
    <br>
    <a href="../profileAdmin.php?id=<?php echo $id_admin ?>">Volver atrás</a>
</body>
</html>