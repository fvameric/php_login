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
    // include clase deseados
    if (is_file("clases/deseados.php")) {
        include_once('clases/deseados.php');
    } else {
        include_once('../clases/deseados.php');
    }
    class CrudDeseados {

        // variables
        private $bd;
        private $listaDeseados = [];

        // constructor
        // nada más construirse, cargo la clase BD para obtener conexión
        // y también la lista de deseados para hacer un solo select
        public function __construct(){
            $this->bd = new claseBD();
            $this->cargarDeseados();
        }

        // funcion para obtener los deseados y meterlos en una lista
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

        // obtenemos el array de deseados
        public function obtenerListaDeseados() {
            return $this->listaDeseados;
        }

        // para obtener tan solo los deseados del usuario logueado
        public function obtenerDeseadosPorLogin($user) {
            $listaDeseadosUser = [];
            foreach($this->listaDeseados as $deseado) {
                if ($user->getId() == $deseado->getUserId()) {
                    $listaDeseadosUser[] = $deseado;
                }
            }
            return $listaDeseadosUser;
        }

        // para obtener tan solo el deseado específico a partir del usuario y de la planta
        public function obtenerDeseado($id_planta, $id_user) {
            foreach ($this->listaDeseados as $deseado) {
                if ($id_planta == $deseado->getPlantaId() && $id_user == $deseado->getUserId()) {
                    return $deseado;
                }
            }
            return null;
        }

        // CRUD
        // insert nuevos deseados
        public function agregarDeseado($user_id, $planta_id) {
            $sql = "INSERT INTO `deseados` (`id` ,`user_id` ,`planta_id`)VALUES (NULL , '".$user_id."', '".$planta_id."')";
            $consulta = mysqli_query($this->bd->obtenerConexion(), $sql);

            if ($consulta) {
                return true;
            } else {
                return false;
            }
        }

        // delete de deseados a partir de su id
        public function eliminarDeseado($id_deseado) {
            $sql = "DELETE FROM `deseados` WHERE id=".$id_deseado;
            $consulta = mysqli_query($this->bd->obtenerConexion(), $sql);

            if ($consulta) {
                return true;
            } else {
                return false;
            }
        }

        // XML
        // se utiliza SimpleXMLElement para formatear el archivo XML
        // el fichero se guarda en el root de la página
        public function crearXML($plantasDeseadas) {
            $xml = new SimpleXMLElement('<xml/>');
            foreach ($plantasDeseadas as $p) {
                $planta = $xml->addChild('planta');
                $planta->addChild('id', $p->getId());
                /*
                $planta->addChild('nombre', $p->getNombre());
                $planta->addChild('descripcion', $p->getDescripcion());
                $planta->addChild('precio', $p->getPrecio());
                $planta->addChild('stock', $p->getStock());
                $planta->addChild('foto', $p->getFoto());
                $planta->addChild('compradas', $p->getCompradas());
                $planta->addChild('categoria', $p->getCategoria());
                */
            }
    
            $xml->preserveWhiteSpace = false;
            $xml->formatOutput = true;
    
            $contenidoXML = $xml->asXML();
            $file = fopen('../plantas.xml', 'w');
            fwrite($file, $contenidoXML);
            fclose($file);
        }

        public function plantaExiste($idPlanta) {
            $crudPlanta = new CrudPlanta();
            foreach ($crudPlanta->obtenerListaPlantas() as $planta) {
                if ($idPlanta == $planta->getId()) {
                    return true;
                }
            }
            return false;
        }

        // se carga el fichero en simplexml_load_file
        // paso sus valores a agregarDeseado para que me cree los deseados en base de datos
        public function cargarXML($user, $fichero) {
            $path = $fichero;
            $xml = simplexml_load_file($path);

            foreach ($xml as $valor) {
                if ($valor->id != 0) {
                    if ($this->plantaExiste($valor->id)) {
                        $validacionFichero = $this->agregarDeseado($user->getId(), $valor->id);
                    }
                }
            }
            return $validacionFichero;
        }
    }
