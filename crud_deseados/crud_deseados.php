<?php
    // clase BD
    if (is_file("conexion/bd.php")) {
        include_once('conexion/bd.php');
    } else {
        include_once('../conexion/bd.php');
    }
    
    if (is_file("clases/deseados.php")) {
        include_once('clases/deseados.php');
    } else {
        include_once('../clases/deseados.php');
    }
    class CrudDeseados {

        private $bd;
        private $listaDeseados = [];

        public function __construct(){
            $this->bd = new claseBD();
            $this->cargarDeseados();
        }

        public function cargarDeseados() {
            $sql = "SELECT * FROM `deseados` WHERE 1";
            $consulta = mysqli_query($this->bd->obtenerConexion(), $sql);

            while($fila = $consulta->fetch_assoc()) {
                $newDeseado = new Deseados();
                $newDeseado->setId($fila['id']);
                $newDeseado->setUserId($fila['user_id']);
                $newDeseado->setPlantaId($fila['planta_id']);

                $this->listaDeseados[] = $newDeseado;
            }
        }

        public function obtenerListaDeseados() {
            return $this->listaDeseados;
        }

        public function obtenerDeseado($id_planta, $id_user) {
            foreach ($this->listaDeseados as $deseado) {
                if ($id_planta == $deseado->getPlantaId() && $id_user == $deseado->getUserId()) {
                    return $deseado;
                }
            }
            return null;
        }

        public function agregarDeseado($user_id, $planta_id) {
            $sql = "INSERT INTO `deseados` (`id` ,`user_id` ,`planta_id`)VALUES (NULL , '".$user_id."', '".$planta_id."')";
            $consulta = mysqli_query($this->bd->obtenerConexion(), $sql);
        }

        public function eliminarDeseado($id_deseado) {
            $sqlDelete="DELETE FROM `deseados` WHERE id=".$id_deseado;
            $consulta = mysqli_query($this->bd->obtenerConexion(), $sqlDelete);
        }

        public function modificarDeseados($deseadoModif, $id_deseado) {
            $sqlUpdate="UPDATE `deseados` SET id=".$id_deseado.", user_id=".$deseadoModif->getUserId().", planta_id=".$deseadoModif->getPlantaId().")";
            $consultaUpdate = mysqli_query($this->bd->obtenerConexion(), $sqlUpdate);
        }
    }
?>