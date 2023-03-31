<!--Esta vista la usamos para controlar el ingreso del usuario y a que pagina derivamos en caso de que tipo de usuario ingresa
if(isset($_SESSION['id_tipo_usuario']))    Este es un bloque condicional que comprueba si existe una variable de sesión llamada "id_tipo_usuario". Si la variable de sesión existe, significa que el usuario ha iniciado sesión y se redireccionará a la página de inicio correspondiente.
switch ($_SESSION['id_tipo_usuario']) Este es un bloqueo switch que evalua el id de la persona ingresada y redirecciona dependiendo de
el tipo de usuario que ingreso.-->


<?php
session_start();
if(isset($_SESSION['id_tipo_usuario'])){/*Validamos  */
    switch ($_SESSION['id_tipo_usuario']) {
        case 1:
            header("location:Administrador/inicio_admi.php");
            break;/*Redireccionamos y cerramos la sesion.*/
        case 2:
            header("location:Secpla/inicio_secpla.php");
            break;
        case 3:
            header("location:Usuario/inicio_usuario.php");
            break;        
        default:
            # code...
            break;
    }

}
if (!empty($_POST["login-submit"])){ /*Validamos si se envio el dato en el boton submit */
    if (empty($_POST["username"]) and empty($_POST["password"])) {/*Validamos si se envio el dato de usuario y contraseña */
        echo '<div class="alert alert-danger" >LOS CAMPOS ESTAN VACIOS</div>';
    } else {
        $usuario=$_POST["username"];
        $clave=$_POST["password"];
        $sql=$conexion->query(" select * from usuario where usuario='$usuario' and clave='$clave' ");
        if ($datos=$sql->fetch_object()) { /*Estas líneas obtienen el nombre de usuario y la contraseña ingresados 
            en el formulario y consultan la base de datos para encontrar un usuario coincidente. 
            Si se encuentra una coincidencia, la información del usuario se almacena en variables de sesión. */
            $_SESSION["nombre"]=$datos->nombre;
            $_SESSION["apellido"]=$datos->apellido;
            $_SESSION["id"]=$datos->id;
            $_SESSION["id_direccion"]=$datos->id_direccion;
            $_SESSION['id_tipo_usuario']=$datos->id_tipo_usuario;
            switch ($_SESSION['id_tipo_usuario']) {
                case 1:
                    header("location:Administrador/inicio_admi.php");
                    break;
                case 2:
                    header("location:Secpla/inicio_secpla.php");
                    break;
                case 3:
                    header("location:Usuario/inicio_usuario.php");
                    break;        
                default:
                    # Aca reenvia segun el caso
                    break;
            }
            
        } else {/*Aca arrojamos mensaje de error por si no se cumple el envio de los datos o si los datos no son correctos. */
            echo '<div class="alert alert-danger" >ACCESO DENEGADO</div>';
        }
        
    }
}
?>