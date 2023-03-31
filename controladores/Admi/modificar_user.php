<?php
/*Aca realizamos procesos ya conocidos, recepcion por metodo GET, creacion de variables y update a las tablas de la base de datos, la 
unica diferencia es que, se creo una validacion de los datos enviados, con la funcion empty, que nos ayuda a validar si el dato con el nombre de 
la variable descrita (por ejemplo, que se enviara un dato con name ='nombre') fue enviado por el sistema, sino, arroja el mensaje descrito en el echo*/
  $id= $_GET["id"];
if(!empty($_POST["usupdate"])){
    if (empty($_POST["nombre"]) or empty($_POST["apellido"]) or empty($_POST["usuario"]) or empty($_POST["clave"])or empty($_POST["tipousu"])) {
        echo '<div class="alert alert-danger" style="text-align: center;" >POR FAVOR COMPLETE TODOS LOS CAMPOS</div>';
    } else {
        $nombre=$_POST["nombre"];
        $apellido=$_POST["apellido"];
        $username=$_POST["usuario"];
        $clave=$_POST["clave"];
        $idusu=$_POST["tipousu"];
        $iddireccion=$_POST["direccion"];
        $sql=$conexion->query("UPDATE usuario set usuario='$username', clave='$clave', nombre='$nombre', apellido='$apellido',  id_tipo_usuario=$idusu, id_direccion=$iddireccion  where id =$id");
        /*Esto es solo algo que quise probar para la validacion si el proceso se realizo correctamente, agregando condiciones y utilizando un if y else */
        define('SUCCESS', 1);
        define('ERROR', 0);
        if ($sql == SUCCESS) {
            echo '<div class="alert alert-success">' . htmlspecialchars("Registro realizado con éxito, favor continuar") . '</div>';
        } else {
            echo '<div class="alert alert-danger">' . htmlspecialchars("ERROR") . '</div>';
        } 
    }
}
?>