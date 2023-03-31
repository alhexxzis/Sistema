<!--Aca es relativente el mismo proceso que ocurre en la recepcion de la ficha, se generan variables con los datos enviados por el form
y luego se realizan los procesos en la base de datos, a traves de metodos incluidos en el lenguaje php.-->

<?php
session_start();
if (empty($_SESSION['nombre']) and empty($_SESSION['apellido'])) {
  header('location:../login.php');
}
if (isset($_SESSION['id_direccion'])) {
  $id_direccionSession = $_SESSION['id_direccion'];
  $id_direccion = htmlspecialchars($id_direccionSession);
}
if (isset($_SESSION['id'])) {
  $id_usuarioSession = $_SESSION['id'];
  $id_usuario = htmlspecialchars($id_usuarioSession);
}
if (!isset($_SESSION['id_tipo_usuario'])) {
  header('location:../login.php');
} else {
  if ($_SESSION['id_tipo_usuario'] != 1) {
    header('location:../login.php');
  }
}
include("/xampp/htdocs/Sistema/controladores/conexion.php");
/*Ficha Gastos Corrientes */
if (isset($_POST["ficha_rechazar_director"])) {
  $id_Ficha_asociada = $_POST["ficha_rechazar_GC"];
  $fecha_director = $_POST["fecha_director_rechazar"];
  $comentarios_director = $_POST["observaciones_director_rechazar"];

  $sql = $conexion->query("INSERT INTO caja_comentarios_secpla (id_comentarios,id_ficha_GC,id_ficha_C,id_ficha_PY,
        id_ficha_PSO,id_ficha_AM,id_ficha_SC,id_ficha_E,id_ficha_TSUC,id_ficha_PA,id_ficha_Pre,id_usuario_fichas,id_director,
        id_secpla_usuario,AoR_secpla,comentario_usuario,comentario_director,comentarios_secpla,monto_recomendado_secpla,clasificador_secpla,fecha_comentario)
        VALUES ('','$id_Ficha_asociada','','','','','','','','','','','$id_usuario','','Rechazada',
        '','$comentarios_director','','','','$fecha_director')");
/*Aca el UPDATE es para cambiar el estado a 3, ya que no es aprobada por el director y devuelta al usuario creador */
  $sql = $conexion->query("UPDATE ficha_gastos_corrientes SET estado_ficha_GC = 3
            WHERE id_GC = '$id_Ficha_asociada'");
}

/*Ficha Contratos */
if (isset($_POST["ficha_rechazar_director_FC"])) {
  $id_FC_asociada = $_POST["ficha_rechazar_FC"];
  $fecha_director = $_POST["fechadirector_rechazar_FC"];
  $comentarios_director = $_POST["observaciones_director_rechazar_FC"];

  $sql = $conexion->query("INSERT INTO caja_comentarios_secpla (id_comentarios,id_ficha_GC,id_ficha_C,id_ficha_PY,
        id_ficha_PSO,id_ficha_AM,id_ficha_SC,id_ficha_E,id_ficha_TSUC,id_ficha_PA,id_ficha_Pre,id_usuario_fichas,id_director,
        id_secpla_usuario,AoR_secpla,comentario_usuario,comentario_director,comentarios_secpla,monto_recomendado_secpla,clasificador_secpla,fecha_comentario)
        VALUES ('','','$id_FC_asociada','','','','','','','','','','$id_usuario','','Rechazada',
        '','$comentarios_director','','','','$fecha_director')");

  $sql = $conexion->query("UPDATE ficha_contratos SET estado_ficha_FC = 3
            WHERE id_FC = '$id_FC_asociada'");
}

/*Ficha Proyectos */
if (isset($_POST["ficha_rechazar_director_PY"])) {
  $id_Ficha_asociada = $_POST["ficha_rechazar_PY"];
  $fecha_director = $_POST["fecha_director_rechazar_PY"];
  $comentarios_director = $_POST["observaciones_director_rechazar_PY"];

  $sql = $conexion->query("INSERT INTO caja_comentarios_secpla (id_comentarios,id_ficha_GC,id_ficha_C,id_ficha_PY,
        id_ficha_PSO,id_ficha_AM,id_ficha_SC,id_ficha_E,id_ficha_TSUC,id_ficha_PA,id_ficha_Pre,id_usuario_fichas,id_director,
        id_secpla_usuario,AoR_secpla,comentario_usuario,comentario_director,comentarios_secpla,monto_recomendado_secpla,clasificador_secpla,fecha_comentario)
        VALUES ('','','','$id_Ficha_asociada','','','','','','','','','$id_usuario','','Rechazada',
        '','$comentarios_director','','','','$fecha_director')");

  $sql = $conexion->query("UPDATE ficha_proyectos SET estado_ficha_PY = 3
            WHERE id_PY = '$id_Ficha_asociada'");
}

?>
<!--Aca probamos otra forma de enviar a la pagina de inicio, cuando se realiza el proceso de envio de datos, creacion de las variables
modificacion de los datos en las tablas en la base de datos, se procede a realizar un script en javascripts para el cambio de vista
puedes reemplazar los 0000 para cambiar los segundos que se tarda en realizar el cambio de pagina, si quieres puedes agregar algun mensaje entremedio.-->

<script>
  setTimeout(function() {
    window.location.replace("http://localhost/Sistema/Administrador/inicio_admi.php");
  }, 0000);
</script>