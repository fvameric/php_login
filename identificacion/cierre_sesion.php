<?php

// al cerrar la sesión
// hacemos unset para eliminar todas las variables
// y con session_destroy se chapa la cuenta del todo
// finalmente reenvío al índice
session_start() ;
session_unset();
session_destroy();
header('Location: ../index.php');
?>