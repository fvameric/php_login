<?php
    // utilizo is_file para asegurar que los archivos tengan acceso al fichero
    // porque según en qué carpetas estén, si hay includes que piden otros includes
    // estos segundos includes no los encuentra si solo especifico una ruta

    // include conexión BD
    if (is_file("conexion/bd.php")) {
        include_once('conexion/bd.php');
    } else {
        include_once('../conexion/bd.php');
    }
    // include clase planta
    if (is_file("clases/planta.php")) {
        include_once('clases/planta.php');
    } else {
        include_once('../clases/planta.php');
    }

    class CrudPlanta {

        // variables
        private $bd;
        private $listaPlantas = [];

        // constructor
        // nada más construirse, cargo la clase BD para obtener conexión
        // y también la lista de plantas para hacer un solo select
        public function __construct(){
            $this->bd = new claseBD();
            $this->cargarPlantas();
        }

        // funcion para obtener las plantas y meterlas en una lista
        public function cargarPlantas() {
            $sql = "SELECT * FROM `plantas` WHERE 1";
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

        // obtengo la variable array
        public function obtenerListaPlantas() {
            return $this->listaPlantas;
        }

        // para obtener tan solo la planta especificada por su ID
        public function obtenerPlanta($id) {
            foreach ($this->listaPlantas as $planta) {
                if ($id == $planta->getId()) {
                    return $planta;
                }
            }
            return null;
        }

        // para convertir a base64 las imagenes de las plantas
        public function convertirBase64($filename, $path) {
            $fileType = pathinfo($filename,PATHINFO_EXTENSION);
            $imageData = base64_encode(file_get_contents($path));
            return 'data:' . $fileType . ';base64,' . $imageData;
        }

        // CRUD
        // insert de nuevas plantas a base de datos
        public function agregarPlanta($nombre, $descripcion, $precio, $stock, $compradas, $categoria, $filename, $path) {
            
            // imagen
            $src = $this->convertirBase64($filename, $path);

            $sql = "INSERT INTO `plantas`(`id`, `nombre`, `descripcion`, `precio`, `stock`, `foto`, `compradas`, `categoria`) VALUES (NULL,'".$nombre."','".$descripcion."',".$precio.",".$stock.",'".$src."',".$compradas.", ".$categoria.")";
            $consulta = mysqli_query($this->bd->obtenerConexion(), $sql);

            if ($consulta) {
                return true;
            } else {
                return false;
            }
        }

        // delete de plantas a partir de su id
        public function eliminarPlanta($id){
            $sql = "DELETE FROM `plantas` WHERE id=".$id;
            $consulta = mysqli_query($this->bd->obtenerConexion(), $sql);
            
            if($consulta) {
                return true;
            } else {
                return false;
            }
        }

        // update de plantas a partir de un objeto con los nuevos (o mismos) valores
        // y su id para saber cual hay que modificar
        public function modificarPlanta($plantaModif, $id_planta){
            $sql = "UPDATE `plantas` SET id=".$id_planta.", nombre='".$plantaModif->getNombre()."', descripcion='".$plantaModif->getDescripcion()."', precio=".$plantaModif->getPrecio().", stock=".$plantaModif->getStock().", foto='".$plantaModif->getFoto()."', compradas=".$plantaModif->getCompradas().", categoria=".$plantaModif->getCategoria()." WHERE id=".$id_planta;
            $consulta = mysqli_query($this->bd->obtenerConexion(), $sql);

            if($consulta) {
                return true;
            } else {
                return false;
            }
        }

        // Ordenacion del array
        // ordenar por defecto, en caso de que se quiera ver la lista como estaba en un principio
        public function ordenarPorDefecto($lista) {
            function compararID($a, $b) { return strcmp($a->getId(), $b->getId()); }
            usort($lista, "compararID");
            return $lista;
        }

        // ordenar por precio
        public function ordenarPorPrecio($lista) {

            // utilizando usort con callback no ordena bien los números
            // por ejemplo, coloca los 10 teniendo tan solo en cuenta el 1 y no lo trata como un 10

            /*
            function compararPrecio($a, $b) { return strcmp($a->getPrecio(), $b->getPrecio()); }
            usort($lista, "compararPrecio");
            return $lista;
            */

            usort(
                $lista, 
                function($a, $b) {
                    $result = 0;
                    if ($a->getPrecio() > $b->getPrecio()) {
                        $result = 1;
                    } else if ($a->getPrecio() < $b->getPrecio()) {
                        $result = -1;
                    }
                    return $result; 
                }
            );

            return $lista;
        }

        // ordenar por nombre de la planta
        public function ordenarPorNombre($lista) {
            function compararNombre($a, $b) { return strcmp($a->getNombre(), $b->getNombre()); }
            usort($lista, "compararNombre");
            return $lista;
        }

        // separa en otra lista con tan solo las plantas deseadas y solo se muestran esas
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

        // separa las plantas correspondientes a la categoría clickada
        public function ordenarPorCategoria($numcategoria) {
            $listaPlantasCategoria = [];
            foreach ($this->listaPlantas as $planta) {
                if ($numcategoria == $planta->getCategoria()) {
                    $listaPlantasCategoria[] = $planta;
                }
            }
            return $listaPlantasCategoria;
        }

        // las categorías se guardan en números
        // esta función está en caso de que se necesita mostrarlas en string
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
