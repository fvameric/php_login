<?php
    class Planta{
        private $id;
        private $nombre;
        private $descripcion;
        private $precio;
        private $stock;
        private $foto;
        private $compradas;
        private $categoria;

        function __construct(){}

        // get set id
        public function getId(){
            return $this->id;
        }

        public function setId($id){
            $this->id = $id;
        }

        // get set nombre
        public function getNombre(){
        return $this->nombre;
        }

        public function setNombre($nombre){
            $this->nombre = $nombre;
        }

        // get set descripcion
        public function getDescripcion(){
            return $this->descripcion;
        }

        public function setDescripcion($descripcion){
            $this->descripcion = $descripcion;
        }

        // get set precio
        public function getPrecio(){
        return $this->precio;
        }

        public function setPrecio($precio){
            $this->precio = $precio;
        }

        // get set stock
        public function getStock(){
            return $this->stock;
        }

        public function setStock($stock){
            $this->stock = $stock;
        }

        // get set foto
        public function getFoto(){
            return $this->foto;
        }

        public function setFoto($foto){
            $this->foto = $foto;
        }

        // get set compradas
        public function getCompradas(){
            return $this->compradas;
        }

        public function setCompradas($compradas){
            $this->compradas = $compradas;
        }

        // get set categoria
        public function getCategoria(){
            return $this->$categoria;
        }

        public function setCategoria($categoria){
            $this->categoria = $categoria;
        }
    }
?>