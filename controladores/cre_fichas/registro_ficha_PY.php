<!--Vista creada como controlador del ingreso de los datos de la ficha Proyectos-->
<?php

include("/xampp/htdocs/Sistema/controladores/cre_fichas/conexion_fichas.php");

$sql = "SELECT max(id_fichas) as id_fichas FROM fichas_general_secpla";
$result = $conexion1->query($sql);
$row = $result->fetch_assoc();
$id = $row['id_fichas'] + 1;

/* Creacion de variables */
if (isset($_POST['guardar_PY'])) {

    $tipo_ficha_PY = $_POST['tipo_ficha_PY'];
    $id_usuario_PY = $_POST['id_usuario_PY'];
    $estado_PY = $_POST['id_estado_ficha_PY'];
    $nombre_PY = $_POST['nombre_PY'];
    $fecha_PY = $_POST['fecha_PY'];
    $descri_PY = $_POST['descripcion_PY'];
    $jus_PY = $_POST['justificacion_PY'];
    $monto_sol_PY = $_POST['monto_solicitado_PY'];
    $aporte_PY = $_POST['aportes_externos_PY'];
    $prioridad_PY = $_POST['prioridad_PY'];
    $vecinal_PY = $_POST['vecinal_PY'];
    $poblacion_PY = $_POST['poblacion_PY'];
    $terreno_PY = $_POST['terreno_PY'];
    $propiedad_PY = $_POST['propiedad_PY'];
    $plazo_PY = $_POST['plazoEje_PY'];
    $fecha_inic_PY = $_POST['fecha_inicio_PY'];
    $fecha_ter_PY = $_POST['fecha_ter_PY'];
    $propuesta_PY = $_POST['propuesta_eje_PY'];
    $beneficiados_PY = $_POST['beneficiados_PY'];
    $inversion_bene_PY = $_POST['inversion_ben_PY'];
    $costo_constr_PY = $_POST['metros_PY'];
    $costo_anual_PY = $_POST['anual_costo_PY'];
    $gestion_PY = $_POST['gestion_PY'];
    $clasificador_PY = $_POST['clasi_PY'];
    $direccion_PY = $_POST['di_municipal_PY'];
    $total = $monto_sol_PY + $aporte_PY;

    /*Insercion de los datos en las tablas a traves de la variable $sql */
    $sql = $conexion1->query("INSERT INTO ficha_proyectos (id_PY, nombre_ficha_PY,tipo_ficha_PY,fecha_PY,direccion_PY,descripcion_PY,justificacion_PY,financiamiento_PY,
aportes_externos_PY,total_PY,unidad_vecinal_PY,poblacion_PY,direccion_comuna_PY,propiedad_terreno_PY,plazo_ejecucion_PY,fecha_estima_inicio_PY,fecha_estima_termi_PY,
procedimiento_PY,numero_benef_PY,inversionx_benefi_PY, costo_M2_construccion_PY,costo_anual_PY,usuario_PY, estado_ficha_PY,gestion_PY,clasificacion_PY,prioridad_PY ) 
VALUES ('$id','$nombre_PY','$tipo_ficha_PY','$fecha_PY','$direccion_PY','$descri_PY','$jus_PY','$monto_sol_PY','$aporte_PY','$total','$vecinal_PY','$poblacion_PY',
'$terreno_PY','$propiedad_PY','$plazo_PY','$fecha_inic_PY','$fecha_ter_PY','$propuesta_PY','$beneficiados_PY','$inversion_bene_PY','$costo_constr_PY','$costo_anual_PY',
'$id_usuario_PY', '$estado_PY','$gestion_PY','$clasificador_PY','$prioridad_PY')");

    $sql = $conexion1->query("INSERT INTO fichas_general_secpla(id_ficha_secpla, id_fichas, nombre_secpla, tipo_ficha_secpla, fecha,
    monto_solicitado_secpla,direccion_secpla,funcionario_usuario,funcionario_direccion,area_gestion_secpla,clasificador_secpla,prioridad_secpla,estado_secpla) 
    VALUES('','$id','$nombre_PY','$tipo_ficha_PY','$fecha_PY','$total','$direccion_PY','$id_usuario_PY','','$gestion_PY','$clasificador_PY','$prioridad_PY','$estado_PY')");
    if ($sql) {
        header("location:/Sistema/Usuario/Tipo_fichas/ficha_PY_detalle.php?id_PY=$id");
    } else {
        echo '<div class="alert alert-danger" >ERROR</div>';
    }
}
