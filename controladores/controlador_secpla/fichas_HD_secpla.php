<!--La carpeta controlador_secpla, es la carpeta asociada a los procesos realizados por el usuario asociado a secpla-->
<!--Esta vista se encuentra asociada a la habilitacion de las fichas para el uso del personal (usuarios creadores de fichas)-->
<!--Como en otras fichas, se genero una validacion de envio de datos, luego se crearon las variables y se procede a realizar el update
segun la informacion enviada por el usuario secpla-->
<!--Aca no usamos un header o una variable que cambie de vista, ya que esta pagina fue incluida en la vista donde se envian los datos,
ademas, se agregaron validaciones para que el proceso solo se realice si el submit es presionado.-->
<?php
include('/xampp/htdocs/Sistema/controladores/cre_fichas/conexion_fichas.php');

if (isset($_POST['guardar_fichasHD'])) {
    if(empty($_POST['HD_fichaGC']) || empty($_POST['HD_fichaCon']) || empty($_POST['HD_fichaPY'])|| empty($_POST['HD_fichaPS'])
    || empty($_POST['HD_fichaAM'])|| empty($_POST['HD_fichaSC']) || empty($_POST['HD_fichaES'])|| empty($_POST['HD_fichaTR'])|| empty($_POST['HD_fichaPA'])
    || empty($_POST['HD_fichaPRE'])) {
        echo '<div class="alert alert-warning">' . htmlspecialchars("Favor, seleccione todas las opciones disponibles") . '</div>';
      } else{
    $ficha_GC =    $_POST["HD_fichaGC"];
    $ficha_Con =   $_POST["HD_fichaCon"];
    $ficha_PY =    $_POST["HD_fichaPY"];
    $ficha_PS =    $_POST["HD_fichaPS"];
    $ficha_AM =    $_POST["HD_fichaAM"];
    $ficha_SC =    $_POST["HD_fichaSC"];
    $ficha_ES =    $_POST["HD_fichaES"];
    $ficha_TR =    $_POST["HD_fichaTR"];
    $ficha_PA =    $_POST["HD_fichaPA"];
    $ficha_PRE =   $_POST["HD_fichaPRE"];

    $sql = $conexion1->query("UPDATE tipo_ficha SET estado = '$ficha_GC' WHERE id_tipo_ficha = 1");
    $sql = $conexion1->query("UPDATE tipo_ficha SET estado = '$ficha_Con' WHERE id_tipo_ficha = 2");
    $sql = $conexion1->query("UPDATE tipo_ficha SET estado = '$ficha_PY' WHERE id_tipo_ficha = 3");
    $sql = $conexion1->query("UPDATE tipo_ficha SET estado = '$ficha_PS' WHERE id_tipo_ficha = 4");
    $sql = $conexion1->query("UPDATE tipo_ficha SET estado = '$ficha_AM' WHERE id_tipo_ficha = 5");
    $sql = $conexion1->query("UPDATE tipo_ficha SET estado = '$ficha_SC' WHERE id_tipo_ficha = 6");
    $sql = $conexion1->query("UPDATE tipo_ficha SET estado = '$ficha_ES' WHERE id_tipo_ficha = 7");
    $sql = $conexion1->query("UPDATE tipo_ficha SET estado = '$ficha_TR' WHERE id_tipo_ficha = 8");
    $sql = $conexion1->query("UPDATE tipo_ficha SET estado = '$ficha_PA' WHERE id_tipo_ficha = 9");
    $sql = $conexion1->query("UPDATE tipo_ficha SET estado = '$ficha_PRE' WHERE id_tipo_ficha = 11");
    echo '<div class="alert alert-success">' . htmlspecialchars("Cambio realizado con exito") . '</div>';
      }
}
?>