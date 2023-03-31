<?php

include("/xampp/htdocs/Sistema/controladores/conexion.php");

if(!empty($_POST["adminusu"])){
    if (empty($_POST["name"]) or empty($_POST["apellido"]) or empty($_POST["username"]) or empty($_POST["clave"])or empty($_POST["tipousu"]) or empty($_POST["email"])) {
        echo '<div class="alert alert-danger" style="text-align: center;" >POR FAVOR COMPLETE TODOS LOS CAMPOS</div>';
    } else {
        $nombre=$_POST["name"];
        $apellido=$_POST["apellido"];
        $username=$_POST["username"];
        $clave=$_POST["clave"];
        $idusu=$_POST["tipousu"];
        $iddireccion=$_POST["direccion"];
        $correo =$_POST['email'];
        $sql_verificar_correo = $conexion->query("SELECT * FROM usuario WHERE correo='$correo'");
        /*En este if, validamos si el correo asociado a la cuenta creada ya se encuentra registrado, si es asi, no se realiza el proceso
        de guardado en la base de datos, pero si el correo no se encuentra en nuestra base, se realiza el insert y se registra el usuario */
        if(mysqli_num_rows($sql_verificar_correo)>0){
            echo '<div class="alert alert-danger" >ERROR: Este correo ya está registrado</div>';
        } else {
            $sql=$conexion->query("insert into usuario(id, usuario, clave, nombre, apellido,correo,id_tipo_usuario, id_direccion) VALUES ('','$username', '$clave', '$nombre', '$apellido','$correo','$idusu', $iddireccion)");
            define('SUCCESS', 1);
            define('ERROR', 0);
            if ($sql == SUCCESS) {
                echo '<div class="alert alert-success">' . htmlspecialchars("Registro realizado con éxito, favor continuar") . '</div>';
            } else {
                echo '<div class="alert alert-danger">' . htmlspecialchars("ERROR") . '</div>';
            }
            
        }
    }
}
?>