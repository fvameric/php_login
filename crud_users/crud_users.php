<?php
include_once('/conexion/db.php');
include_once('/clases/user.php');

class CrudUser
{
    private $db;
    private $listaUsers = [];

    public function __construct()
    {
        $this->db = new db();
        $this->cargarUsuarios();
    }

    public function cargarUsuarios()
    {
        $sql = "SELECT * FROM `users` WHERE 1";
        $consulta = mysqli_query($this->db->obtenerConexion(), $sql);

        while ($fila = $consulta->fetch_assoc()) {
            $newUser = new User();
            $newUser->setId($fila['id']);
            $newUser->setNickname($fila['nickname']);
            $newUser->setPassword($fila['password']);
            $newUser->setEmail($fila['email']);
            $newUser->setAvatar($fila['avatar']);
            $newUser->setAdmin($fila['admin']);

            $this->listaUsers[] = $newUser;
        }
    }

    public function obtenerListaUsuarios()
    {
        return $this->listaUsers;
    }

    public function validarLogin($nickname, $password)
    {
        foreach($this->listaUsers as $user) {
            if ($nickname == $user->getNickname() && $password == $user->getPassword()) {
                return $user;
            }
        }

        /*

        $sql = "SELECT * FROM `users` WHERE nickname = '" . $nickname . "' AND password='" . $password . "'";
        $consulta = mysqli_query($this->db->obtenerConexion(), $sql);
        $user = $consulta->fetch_assoc();
        if ($nickname == $user['nickname'] && $password == $user['password']) {
            return $user;
        } else {
            return null;
        }
        */
    }

    public function emailExiste($email)
    {
        foreach($this->listaUsers as $user) {
            if ($email == $user->getEmail()) {
                return true;
            } else {
                return false;
            }
        }
        /*
        $sql = "SELECT * FROM `users` WHERE email='" . $email . "'";
        $consultaEmail = mysqli_query($this->db->obtenerConexion(), $sql);
        $fila = $consultaEmail->fetch_assoc();
        if ($email == $fila['email']) {
            return true;
        } else {
            return false;
        }
        */
    }

    public function nicknameExiste($nickname)
    {
        foreach($this->listaUsers as $user) {
            if ($nickname == $user->getNickname()) {
                return true;
            } else {
                return false;
            }
        }

        /*

        $sql = "SELECT * FROM `users` WHERE nickname='" . $nickname . "'";
        $consultaNickname = mysqli_query($this->db->obtenerConexion(), $sql);
        $fila = $consultaNickname->fetch_assoc();
        if ($nickname == $fila['nickname']) {
            return true;
        } else {
            return false;
        }
        */
    }

    public function convertirBase64($targetFilePath)
    {
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $imageData = base64_encode(file_get_contents($targetFilePath));

        if ($fileType == 'jpg' || $fileType == 'png' || $fileType == 'gif') {
            return 'data:' . $fileType . ';base64,' . $imageData;
        } else {
            return "<br>No es una imagen<br>";
        }
    }

    public function validarRegistro($nickname, $email, $avatar)
    {
        if ($this->emailExiste($email)) {
            return "<br>El email ya está en uso<br>";
        }
        if ($this->nicknameExiste($nickname)) {
            return "<br>Este nombre de usuario ya está en uso<br>";
        }
    }

    public function agregarUser($nickname, $password, $email)
    {
        include_once '/conexion/db.php';;

        $targetDir = "uploads/";
        $filename = $_FILES["file"]["name"];
        $targetFilePath = $targetDir . $filename;

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            $src = $this->convertirBase64($targetFilePath);

            $sql = 'INSERT INTO `users` (`id` ,`nickname` ,`password`, `email`, `avatar`, `admin`)VALUES (NULL , "' . $nickname . '", "' . $password . '", "' . $email . '", "' . $src . '",0)';
            return $consulta = mysqli_query($this->db->obtenerConexion(), $sql);
        } else {
            return null;
        }
    }

    public function eliminar($id)
    {
        include_once '/conexion/db.php';;
        $sqlDelete = "DELETE FROM `users` WHERE id=" . $id;
        $consulta = mysqli_query($this->db->obtenerConexion(), $sqlDelete);
    }

    public function modificarUsuario($userModif, $id_user)
    {
        include_once '/conexion/db.php';;
        $sqlUpdate = "UPDATE `users` SET id=" . $id_user . ", nickname='" . $userModif->getNickname() . "', password='" . $userModif->getPassword() . "', email='" . $userModif->getEmail() . "', avatar='" . $userModif->getAvatar() . "' WHERE id=" . $id_user;
        $consultaUpdate = mysqli_query($this->db->obtenerConexion(), $sqlUpdate);

        if (!$consultaUpdate) {
            echo 'no se realizó la consulta';
        } else {
            echo 'se realizó la consulta';
        }
    }

    public function obtenerUserPorId($id)
    {
        foreach($this->listaUsers as $user) {
            if ($id == $user->getId()) {
                return $user;
            }
        }
        return null;
        /*
        $sqlUserId = "SELECT * FROM `users` WHERE id = '" . $id . "'";
        $consultaUser = mysqli_query($this->db->obtenerConexion(), $sqlUserId);
        $fila = $consultaUser->fetch_assoc();

        $user = new User();
        $user->setId($fila['id']);
        $user->setNickname($fila['nickname']);
        $user->setPassword($fila['password']);
        $user->setEmail($fila['email']);
        $user->setAvatar($fila['avatar']);
        $user->setAdmin($fila['admin']);
        return $user;
        */
    }
}
