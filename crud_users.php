<?php


    class CrudUser {
        public function __construc(){}

        public function mostrar() {
            include 'db.php';

            $listaUsers=[];

            $sql="SELECT * FROM `users` WHERE 1";
            $consulta = mysqli_query($con,$sql);

            while($fila=$consulta->fetch_assoc()) {
                $newUser = new User();
                //$newUser->setId($fila['id']);
                $newUser->setNombre($fila['nickname']);
                $newUser->setPassword($fila['password']);
                $newUser->setEmail($fila['email']);
                $newUser->setAvatar($fila['avatar']);
                $newUser->setAdmin($fila['admin']);

                $listaUsers[] = $newUser;
            }
            return $listaUsers;
        }

        public function eliminar($id){
            $sqlDelete="DELETE FROM `users` WHERE id='".$id."'";

            if ($consulta = mysqli_query($con,$sqlDelete) === true) {
                echo 'Se eliminó el usuario';
            } else {
                echo 'No se pudo eliminar el usuario';
            }
        }
    }
?>