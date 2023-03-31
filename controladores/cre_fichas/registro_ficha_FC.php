<!--Vista creada para controlar el proceso de guardado de la ficha contratos.-->
<?php
include("/xampp/htdocs/Sistema/controladores/cre_fichas/conexion_fichas.php");

/*Para mantener un orden en el id asociado a las fichas y que no se repitieran, realice el ingreso de manera manual, dandole el valor de
la ficha con el numero mas alto en la tabla +1, asi no ocurrio el problema de que se repitiera, de igual manera esto es una forma, puede ser mejorado
pero me sirvio para realizar los procesos de testing y pruebas y avanzar */
$sql = "SELECT max(id_fichas) as id_fichas FROM fichas_general_secpla";
$result = $conexion1->query($sql);
$row = $result->fetch_assoc();
$id = $row['id_fichas'] + 1;

/*Proceso de creacion de las variables con los datos enviados. */
if (isset($_POST['guardar_FC'])) {
    $idficha_FC = $_POST['id_ficha_FC'];
    $idusuario_FC = $_POST['id_usuario_FC'];
    $idestado_FC = $_POST['id_estado_ficha_FC'];
    $idnombre_FC = $_POST['nombre_FC'];
    $idfecha_FC = $_POST['fecha_FC'];
    $iddescrip_FC = $_POST['descripcion_FC'];
    $idmonto_FC = $_POST['monto_solicitado_FC'];
    $idaportes_FC = $_POST['aportes_externos_FC'];
    $direccion_FC = $_POST['di_municipal_FC'];
    $prioridad_FC = $_POST['prioridad_FC'];
    $gestion_FC = $_POST['gestion_FC'];
    $clasifi_FC = $_POST['clasi_FC'];
    $ene_SA = $_POST['enero_SA'];
    $feb_SA = $_POST['febrero_SA'];
    $mar_SA = $_POST['marzo_SA'];
    $abr_SA = $_POST['abril_SA'];
    $may_SA = $_POST['mayo_SA'];
    $jun_SA = $_POST['junio_SA'];
    $jul_SA = $_POST['julio_SA'];
    $ago_SA = $_POST['agosto_SA'];
    $sep_SA = $_POST['sep_SA'];
    $oct_SA = $_POST['octu_SA'];
    $nov_SA = $_POST['nov_SA'];
    $dic_SA = $_POST['dic_SA'];
    $total_FC = $idmonto_FC + $idaportes_FC;
    $valores_SA = array($ene_SA, $feb_SA, $mar_SA, $abr_SA, $may_SA, $jun_SA, $jul_SA, $ago_SA, $sep_SA, $oct_SA, $nov_SA, $dic_SA);
    $suma_SA = array_sum($valores_SA);

    $ene_CA = $_POST['enero_CA'];
    $feb_CA = $_POST['febrero_CA'];
    $mar_CA = $_POST['marzo_CA'];
    $abr_CA = $_POST['abril_CA'];
    $may_CA = $_POST['mayo_CA'];
    $jun_CA = $_POST['junio_CA'];
    $jul_CA = $_POST['julio_CA'];
    $ago_CA = $_POST['agosto_CA'];
    $sep_CA = $_POST['sep_CA'];
    $oct_CA = $_POST['octu_CA'];
    $nov_CA = $_POST['nov_CA'];
    $dic_CA = $_POST['dic_CA'];
    $valores_CA = array($ene_CA, $feb_CA, $mar_CA, $abr_CA, $may_CA, $jun_CA, $jul_CA, $ago_CA, $sep_CA, $oct_CA, $nov_CA, $dic_CA);
    $suma_CA = array_sum($valores_CA);

    /*Aca realizamos un proceso diferente de las otras fichas, ya que, las ficha Contratos tiene la opcion de marcar un checkbox para 
    decir si mantiene contrato vigente o no, y en base a eso, la derivacion tiene que ser diferente. */
    if (isset($_POST['contrato_vigente_si_no'])) {/*Validacion si el checkbox esta seleccionado o no, en este caso, si se encuentra presionado
        la derivacion tiene que ser a la vista para el llenado de las vista ficha_contratos_vigentes  */

        $sql=$conexion1->query("INSERT INTO ficha_contratos (id_FC, nombre_FC, tipo_ficha_FC, fecha_FC, direccion_mun_FC, 
        descripcion_contrato_FC, financiamiento_FC, aportes_externos_FC,
        total_FC, enero_FC, febrero_FC, marzo_FC, abril_FC, mayo_FC, junio_FC,julio_FC, agosto_FC, 
        septiembre_FC, octubre_FC,noviembre_FC,diciembre_FC, total_FC_detalle_SA, enero_FC_CA, febrero_FC_CA, marzo_FC_CA,
        abril_FC_CA, mayo_FC_CA, junio_FC_CA, julio_FC_CA, agosto_FC_CA,septiembre_FC_CA,octubre_FC_CA,noviembre_FC_CA,diciembre_FC_CA,
        total_FC_CA,usuario_FC,estado_ficha_FC,	gestion_FC,clasificador_FC,prioridad_FC)VALUES('$id','$idnombre_FC','$idficha_FC','$idfecha_FC','$direccion_FC',
        '$iddescrip_FC','$idmonto_FC','$idaportes_FC','$total_FC','$ene_SA','$feb_SA','$mar_SA','$abr_SA','$may_SA','$jun_SA','$jul_SA',
        '$ago_SA','$sep_SA','$oct_SA','$nov_SA','$dic_SA','$suma_SA','$ene_CA','$feb_CA','$mar_CA','$abr_CA','$may_CA','$jun_CA','$jul_CA',
        '$ago_CA','$sep_CA','$oct_CA','$nov_CA','$dic_CA','$suma_CA','$idusuario_FC','$idestado_FC','$gestion_FC','$clasifi_FC','$prioridad_FC')");

        $sql=$conexion1->query("INSERT INTO fichas_general_secpla (id_ficha_secpla, id_fichas, nombre_secpla, tipo_ficha_secpla, fecha,
        monto_solicitado_secpla, direccion_secpla, funcionario_usuario, funcionario_direccion,area_gestion_secpla,clasificador_secpla, prioridad_secpla, estado_secpla) 
        VALUES('','$id','$idnombre_FC','$idficha_FC','$idfecha_FC','$total_FC','$direccion_FC','$idusuario_FC','','$gestion_FC','$clasifi_FC','$prioridad_FC','$idestado_FC')");
        header("Location: http://localhost/Sistema/Usuario/Tipo_fichas/ficha_contratos_vigentes.php?id_FC=".$id);

    } else {/* aca tenemos la opcion por si el checkbox no se encuentra presionado, si es asi, se realiza el guardado de los datos enviados y se cambian los estados, para que la ficha se valla a revision. */
        $sql=$conexion1->query("INSERT INTO ficha_contratos (id_FC, nombre_FC, tipo_ficha_FC, fecha_FC, direccion_mun_FC, 
        descripcion_contrato_FC, financiamiento_FC, aportes_externos_FC,
        total_FC, enero_FC, febrero_FC, marzo_FC, abril_FC, mayo_FC, junio_FC,julio_FC, agosto_FC, 
        septiembre_FC, octubre_FC,noviembre_FC,diciembre_FC, total_FC_detalle_SA, enero_FC_CA, febrero_FC_CA, marzo_FC_CA,
        abril_FC_CA, mayo_FC_CA, junio_FC_CA, julio_FC_CA, agosto_FC_CA,septiembre_FC_CA,octubre_FC_CA,noviembre_FC_CA,diciembre_FC_CA,
        total_FC_CA,usuario_FC,estado_ficha_FC,gestion_FC,clasificador_FC,prioridad_FC)VALUES('$id','$idnombre_FC','$idficha_FC','$idfecha_FC','$direccion_FC',
        '$iddescrip_FC','$idmonto_FC','$idaportes_FC','$total_FC','$ene_SA','$feb_SA','$mar_SA','$abr_SA','$may_SA','$jun_SA','$jul_SA',
        '$ago_SA','$sep_SA','$oct_SA','$nov_SA','$dic_SA','$suma_SA','$ene_CA','$feb_CA','$mar_CA','$abr_CA','$may_CA','$jun_CA','$jul_CA',
        '$ago_CA','$sep_CA','$oct_CA','$nov_CA','$dic_CA','$suma_CA','$idusuario_FC','2','$gestion_FC','$clasifi_FC','$prioridad_FC')");

        $sql=$conexion1->query("INSERT INTO fichas_general_secpla (id_ficha_secpla, id_fichas, nombre_secpla, tipo_ficha_secpla, fecha,
        monto_solicitado_secpla, direccion_secpla, funcionario_usuario, funcionario_direccion,area_gestion_secpla,clasificador_secpla, prioridad_secpla, estado_secpla) 
        VALUES('','$id','$idnombre_FC','$idficha_FC','$idfecha_FC','$total_FC','$direccion_FC','$idusuario_FC','','$gestion_FC','$clasifi_FC','$prioridad_FC','$idestado_FC')");
        header("Location: http://localhost/Sistema/Usuario/inicio_usuario.php");
    }

}
