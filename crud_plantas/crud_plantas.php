<?php
    class CrudPlanta {
        public function __construc(){}

        public function mostrar() {
            include 'db.php';

            $listaPlantas=[];

            $sql="SELECT * FROM `plantas` WHERE 1";
            $consulta = mysqli_query($con,$sql);

            while($fila=$consulta->fetch_assoc()) {
                $newPlant = new Planta();
                $newPlant->setId($fila['id']);
                $newPlant->setNombre($fila['nombre']);
                $newPlant->setDescripcion($fila['descripcion']);
                $newPlant->setPrecio($fila['precio']);
                $newPlant->setStock($fila['stock']);
                $newPlant->setFoto($fila['foto']);
                $newPlant->setCompradas($fila['compradas']);

                $listaPlantas[] = $newPlant;
            }
            return $listaPlantas;
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

        public function agregarPlanta($nombre, $descripcion, $precio, $stock, $compradas) {
            include 'db.php';

            $targetDir = "../uploads/";
            $filename = $_FILES["file"]["name"];
            $targetFilePath = $targetDir . $filename;

            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath))
            {
                $src = $this->convertirBase64($targetFilePath);

                $sql = "INSERT INTO `plantas`(`id`, `nombre`, `descripcion`, `precio`, `stock`, `foto`, `compradas`) VALUES (NULL,'".$nombre."','".$descripcion."',".$precio.",".$stock.",'".$src."',".$compradas.")";
                return $consulta = mysqli_query($con,$sql);
            } else {
                return null;
            }
        }

        public function eliminar($id){
            include 'db.php';
            $sqlDelete="DELETE FROM `plantas` WHERE id=".$id;
            $consulta = mysqli_query($con,$sqlDelete);
        }

        public function modificarPlanta($plantaModif, $id_planta){
            include 'db.php';
            $sqlUpdate="UPDATE `plantas` SET id=".$id_planta.", nombre='".$plantaModif->getNombre()."', descripcion='".$plantaModif->getDescripcion()."', precio=".$plantaModif->getPrecio().", stock=".$plantaModif->getStock().", foto='".$plantaModif->getFoto()."', compradas=".$plantaModif->getCompradas()." WHERE id=".$id_planta;
            $consultaUpdate = mysqli_query($con, $sqlUpdate);

            if(!$consultaUpdate) {
                echo 'no se realizó la consulta';
            } else {
                echo 'se realizó la consulta';
            }
        }

        public function obtenerPlanta($id) {
            include 'db.php';

            $sqlUserId="SELECT * FROM `plantas` WHERE id = '".$id."'";
            $consultaPlanta = mysqli_query($con, $sqlUserId);
            $fila = $consultaPlanta->fetch_assoc();
            
            $planta = new Planta();
            $planta->setId($fila['id']);
            $planta->setNombre($fila['nombre']);
            $planta->setDescripcion($fila['descripcion']);
            $planta->setPrecio($fila['precio']);
            $planta->setStock($fila['stock']);
            $planta->setFoto($fila['foto']);
            $planta->setCompradas($fila['compradas']);
            return $planta;
        }

        public function ordenarPorDefecto($lista) {
            function cmp($a, $b) { return strcmp($a->getId(), $b->getId()); }
            usort($lista, "cmp");
            return $lista;
        }

        public function ordenarPorPrecio($lista) {
            function cmp($a, $b) { return strcmp($a->getPrecio(), $b->getPrecio()); }
            usort($lista, "cmp");
            return $lista;
        }

        public function ordenarPorNombre($lista) {
            function cmp($a, $b) { return strcmp($a->getNombre(), $b->getNombre()); }
            usort($lista, "cmp");
            return $lista;
        }

        public function ordenarPorDeseados($listaPlantas, $listaDeseados) {
            
    }
?>