<!--Vista relacionada con el ingreso de los datos para la ficha Gastos Corrientes -->
<?php
include("/xampp/htdocs/Sistema/controladores/cre_fichas/conexion_fichas.php");
/*Como habia comentado en las otras fichas, aca realizamos una de las formas para que las fichas no repitieran id y no tener problemas
a la hora de extrar los datos. */
$sql = "SELECT max(id_fichas) as id_fichas FROM fichas_general_secpla";
$result = $conexion1->query($sql);
$row = $result->fetch_assoc();
$id = $row['id_fichas'] + 1;
/*Validacion de ingreso de datos, los empty validan si la variable descrita por el nombre envio datos o no, si no envia nada una de ellas
se arroja el mensaje descrito */
if(!empty($_POST["reg_ficha_part_uno"])){
    if (empty(['id_ficha']) or empty($_POST["name"]) or empty($_POST["justificacion"]) or empty($_POST["descripcion"]) or empty($_POST["monto_GC"])or empty($_POST["direc_municipal"]) or empty($_POST["prioridad_GC"])) {
        echo '<div class="alert alert-danger" style="text-align: center;" >POR FAVOR COMPLETE TODOS LOS CAMPOS</div>';
    } else {/*Creacion de variables */
        $nombre=$_POST["name"];
        $fecha=$_POST["fecha"];
        $idficha=$_POST["id_ficha"];
        $idusuario=$_POST["id_usuario"];
        $idestficha=$_POST["id_estado_ficha"];
        $justi=$_POST["justificacion"];
        $descrip=$_POST["descripcion"];
        $monto =$_POST['monto_GC'];
        $direc =$_POST['direc_municipal'];  
        $gestion = $_POST['gestion_GC'];
        $clasificador = $_POST['clasi_GC'];
        $prioridad =$_POST['prioridad_GC'];
        /*Insercion de datos en las tablas correspondientes */
        $sql=$conexion1->query("insert into ficha_gastos_corrientes (id_GC,nombre_GC,tipo_ficha_GC,fecha_GC,direccion_mun_GC,
        justificacion_GC,descripcion_gasto_GC,financiamiento_sol_GC,GC_usuario,estado_ficha_GC,	gestion_GC, clasificador_GC, prioridad_GC) 
        VALUES('$id','$nombre','$idficha','$fecha','$direc','$justi','$descrip','$monto','$idusuario',
        '$idestficha','$gestion','$clasificador','$prioridad')");

        $sql=$conexion1->query("insert into fichas_general_secpla(id_ficha_secpla,id_fichas,nombre_secpla,tipo_ficha_secpla,fecha,
        monto_solicitado_secpla,direccion_secpla,funcionario_usuario,funcionario_direccion,area_gestion_secpla,clasificador_secpla,prioridad_secpla,estado_secpla) 
        VALUES('','$id','$nombre','$idficha','$fecha','$monto','$direc','$idusuario','','$gestion','$clasificador','$prioridad','$idestficha')");

        define('SUCCESS', 1);
        define('ERROR', 0);
        if ($sql == SUCCESS) {
            header("location:/Sistema/Usuario/Tipo_fichas/ficha_gastos_corrientes_deta.php?id_GC=$id");
        } else {
            echo '<div class="alert alert-danger">' . htmlspecialchars("ERROR") . '</div>';
        }
        
        }
}

echo "<pre>";
print_r($_POST);
echo "</pre>";
    ?>


