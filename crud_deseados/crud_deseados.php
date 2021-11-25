<?php
include_once('/conexion/db.php');
include_once('/clases/deseados.php');

class CrudDeseados
{
    private $db;
    private $listaDeseados = [];

    function __construct()
    {
        $this->db = new db();
        $this->cargarDeseados();
    }

    public function cargarDeseados()
    {
        $sql = "SELECT * FROM `deseados` WHERE 1";
        $consulta = mysqli_query($this->db->obtenerConexion(), $sql);

        while ($fila = $consulta->fetch_assoc()) {
            $newDeseado = new Deseados();
            $newDeseado->setId($fila['id']);
            $newDeseado->setUserId($fila['user_id']);
            $newDeseado->setPlantaId($fila['planta_id']);

            $this->listaDeseados[] = $newDeseado;
        }
    }

    public function obtenerListaDeseados()
    {
        return $this->listaDeseados;
    }

    public function agregarDeseado($user_id, $planta_id)
    {
        $sql = "INSERT INTO `deseados` (`id` ,`user_id` ,`planta_id`)VALUES (NULL , '" . $user_id . "', '" . $planta_id . "')";
        return $consulta = mysqli_query($this->db->obtenerConexion(), $sql);
    }

    public function eliminarDeseado($id_deseado)
    {
        $sqlDelete = "DELETE FROM `deseados` WHERE id=" . $id_deseado;
        $consulta = mysqli_query($this->db->obtenerConexion(), $sqlDelete);
    }

    public function modificarDeseados($deseadoModif, $id_deseado)
    {
        $sqlUpdate = "UPDATE `deseados` SET id=" . $id_deseado . ", user_id=" . $deseadoModif->getUserId() . ", planta_id=" . $deseadoModif->getPlantaId() . ")";
        $consultaUpdate = mysqli_query($this->db->obtenerConexion(), $sqlUpdate);
    }

    public function obtenerDeseadoPorId($id_planta, $id_user)
    {
        foreach ($this->listaDeseados as $deseado) {
            if ($id_planta == $deseado->getPlantaId() && $id_user == $deseado->getUserId()) {
                return $deseado;
            }
        }
        return null;
    }
}
