<?php
    // clase BD
    if (is_file("conexion/bd.php")) {
        include_once('conexion/bd.php');
    } else {
        include_once('../conexion/bd.php');
    }

    if (is_file("clases/planta.php")) {
        include_once('clases/planta.php');
    } else {
        include_once('../clases/planta.php');
    }

    class CrudPlanta {

        private $bd;
        private $listaPlantas = [];

        public function __construct(){
            $this->bd = new claseBD();
            $this->cargarPlantas();
        }

        public function cargarPlantas() {
            $sql="SELECT * FROM `plantas` WHERE 1";
            $consulta = mysqli_query($this->bd->obtenerConexion(), $sql);

            while($fila=$consulta->fetch_assoc()) {
                $newPlant = new Planta();
                $newPlant->setId($fila['id']);
                $newPlant->setNombre($fila['nombre']);
                $newPlant->setDescripcion($fila['descripcion']);
                $newPlant->setPrecio($fila['precio']);
                $newPlant->setStock($fila['stock']);
                $newPlant->setFoto($fila['foto']);
                $newPlant->setCompradas($fila['compradas']);
                $newPlant->setCategoria($fila['categoria']);

                $this->listaPlantas[] = $newPlant;
            }
        }

        public function obtenerListaPlantas() {
            return $this->listaPlantas;
        }

        public function obtenerPlanta($id) {
            foreach ($this->listaPlantas as $planta) {
                if ($id == $planta->getId()) {
                    return $planta;
                }
            }
            return null;
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

        public function agregarPlanta($nombre, $descripcion, $precio, $stock, $compradas, $categoria, $filename, $path) {
            $src = $this->convertirBase64($filename, $path);

            $sql = "INSERT INTO `plantas`(`id`, `nombre`, `descripcion`, `precio`, `stock`, `foto`, `compradas`, `categoria`) VALUES (NULL,'".$nombre."','".$descripcion."',".$precio.",".$stock.",'".$src."',".$compradas.", ".$categoria.")";
            $consulta = mysqli_query($this->bd->obtenerConexion(), $sql);

            if ($consulta) {
                return true;
            } else {
                return false;
            }
        }

        public function eliminarPlanta($id){
            $sqlDelete = "DELETE FROM `plantas` WHERE id=".$id;
            $consultaDelete = mysqli_query($this->bd->obtenerConexion(), $sqlDelete);
            
            if($consultaDelete) {
                return true;
            } else {
                return false;
            }
        }

        public function modificarPlanta($plantaModif, $id_planta){
            $sqlUpdate = "UPDATE `plantas` SET id=".$id_planta.", nombre='".$plantaModif->getNombre()."', descripcion='".$plantaModif->getDescripcion()."', precio=".$plantaModif->getPrecio().", stock=".$plantaModif->getStock().", foto='".$plantaModif->getFoto()."', compradas=".$plantaModif->getCompradas().", categoria=".$plantaModif->getCategoria()." WHERE id=".$id_planta;
            $consultaUpdate = mysqli_query($this->bd->obtenerConexion(), $sqlUpdate);

            if($consultaUpdate) {
                return true;
            } else {
                return false;
            }
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
            $sortarr = [];
            foreach ($listaDeseados as $deseado) {
                foreach ($listaPlantas as $planta) {
                    if($planta->getId() == $deseado->getPlantaId()) {
                        $sortarr[] = $planta;
                    }
                }
            }
            return $sortarr;
        }

        public function ordenarPorCategoria($numcategoria) {
            $listaPlantasCategoria = [];
            foreach ($this->listaPlantas as $planta) {
                if ($numcategoria == $planta->getCategoria()) {
                    $listaPlantasCategoria[] = $planta;
                }
            }
            return $listaPlantasCategoria;
        }

        public function stringCategoria($cat) {
            if ($cat == 1) {
                return 'Aeonium';
            } elseif ($cat == 2) {
                return 'Cotyledon';
            } elseif ($cat == 3) {
                return 'Crassula';
            } elseif ($cat == 4) {
                return 'Echeveria';
            } elseif ($cat == 5) {
                return 'Euphorbia';
            } elseif ($cat == 6) {
                return 'Haworthia';
            } elseif ($cat == 7) {
                return 'Senecio';
            }
        }
    }
