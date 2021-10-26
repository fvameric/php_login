<?php
    class Deseados{
        private $id;
        private $user_id;
        private $planta_id;

        function __construct(){}
        // get set id
        public function getId(){
            return $this->id;
        }

        public function setId($id){
            $this->id = $id;
        }

        // get set UserId
        public function getUserId(){
        return $this->user_id;
        }

        public function setUserId($user_id){
            $this->user_id = $user_id;
        }

        // get set planta_id
        public function getPlantaId(){
            return $this->PlantaId;
        }

        public function setPlantaId($PlantaId){
            $this->PlantaId = $PlantaId;
        }
    }
?>