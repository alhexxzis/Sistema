<?php
session_start();
session_destroy();
header("location:/Sistema/login.php");


?>

<!--Aca cerramos la sesion de los usuarios y derivamos a la pagina de inicio-->