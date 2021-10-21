<?php
    class CrudUser {
        public function __construc(){}

        // mostrará solo usuarios no admin
        public function mostrar() {
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
        }

        public function validarLogin($nickname, $password) {
            include 'db.php';

            $sql="SELECT * FROM `users` WHERE nickname = '".$nickname."' AND password='".$password."'";
            $consulta = mysqli_query($con,$sql);
            $fila = $consulta->fetch_assoc();
            if ($nickname == $fila['nickname'] && $password == $fila['password']) {
                if ($fila['admin'] == 1) {
                    header("Location: profileAdmin.php?id=".$fila['id']);
                } else {
                    header("Location: profile.php?id=".$fila['id']);
                }
            } else {
                return null;
            }
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

        public function convertirBase64($targetFilePath) {
            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
            $imageData = base64_encode(file_get_contents($targetFilePath));

            if ($fileType == 'jpg' || $fileType == 'png' || $fileType == 'gif') {
                return 'data:'.$fileType.';base64,' . $imageData;
            } else {
                return "<br>No es una imagen<br>";
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

        public function agregarUser($nickname, $password, $email, $avatar) {
            include 'db.php';

            $str = "";

            $targetDir = "uploads/";
            $filename = $_FILES["file"]["name"];
            $targetFilePath = $targetDir . $filename;

            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath))
            {
                $src = $this->convertirBase64($targetFilePath);

                $sql = 'INSERT INTO `users` (`id` ,`nickname` ,`password`, `email`, `avatar`, `admin`)VALUES (NULL , "'.$nickname.'", "'.$password.'", "'.$email.'", "'.$src.'",0)';
                return $consulta = mysqli_query($con,$sql);
            } else {
                return null;
            }
        }

        public function eliminar($id){
            include 'db.php';
            $sqlDelete="DELETE FROM `users` WHERE id=".$id;
            $consulta = mysqli_query($con,$sqlDelete);
        }

        public function modificarUsuario($userModif, $id_user){
            include 'db.php';
            $sqlUpdate="UPDATE `users` SET id=".$id_user.", nickname='".$userModif->getNickname()."', password='".$userModif->getPassword()."', email='".$userModif->getEmail()."', avatar='".$userModif->getAvatar()."' WHERE id=".$id_user;
            $consultaUpdate = mysqli_query($con, $sqlUpdate);
        }

        public function obtenerUser($id) {
            include 'db.php';

            $sqlUserId="SELECT * FROM `users` WHERE id = '".$id."'";
            $consultaUser = mysqli_query($con, $sqlUserId);
            $fila = $consultaUser->fetch_assoc();
            
            $newUser = new User();
            $newUser->setId($fila['id']);
            $newUser->setNickname($fila['nickname']);
            $newUser->setPassword($fila['password']);
            $newUser->setEmail($fila['email']);
            $newUser->setAvatar($fila['avatar']);
            $newUser->setAdmin($fila['admin']);
            return $newUser;
        }
    }
?>