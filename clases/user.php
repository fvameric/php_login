<?php
    class User{
        private $id;
        private $nickname;
        private $password;
        private $email;
        private $avatar;
        private $admin;

        function __construct(){}
        // get set id
        public function getId(){
            return $this->id;
        }

        public function setId($id){
            $this->id = $id;
        }

        // get set nombre
        public function getNickname(){
        return $this->nickname;
        }

        public function setNickname($nickname){
            $this->nickname = $nickname;
        }

        // get set pass
        public function getPassword(){
            return $this->password;
        }

        public function setPassword($password){
            $this->password = $password;
        }

        // get set email
        public function getEmail(){
        return $this->email;
        }

        public function setEmail($email){
            $this->email = $email;
        }

        // get set avatar
        public function getAvatar(){
            return $this->avatar;
        }

        public function setAvatar($avatar){
            $this->avatar = $avatar;
        }

        // get set admin
        public function getAdmin(){
            return $this->admin;
        }

        public function setAdmin($admin){
            $this->admin = $admin;
        }
    }
?>