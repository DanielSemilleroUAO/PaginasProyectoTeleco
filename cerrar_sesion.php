<?php
//----Destruir variables de sesion
session_start();
unset ($_SESSION['username']);
session_destroy();
//---Dirigir a pagina principal
header('Location:index.html');
?>