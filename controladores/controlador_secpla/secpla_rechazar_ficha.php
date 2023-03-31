<!--Vista creada para controlar las fichas que secpla acepta y finalizan su proceso interno.-->
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
  if ($_SESSION['id_tipo_usuario'] != 2) {
    header('location:../login.php');
  }
}
?>
<?php
include("/xampp/htdocs/Sistema/controladores/conexion.php");
/*Ficha Gastos Corrientes */
if (isset($_POST["ficha_rechazar_secpla"])) {
  $id_secpla_rechazar = $_POST["ficha_rechazar_secpla_id"];
  $fecha_secpla = $_POST["fecha_secpla_rechazar"];
  $comentarios_secpla = $_POST["observaciones_secpla_rechazar"];
  $monto_recomendado_secpla = $_POST['monto_secpla_rechazar'];
  $clasificador_secpla = $_POST['clasi_GC_rechazar'];

  $sql = $conexion->query("INSERT INTO caja_comentarios_secpla (id_comentarios,id_ficha_GC,id_ficha_C,id_ficha_PY,
        id_ficha_PSO,id_ficha_AM,id_ficha_SC,id_ficha_E,id_ficha_TSUC,id_ficha_PA,id_ficha_Pre,id_usuario_fichas,id_director,
        id_secpla_usuario,AoR_secpla,comentario_usuario,comentario_director,comentarios_secpla,monto_recomendado_secpla,clasificador_secpla,
        fecha_comentario)
        VALUES ('','$id_secpla_rechazar','','','','','','','','','','','','$id_usuario','Rechazada',
        '','','$comentarios_secpla','$monto_recomendado_secpla','$clasificador_secpla','$fecha_secpla')");
/*Como en la vista de secpla_aceptar_ficha, aca cambiamos el estado a 6, ya que secpla no aprobo la ficha por motivos que describe
en comentarios. */
  $sql = $conexion->query("UPDATE ficha_gastos_corrientes SET estado_ficha_GC = 6
            WHERE id_GC = '$id_secpla_rechazar'");
  $sql = $conexion->query("UPDATE fichas_general_secpla SET estado_secpla = 6
            WHERE id_fichas = '$id_secpla_rechazar'");

  define('SUCCESS', 1);
  define('ERROR', 0);
  if ($sql == SUCCESS) {
    echo "¡Ficha aceptada correctamente!";
    header("Location: http://localhost/Sistema/Secpla/inicio_secpla.php");
    die();
  } else {
    echo '<div class="alert alert-danger">' . htmlspecialchars("ERROR") . '</div>';
  }
}
?>
<?php
/*Ficha Contratos */
if (isset($_POST["ficha_rechazar_secpla_FC"])) {
  $id_secpla_rechazar_FC = $_POST["ficha_rechazar_FC_secpla"];
  $fecha_secpla_FC = $_POST["fecha_secpla_rechazar_FC"];
  $comentarios_secpla_FC = $_POST["observaciones_secpla_rechazar_FC"];
  $monto_recomendado_secpla_FC = $_POST['monto_secpla_FC'];
  $clasificador_secpla = $_POST['clasi_FC_rechazar'];

  $sql = $conexion->query("INSERT INTO caja_comentarios_secpla (id_comentarios,id_ficha_GC,id_ficha_C,id_ficha_PY,
          id_ficha_PSO,id_ficha_AM,id_ficha_SC,id_ficha_E,id_ficha_TSUC,id_ficha_PA,id_ficha_Pre,id_usuario_fichas,id_director,
          id_secpla_usuario,AoR_secpla,comentario_usuario,comentario_director,comentarios_secpla,monto_recomendado_secpla,clasificador_secpla,
          fecha_comentario)
          VALUES ('','','$id_secpla_rechazar_FC','','','','','','','','','','','$id_usuario','Rechazada',
          '','','$comentarios_secpla_FC','$monto_recomendado_secpla_FC','$clasificador_secpla','$fecha_secpla_FC')");

  $sql = $conexion->query("UPDATE ficha_contratos SET estado_ficha_FC = 6
              WHERE id_FC = '$id_secpla_rechazar_FC'");

                $sql = $conexion->query("UPDATE fichas_general_secpla SET estado_secpla = 6
                WHERE id_fichas = '$id_secpla_rechazar_FC'");

  define('SUCCESS', 1);
  define('ERROR', 0);
  if ($sql == SUCCESS) {
    echo "¡Ficha aceptada correctamente!";
    header("Location: http://localhost/Sistema/Secpla/inicio_secpla.php");
    die();
  } else {
    echo '<div class="alert alert-danger">' . htmlspecialchars("ERROR") . '</div>';
  }
}
?>
<?php
/*Ficha Proyectos */
if (isset($_POST["ficha_rechazar_secpla_PY"])) {
  $id_secpla_rechazar_PY = $_POST["rechazar_secpla_PY"];
  $fecha_secpla = $_POST["fecha_secpla_rechazar_PY"];
  $comentarios_secpla = $_POST["observaciones_secpla_rechazar_PY"];
  $monto_recomendado_secpla = $_POST['monto_secpla_rechazar_PY'];
  $clasificador_secpla = $_POST['clasi_PY_rechazar'];

  $sql = $conexion->query("INSERT INTO caja_comentarios_secpla (id_comentarios,id_ficha_GC,id_ficha_C,id_ficha_PY,
        id_ficha_PSO,id_ficha_AM,id_ficha_SC,id_ficha_E,id_ficha_TSUC,id_ficha_PA,id_ficha_Pre,id_usuario_fichas,id_director,
        id_secpla_usuario,AoR_secpla,comentario_usuario,comentario_director,comentarios_secpla,monto_recomendado_secpla,clasificador_secpla,
        fecha_comentario)
        VALUES ('','','','$id_secpla_rechazar_PY','','','','','','','','','','$id_usuario','Rechazada',
        '','','$comentarios_secpla','$monto_recomendado_secpla','$clasificador_secpla','$fecha_secpla')");

  $sql = $conexion->query("UPDATE ficha_proyectos SET estado_ficha_PY = 6
            WHERE id_PY = '$id_secpla_rechazar_PY'");
  $sql = $conexion->query("UPDATE fichas_general_secpla SET estado_secpla = 6
            WHERE id_fichas = '$id_secpla_rechazar_PY'");

  define('SUCCESS', 1);
  define('ERROR', 0);
  if ($sql == SUCCESS) {
    echo "¡Ficha aceptada correctamente!";
    header("Location: http://localhost/Sistema/Secpla/inicio_secpla.php");
    die();
  } else {
    echo '<div class="alert alert-danger">' . htmlspecialchars("ERROR") . '</div>';
  }
}
?>



