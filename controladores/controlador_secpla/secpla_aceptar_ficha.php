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
include("/xampp/htdocs/Sistema/controladores/conexion.php");

/*Ficha Gastos Corrientes */
if (isset($_POST["ficha_aceptar_secpla"])) {
  $id_secpla_ficha_GC = $_POST["ficha_acept_secpla"];
  $fecha_secpla = $_POST["fecha_secpla_aceptar"];
  $comentarios_secpla = $_POST["observaciones_secpla_aceptar"];

  $sql = $conexion->query("INSERT INTO caja_comentarios_secpla (id_comentarios,id_ficha_GC,id_ficha_C,id_ficha_PY,
        id_ficha_PSO,id_ficha_AM,id_ficha_SC,id_ficha_E,id_ficha_TSUC,id_ficha_PA,id_ficha_Pre,id_usuario_fichas,id_director,
        id_secpla_usuario,AoR_secpla,comentario_usuario,comentario_director,comentarios_secpla,monto_recomendado_secpla,clasificador_secpla,
        fecha_comentario)
        VALUES ('','$id_secpla_ficha_GC','','','','','','','','','','','','$id_usuario','Aprobada',
        '','','$comentarios_secpla','','','$fecha_secpla')");
/*Como comentamos en las otras vistas, aca se cambia el estado de las fichas a 7 (aprobada), asi se determina que estas fichas cumplen
todos los estandares y fueron aprobadas por secpla */
  $sql = $conexion->query("UPDATE ficha_gastos_corrientes SET estado_ficha_GC = 7
            WHERE id_GC = '$id_secpla_ficha_GC'");

  $sql = $conexion->query("UPDATE fichas_general_secpla SET estado_secpla = 7
            WHERE id_fichas = '$id_secpla_ficha_GC'");

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
/*Ficha Contratos */
if (isset($_POST["aceptar_secpla_FC"])) {
  $id_secpla_ficha_FC = $_POST["ficha_acept_FC_secpla"];
  $fecha_secpla_FC = $_POST["secpla_aceptar_fecha_FC"];
  $comentarios_secpla_FC = $_POST["observaciones_secpla_aceptar_FC"];

  $sql = $conexion->query("INSERT INTO caja_comentarios_secpla (id_comentarios,id_ficha_GC,id_ficha_C,id_ficha_PY,
          id_ficha_PSO,id_ficha_AM,id_ficha_SC,id_ficha_E,id_ficha_TSUC,id_ficha_PA,id_ficha_Pre,id_usuario_fichas,id_director,
          id_secpla_usuario,AoR_secpla,comentario_usuario,comentario_director,comentarios_secpla,monto_recomendado_secpla,clasificador_secpla,
          fecha_comentario)
          VALUES ('','',$id_secpla_ficha_FC','','','','','','','','','','','$id_usuario','Aprobada',
          '','','$comentarios_secpla_FC','','','$fecha_secpla_FC')");

  $sql = $conexion->query("UPDATE ficha_contratos SET estado_ficha_FC = 7
              WHERE id_FC = '$id_secpla_ficha_FC'");

  $sql = $conexion->query("UPDATE fichas_general_secpla SET estado_secpla = 7
              WHERE id_fichas = '$id_secpla_ficha_FC'");

  define('SUCCESS', 1);
  define('ERROR', 0);
  if ($sql == SUCCESS) {
    echo "¡Ficha aceptada correctamente!";
    header("Location: http://localhost/Sistema/Secpla/inicio_secpla.php");
    die();
  } else {
    echo '<div class="alert alert-danger" role="alert">
              <i class="fas fa-times-circle"></i>
              Error al enviar la ficha. Favor revisar los datos e intentar nuevamente.
            </div>';
  }
}

/*Ficha Proyectos */
if (isset($_POST["ficha_aceptar_secpla_PY"])) {
  $id_secpla_ficha_PY = $_POST["ficha_acept_secpla_PY"];
  $fecha_secpla_PY = $_POST["fecha_secpla_aceptar_PY"];
  $comentarios_secpla_PY = $_POST["observaciones_secpla_aceptar_PY"];

  $sql = $conexion->query("INSERT INTO caja_comentarios_secpla (id_comentarios,id_ficha_GC,id_ficha_C,id_ficha_PY,
            id_ficha_PSO,id_ficha_AM,id_ficha_SC,id_ficha_E,id_ficha_TSUC,id_ficha_PA,id_ficha_Pre,id_usuario_fichas,id_director,
            id_secpla_usuario,AoR_secpla,comentario_usuario,comentario_director,comentarios_secpla,monto_recomendado_secpla,clasificador_secpla,
            fecha_comentario)
            VALUES ('','','','$id_secpla_ficha_PY','','','','','','','','','','$id_usuario','Aprobada',
            '','','$comentarios_secpla_PY','','','$fecha_secpla_PY')");

  $sql = $conexion->query("UPDATE ficha_proyectos SET estado_ficha_PY = 7
                WHERE id_PY = '$id_secpla_ficha_PY'");

  $sql = $conexion->query("UPDATE fichas_general_secpla SET estado_secpla = 7
                WHERE id_fichas = '$id_secpla_ficha_PY'");

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

