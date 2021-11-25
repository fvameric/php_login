<?php
include_once('/conexion/db.php');
include_once('/clases/user.php');

class CrudUser
{
    private $db;
    private $listaUsers = [];

    function __construct()
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

    public function obtenerUserPorId($id)
    {
        foreach($this->listaUsers as $user) {
            if ($id == $user->getId()) {
                return $user;
            }
        }
        return null;
    }

    public function validarLogin($nickname, $password)
    {
        foreach($this->listaUsers as $user) {
            if ($nickname == $user->getNickname() && $password == $user->getPassword()) {
                return $user;
            }
        }
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

    public function eliminar($user)
    {
        /*
        $sqlDelete = "DELETE FROM `users` WHERE id=" . $id;
        $consulta = mysqli_query($this->db->obtenerConexion(), $sqlDelete);
        
        $flag = false;

        foreach($this->listaUsers as $value) {
            if ($value->getId() == $user->getId()) {
                $userrr = $user;
                break;
            }
        }*/

        //echo $user->getNickname();
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
}
