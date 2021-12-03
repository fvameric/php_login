<?php
    //archivo DB antiguo
    if (is_file("conexion/db.php")) {
        include_once('conexion/db.php');
    } else {
        include_once('../conexion/db.php');
    }

    // clase BD
    if (is_file("conexion/bd.php")) {
        include_once('conexion/bd.php');
    } else {
        include_once('../conexion/bd.php');
    }

    if (is_file("clases/user.php")) {
        include_once('clases/user.php');
    } else {
        include_once('../clases/user.php');
    }
    class CrudUser {

        private $bd;
        private $listaUsuarios = [];

        public function __construct(){
            $this->bd = new claseBD();
            $this->cargarUsuarios();
        }

        public function cargarUsuarios() {
            $sql = "SELECT * FROM `users` WHERE 1";
            $consulta = mysqli_query($this->bd->obtenerConexion(), $sql);

            while($fila = $consulta->fetch_assoc()) {
                $newUser = new User();
                $newUser->setId($fila['id']);
                $newUser->setNickname($fila['nickname']);
                $newUser->setPassword($fila['password']);
                $newUser->setEmail($fila['email']);
                $newUser->setAvatar($fila['avatar']);
                $newUser->setAdmin($fila['admin']);

                $this->listaUsuarios[] = $newUser;
            }
        }

        public function obtenerListaUsuarios() {
            /*
            include 'db.php';

            $listaUsers=[];

            $sql="SELECT * FROM `users` WHERE admin=0";
            $consulta = mysqli_query($con,$sql);

            while($fila=$consulta->fetch_assoc()) {
                $newUser = new User();
                $newUser->setId($fila['id']);
                $newUser->setNickname($fila['nickname']);
                $newUser->setPassword($fila['password']);
                $newUser->setEmail($fila['email']);
                $newUser->setAvatar($fila['avatar']);
                $newUser->setAdmin($fila['admin']);

                $listaUsers[] = $newUser;
            }
            return $listaUsers;
            */

            return $this->listaUsuarios;
        }

        function borrarEspacios($str) {
            return preg_replace('/\s+/', '', $str);
        }

        function encriptarPassword($password) {
            $password_crypt = crypt($password,'$5$rounds=5000$stringforsalt$');
            $arrPassword = explode("$", $password_crypt);
            return $arrPassword[4];
        }

        public function validarLogin($nickname, $password) {
            include 'db.php';

            $sql="SELECT * FROM `users` WHERE nickname = '".$nickname."' AND password='".$password."'";
            $consulta = mysqli_query($con,$sql);
            $user = $consulta->fetch_assoc();
            if ($nickname == $user['nickname'] && $password == $user['password']) {
                return $user;
            } else {
                return null;
            }
        }

        public function validarLoginUser($nickname, $password) {
            foreach ($this->listaUsuarios as $usuario) {
                echo 'userr: '.$usuario->getNickname();
                echo '<br>';
                echo 'userrpass: '.$usuario->getPassword();
                if ($nickname == $usuario->getNickname() && $password == $usuario->getPassword()) {
                    return $usuario;
                }
            }
            return null;
        }

        public function emailExiste($email) {
            include 'db.php';
            $sql="SELECT * FROM `users` WHERE email='".$email."'";
            $consultaEmail = mysqli_query($con,$sql);
            $fila = $consultaEmail->fetch_assoc();
            if ($email == $fila['email']) {
                return true;
            } else {
                return false;
            }
        }

        public function nicknameExiste($nickname) {
            include 'db.php';
            $sql="SELECT * FROM `users` WHERE nickname='".$nickname."'";
            $consultaNickname = mysqli_query($con,$sql);
            $fila = $consultaNickname->fetch_assoc();
            if ($nickname == $fila['nickname']) {
                return true;
            } else {
                return false;
            }
        }

        public function convertirBase64($filename, $path) {
            $fileType = pathinfo($filename,PATHINFO_EXTENSION);
            $imageData = base64_encode(file_get_contents($path));

            if ($fileType == 'jpg' || $fileType == 'png' || $fileType == 'gif') {
                return 'data:'.$fileType.';base64,' . $imageData;
            } else {
                return "<br>No es una imagen<br>";
            }
        }
        
        public function agregarUser($nickname, $password, $email, $filename, $path) {
            include 'db.php';

            $src = $this->convertirBase64($filename, $path);

            $sql = 'INSERT INTO `users` (`id` ,`nickname` ,`password`, `email`, `avatar`, `admin`)VALUES (NULL , "'.$nickname.'", "'.$password.'", "'.$email.'", "'.$src.'",0)';
            $consulta = mysqli_query($con,$sql);
            
            if ($consulta) {
                return true;
            } else {
                return false;
            }
        }

        public function validarRegistro($nickname, $email, $avatar) {
            if ($this->emailExiste($email)) {
                return "<br>El email ya está en uso<br>";
            }
            if ($this->nicknameExiste($nickname)) {
                return "<br>Este nombre de usuario ya está en uso<br>";
            }          
        }

        public function eliminarUsuario($id){
            include 'db.php';
            $sqlDelete="DELETE FROM `users` WHERE id=".$id;
            $consultaDelete = mysqli_query($con,$sqlDelete);

            if($consultaDelete) {
                return true;
            } else {
                return false;
            }
        }

        public function modificarUsuario($userModif, $id_user){
            include 'db.php';
            $sqlUpdate="UPDATE `users` SET id=".$id_user.", nickname='".$userModif->getNickname()."', password='".$userModif->getPassword()."', email='".$userModif->getEmail()."', avatar='".$userModif->getAvatar()."' WHERE id=".$id_user;
            $consultaUpdate = mysqli_query($con, $sqlUpdate);

            if($consultaUpdate) {
                return true;
            } else {
                return false;
            }
        }

        public function obtenerUser($id) {
            include 'db.php';

            $sqlUserId="SELECT * FROM `users` WHERE id = '".$id."'";
            $consultaUser = mysqli_query($con, $sqlUserId);
            $fila = $consultaUser->fetch_assoc();
            
            $user = new User();
            $user->setId($fila['id']);
            $user->setNickname($fila['nickname']);
            $user->setPassword($fila['password']);
            $user->setEmail($fila['email']);
            $user->setAvatar($fila['avatar']);
            $user->setAdmin($fila['admin']);
            return $user;
        }
    }
?>