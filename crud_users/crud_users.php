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
    // include clase user
    if (is_file("clases/user.php")) {
        include_once('clases/user.php');
    } else {
        include_once('../clases/user.php');
    }
    class CrudUser {

        // variables
        private $bd;
        private $listaUsuarios = [];

        // constructor
        // nada más construirse, cargo la clase BD para obtener conexión
        // y también la lista de usuarios para hacer un solo select
        public function __construct(){
            $this->bd = new claseBD();
            $this->cargarUsuarios();
        }

        // funcion para obtener los usuarios y meterlos en una lista
        public function cargarUsuarios() {
            $sql = "SELECT * FROM `users` WHERE 1";
            $consulta = mysqli_query($this->bd->obtenerConexion(), $sql);

            while($fila = $consulta->fetch_assoc()) {
                $newUser = new User();
                $newUser->setId($fila['id']);
                $newUser->setNickname($fila['nickname']);
                $newUser->setPassword($fila['password']);
                $newUser->setEmail($fila['email']);
                $newUser->setAvatar($fila['avatar']);
                $newUser->setAdmin($fila['admin']);

                $this->listaUsuarios[] = $newUser;
            }
        }

        // obtengo la variable array
        public function obtenerListaUsuarios() {
            return $this->listaUsuarios;
        }

        // para obtener tan solo un usuario especificado por su ID
        public function obtenerUser($id) {
            foreach ($this->listaUsuarios as $usuario) {
                if ($id == $usuario->getId()) {
                    return $usuario;
                }
            }
            return null;
        }

        // quita cualquier espacio o elemento similar a un espacio vacío o en blanco
        // así me aseguro de que el nombre y la contraseña no tenga algún espacio extra
        // se puede utilizar trim, pero preg_replace asegura que quita TODO lo blanco
        function borrarEspacios($str) {
            return preg_replace('/\s+/', '', $str);
        }

        // crypt devuelve un hash débil
        // hay que utilizar un parámetro salt para mayor seguridad
        // se debería utilizar password_hash que utiliza un hash fuerte de por sí
        // pero necesita PHP 5.6 o superior
        function encriptarPassword($password) {
            $password_crypt = crypt($password,'$5$rounds=5000$stringforsalt$');
            $arrPassword = explode("$", $password_crypt);
            return $arrPassword[4];
        }

        // en caso de que el nick y la contraseña coincidan en la lista, se devuelve dicho usuario
        public function validarLoginUser($nickname, $password) {
            foreach ($this->listaUsuarios as $usuario) {
                if ($nickname == $usuario->getNickname() && $password == $usuario->getPassword()) {
                    return $usuario;
                }
            }
            return null;
        }

        // validación en caso de que email o el nick ya exista
        public function validarRegistro($nickname, $email) {
            foreach($this->listaUsuarios as $usuario) {
                if ($nickname == $usuario->getNickname() || $email == $usuario->getEmail()) {
                    return false;
                }
            }
            return true;
        }

        // convierte los avatares en base64
        public function convertirBase64($filename, $path) {
            $fileType = pathinfo($filename,PATHINFO_EXTENSION);
            $imageData = base64_encode(file_get_contents($path));

            if ($fileType == 'jpg' || $fileType == 'png' || $fileType == 'gif') {
                return 'data:'.$fileType.';base64,' . $imageData;
            } else {
                return "<br>No es una imagen<br>";
            }
        }
        
        // insert a base de datos del nuevo usuario
        public function agregarUser($nickname, $password, $email, $filename, $path) {
            
            // avatar
            $src = $this->convertirBase64($filename, $path);

            $sql = 'INSERT INTO `users` (`id` ,`nickname` ,`password`, `email`, `avatar`, `admin`)VALUES (NULL , "'.$nickname.'", "'.$password.'", "'.$email.'", "'.$src.'",0)';
            $consulta = mysqli_query($this->bd->obtenerConexion(), $sql);
            
            if ($consulta) {
                return true;
            } else {
                return false;
            }
        }

        // se hace un delete a base de datos según la ID especificada
        public function eliminarUsuario($id){
            $sql = "DELETE FROM `users` WHERE id=".$id;
            $consulta = mysqli_query($this->bd->obtenerConexion(), $sql);

            if($consulta) {
                return true;
            } else {
                return false;
            }
        }

        // según el usuario y su id, se modifica en base de datos con los nuevos (o mismos) valores
        public function modificarUsuario($userModif){
            $sql = "UPDATE `users` SET id=".$userModif->getId().", nickname='".$userModif->getNickname()."', password='".$userModif->getPassword()."', email='".$userModif->getEmail()."', avatar='".$userModif->getAvatar()."' WHERE id=".$userModif->getId();
            $consulta = mysqli_query($this->bd->obtenerConexion(), $sql);

            if($consulta) {
                return true;
            } else {
                return false;
            }
        }
    }
