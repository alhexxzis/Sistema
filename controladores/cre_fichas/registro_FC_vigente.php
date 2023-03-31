<!--Vista creada para guardar los datos enviados desde la vista web para el ingreso de los datos (en este caso, la vista ficha_contratos)-->
<?php
include('/xampp/htdocs/Sistema/controladores/cre_fichas/conexion_fichas.php');

/*Variables generadas para el guardado de los datos, recuerda que estas se enlazan con el input a traves del 'name' */
if(isset($_POST['guardar_FC_vigente'])){
$idficha_contrato = $_POST['id_FC_derivado'];
$idfecha_vigente = $_POST ['fecha_FC_vigente'];
$contratista_vigente = $_POST['nombre_FC_vigente'];
$fecha_inicio = $_POST['fecha_FC_vigente_ini'];
$fecha_termino = $_POST['fecha_FC_vigente_ter'];
$total_vigente = $_POST['total_FC_vigente'];
$clausulas_vigente = $_POST['clausulas_FC'];
$condiciones_vigente = $_POST['condiciones_FC'];
$reajuste_vigente = $_POST['reajuste_FC'];
$justificacion_vigente = $_POST['justificacion_FC'];
$ene_vigente = $_POST ['enero_vigente'];
$feb_vigente = $_POST['febrero_vigente'];
$mar_vigente = $_POST['marzo_vigente'];
$abr_vigente = $_POST['abril_vigente'];
$may_vigente = $_POST['mayo_vigente'];
$jun_vigente = $_POST['junio_vigente'];
$jul_vigente = $_POST['julio_vigente'];
$ago_vigente = $_POST['agosto_vigente'];
$sep_vigente = $_POST['sep_vigente'];
$oct_vigente = $_POST['octu_vigente'];
$nov_vigente = $_POST['nov_vigente'];
$dic_vigente = $_POST['dic_vigente'];
/*Aca generamos una variable que pueda guardar los datos ingresados en todos los meses, esto se hace por el metodo array */
$meses_vigente = array($ene_vigente, $feb_vigente,$mar_vigente,$jun_vigente, $jul_vigente, $ago_vigente, $sep_vigente, $oct_vigente, 
$nov_vigente, $dic_vigente);
$total_vigente_mensual =array_sum($meses_vigente); /*Aca determinamos lo que queremos hacer con este array, en este caso, sumamos
los montos ingresados en las variables determinadas mas arriba, asi tenemos la suma de todos los meses ingresados. */

/*conexion a la base de datos para realizar las modificaciones requeridas */
$sql=$conexion1->query("INSERT INTO ficha_contratos_vigente(id_FC_vigente, id_FC_derv,fecha_FC_vige, nombre_contratista_FC, 
fecha_inicio_FC_vigente, fecha_term_FC_vigente, monto_contratado_anter, clausula_reno_FC, condiciones_ampli_FC, tipo_reajuste_FC,
justificacion_FC_continuidad, enero_FCV, febrero_FCV, marzo_FCV, abril_FCV, mayo_FCV, junio_FCV, julio_FCV, agosto_FCV, septiembre_FCV, 
octubre_FCV, noviembre_FCV, diciembre_FCV, total_FCV) 
VALUES ('','$idficha_contrato','$idfecha_vigente','$contratista_vigente','$fecha_inicio',
'$fecha_termino','$total_vigente','$clausulas_vigente','$condiciones_vigente','$reajuste_vigente','$justificacion_vigente','$ene_vigente',
'$feb_vigente','$mar_vigente','$abr_vigente','$may_vigente','$jun_vigente','$jul_vigente','$ago_vigente','$sep_vigente','$oct_vigente','$nov_vigente',
'$dic_vigente','$total_vigente_mensual')");

$sql = $conexion1 -> query("UPDATE ficha_contratos SET estado_ficha_FC = 2 WHERE id_FC = $idficha_contrato");
header("location:/Sistema/Usuario/inicio_usuario.php");
}
?>