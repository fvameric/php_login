<?php
    session_start();
    if (isset($_SESSION['sessionID'])) {
        $id_admin = $_SESSION['sessionID'];
    } else {
        header("Location: ../index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear planta</title>
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
        <a href="pagina_creacion.php">Creación de plantas</a>
    </div>
    <h1>Crear planta nueva:</h1>

    <form id="formRegistro" action="registrar_planta.php" method="POST" enctype="multipart/form-data">
        <label>Nombre</label><br>
        <textarea type="text" id="nombre" name="nombre"></textarea><br><br>
        
        <label>Descripcion</label><br>
        <textarea type="text" id="descripcion" name="descripcion"></textarea><br><br>

        <label>Precio</label><br>
        <input type="number" step="any" id="precio" name="precio"><br><br>

        <label>Stock</label><br>
        <input type="number" id="stock" name="stock"><br><br>

        <label>Compradas</label><br>
        <input type="number" id="compradas" name="compradas"><br><br>
        
        <label>Foto</label><br>
        <input type="file" name="file"><br><br>

        <p>Categoria:</p>
        <input type="radio" id="Aeonium" name="categoria" value="1">
        <label for="Aeonium">Aeonium</label><br>
        <input type="radio" id="Cotyledon" name="categoria" value="2">
        <label for="Cotyledon">Cotyledon</label><br>
        <input type="radio" id="Crassula" name="categoria" value="3">
        <label for="Crassula">Crassula</label><br>
        <input type="radio" id="Echeveria" name="categoria" value="4">
        <label for="Echeveria">Echeveria</label><br>
        <input type="radio" id="Euphorbia" name="categoria" value="5">
        <label for="Euphorbia">Euphorbia</label><br>
        <input type="radio" id="Haworthia" name="categoria" value="6">
        <label for="Haworthia">Haworthia</label><br>
        <input type="radio" id="Senecio" name="categoria" value="7">
        <label for="Senecio">Senecio</label><br><br>

        <button type="submit" name="submit" value="Registrarse">Registrar</button>
    </form>
    <br>
    <a href="../profileAdmin.php">Volver atrás</a>
</body>
</html>