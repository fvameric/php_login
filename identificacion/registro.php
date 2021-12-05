<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda registro</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,700" />
    <script src="../jquery-3.6.0.js"></script>
    <script src="../preview.js"></script>
</head>

<body>
    <div class='header'>
        <?php include_once('../html_header/navbar.php'); ?>
    </div>

    <div class="espacio">
    </div>

    <div class="content-wrapper">
        <div class="crear-nuevo-usuario">
            <h2>Registro:</h2>

            <form id="formRegistro" action="gestion_registro.php" method="POST" enctype="multipart/form-data">
                <div id="preview" class="avatar-perfil"><img src="/images/avatardefault.png" ></div>

                <label>Avatar</label><br>
                <input onChange="previsualizar(this)" type="file" name="file" id="#imagen"><br><br>
                
                <label>Email</label><br>
                <input type="email" name="email"><br><br>

                <label>Nickname</label><br>
                <input type="text" name="nickname"><br><br>

                <label>Contraseña</label><br>
                <input type="password" name="password"><br><br>

                <button type="submit" name="submit" value="Registrarse">Registrar</button>
            </form>
        </div>
    </div>

    <div class="espacio"></div>
    <?php include_once('../html_footer/footer.php'); ?>
</body>

</html>