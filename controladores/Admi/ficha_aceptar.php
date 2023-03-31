<!--Ficha utilizada para recepcionar los datos enviados por el Administrador al aceptar la ficha enviada por el usuario.-->
<!--Aca tenemos el guardado de todas las fichas, ya sea Gastos Corrientes o Contrato, estos se diferencian por el nombre asociado
al submit usado en cada uno, asi logramos diferenciar la ficha que se esta trabajando..-->

<!--Ficha Gastos Corrientes.-->
<?php
include("/xampp/htdocs/Sistema/controladores/conexion.php");
/*La recepcion de los datos se realiza a traves de variables, las cuales van asociadas al nombre dado al metodo de entrada de datos elegido,
aca tambien damos la condicion de que el proceso ocurra solo cuando presionamos el submit, esto se realiza con la condicion isset*/
if (isset($_POST["ficha_aceptar_director"])) {
  $id_Ficha_asociada = $_POST["ficha_acept_GC"];
  $id_usuario_acep_GC = $_POST['ficha_acep_GC_user'];
  $fecha_director = $_POST["fecha_director_aceptar"];
  $comentarios_director = $_POST["observaciones_director_aceptar"];

  /*Para realizar el guardado de los datos, se realiza un INSERT INTO a la tabla que queremos modificar, luego se detallan las columnas
  y por VALUES, se ingresan las variables de los datos que queremos guardar, siempre tenemos que tener cuidado con que las variables declaradas
  vallas en los espacios que corresponden, tal como se ve en el detalle mas abajo*/
  $sql = $conexion->query("INSERT INTO caja_comentarios_secpla (id_comentarios,id_ficha_GC,id_ficha_C,id_ficha_PY,
        id_ficha_PSO,id_ficha_AM,id_ficha_SC,id_ficha_E,id_ficha_TSUC,id_ficha_PA,id_ficha_Pre,id_usuario_fichas,id_director,
        id_secpla_usuario,AoR_secpla,comentario_usuario,comentario_director,comentarios_secpla,
        monto_recomendado_secpla,clasificador_secpla,fecha_comentario)
        VALUES ('','$id_Ficha_asociada','','','','','','','','','','','$id_usuario_acep_GC','','Aceptada',
        '','$comentarios_director','','','','$fecha_director')");

  $sql = $conexion->query("UPDATE ficha_gastos_corrientes SET estado_ficha_GC = 5
            WHERE id_GC = '$id_Ficha_asociada'"); /*Como habia comentado, la organizacion de las fichas se hizo a traves de estados, por ende, 
            al ser aprobada la ficha, se procedio a cambiar el estado a 5 (aprobada), para que esta ya pueda ser revisada por secpla */

header("Location: http://localhost/Sistema/Administrador/vistas_detalle_fichas/detalle_fichas_usuarios_area.php");
die();

}

/*Ficha Contratos*/
if (isset($_POST["aceptar_director_FC"])) {
  $id_FC_asociada = $_POST["ficha_acept_FC"];
  $fecha_director_FC = $_POST["director_aceptar_fecha_FC"];
  $comentarios_FC_director = $_POST["observaciones_director_aceptar_FC"];
  $id_user_FC_acep = $_POST['ficha_acep_FC_user'];

  $sql = $conexion->query("INSERT INTO caja_comentarios_secpla (id_comentarios,id_ficha_GC,id_ficha_C,id_ficha_PY,
          id_ficha_PSO,id_ficha_AM,id_ficha_SC,id_ficha_E,id_ficha_TSUC,id_ficha_PA,id_ficha_Pre,id_usuario_fichas,id_director,
          id_secpla_usuario,AoR_secpla,comentario_usuario,comentario_director,comentarios_secpla,
          monto_recomendado_secpla,clasificador_secpla,fecha_comentario)
          VALUES ('','','$id_FC_asociada','','','','','','','','','','$id_user_FC_acep','','Aceptada',
          '','$comentarios_FC_director','','','','$fecha_director_FC')");

  $sql = $conexion->query("UPDATE ficha_contratos SET estado_ficha_FC = 5
              WHERE id_FC = '$id_FC_asociada'");

header("Location: http://localhost/Sistema/Administrador/vistas_detalle_fichas/detalle_fichas_usuarios_area.php");
die();
}

/*Ficha Proyectos*/
if (isset($_POST["ficha_aceptar_director_PY"])) {
  $id_FC_asociada = $_POST["ficha_acept_PY"];
  $fecha_director_PY = $_POST["fecha_director_aceptar_PY"];
  $comentarios_PY_director = $_POST["observaciones_director_aceptar_PY"];
  $id_user_PY_acep = $_POST['ficha_acep_PY_user'];

  $sql = $conexion->query("INSERT INTO caja_comentarios_secpla (id_comentarios,id_ficha_GC,id_ficha_C,id_ficha_PY,
          id_ficha_PSO,id_ficha_AM,id_ficha_SC,id_ficha_E,id_ficha_TSUC,id_ficha_PA,id_ficha_Pre,id_usuario_fichas,id_director,
          id_secpla_usuario,AoR_secpla,comentario_usuario,comentario_director,comentarios_secpla,
          monto_recomendado_secpla,clasificador_secpla,fecha_comentario)
          VALUES ('','','','$id_FC_asociada','','','','','','','','','$id_user_PY_acep','','Aceptada',
          '','$comentarios_PY_director','','','','$fecha_director_PY')");

  $sql = $conexion->query("UPDATE ficha_proyectos SET estado_ficha_PY = 5
              WHERE id_PY = '$id_FC_asociada'");

header("Location: http://localhost/Sistema/Administrador/vistas_detalle_fichas/detalle_fichas_usuarios_area.php");
die();/*Recuerda siempre cerrar la conexion para evitar futuros problemas*/
}
