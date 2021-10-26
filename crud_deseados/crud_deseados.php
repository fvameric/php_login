<?php
    class CrudDeseados {
        public function __construc(){}

        public function mostrar() {
            include 'db.php';

            $listaDeseados=[];

            $sql="SELECT * FROM `deseados` WHERE 1";
            $consulta = mysqli_query($con,$sql);

            while($fila=$consulta->fetch_assoc()) {
                $newDeseado = new Deseados();
                $newDeseado->setId($fila['id']);
                $newDeseado->setUserId($fila['user_id']);
                $newDeseado->setPlantaId($fila['planta_id']);

                $listaDeseados[] = $newDeseado;
            }
            return $listaDeseados;
        }

        public function agregarDeseado($user_id, $planta_id) {
            include 'db.php';

            $sql = "INSERT INTO `deseados` (`id` ,`user_id` ,`planta_id`)VALUES (NULL , '".$user_id."', '".$planta_id."')";
            return $consulta = mysqli_query($con,$sql);
        }

        public function eliminarDeseado($id_deseado) {
            include 'db.php';
            $sqlDelete="DELETE FROM `deseados` WHERE id=".$id_deseado;
            $consulta = mysqli_query($con,$sqlDelete);

            if(!$consulta) {
                echo 'no se realizó la consulta';
            } else {
                echo 'se realizó la consulta';
            }
        }

        public function modificarDeseados($deseadoModif, $id_deseado) {
            include 'db.php';
            $sqlUpdate="UPDATE `deseados` SET id=".$id_deseado.", user_id='".$deseadoModif->getUserId()."', planta_id='".$deseadoModif->getPlantaId()."')";
            $consultaUpdate = mysqli_query($con, $sqlUpdate);

            if(!$consultaUpdate) {
                echo 'no se realizó la consulta';
            } else {
                echo 'se realizó la consulta';
            }
        }

        public function obtenerDeseado($id) {
            include 'db.php';

            $sqlId="SELECT * FROM `deseados` WHERE user_id = '".$id."'";
            $consultaDeseados = mysqli_query($con, $sqlId);
            $fila = $consultaDeseados->fetch_assoc();
            
            $deseado = new Deseados();
            $deseado->setId($fila['id']);
            $deseado->setUserId($fila['user_id']);
            $deseado->setPlantaId($fila['planta_id']);
            return $deseado;
        }
    }
?>