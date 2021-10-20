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

        public function validarLogin($username, $password) {
            include 'db.php';

            $sql="SELECT * FROM `users` WHERE nickname = '".$username."' AND password='".$password."'";
            $consulta = mysqli_query($con,$sql);
            
            if ($consulta) {
                $fila = $consulta->fetch_assoc();
                if ($fila['admin'] == 1) {
                    header("Location: profileAdmin.php?id=".$fila['id']);
                } else {
                    header("Location: profile.php?id=".$fila['id']);
                }
            } else {
                return null;
            }
        }

        public function eliminar($id){
            include 'db.php';
            $sqlDelete="DELETE FROM `users` WHERE id=".$id;
            $consulta = mysqli_query($con,$sqlDelete);
        }

        public function modificarUsuario($userModif){
            include 'db.php';

        }

        public function obtenerUser($id){
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