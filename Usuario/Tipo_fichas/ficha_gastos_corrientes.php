<!--Vista Configurada para realizar el llenado de la primera parte de la ficha Gastos Corrientes (Datos Generales)-->
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
  if ($_SESSION['id_tipo_usuario'] != 3) {
    header('location:../login.php');
  }
}
?>
<?php
include("/xampp/htdocs/Sistema/controladores/cre_fichas/conexion_fichas.php");

$sql = "SELECT * FROM tipo_ficha WHERE id_tipo_ficha = 1";
$result = mysqli_query($conexion1, $sql);
$datos = mysqli_fetch_object($result);

$sql = "SELECT * FROM estado_ficha WHERE id_estado_ficha = 1";
$result = mysqli_query($conexion1, $sql);
$resultad = mysqli_fetch_object($result);

$sql = "SELECT * FROM usuario WHERE id = '" . $_SESSION['id'] . "'";
$result = mysqli_query($conexion1, $sql);
$resultado = mysqli_fetch_object($result);

$sql = "SELECT * FROM direccion WHERE id_direccion = $id_direccion ";
$resultado1 = mysqli_query($conexion1,$sql);
$resulta1 = mysqli_fetch_object($resultado1);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <style>
    body {
      background-image: url('../../img/1366_2000.webp');
      background-size: cover;
      font-family: Arial, Helvetica, sans-serif;
    }

    .table-container {
      margin-left: 10px;
      margin-right: 20px;
      padding: 20px;
    }

    th,
    td,
    h3 {
      color: white;
    }

    label {
      color: white;
      font-size: 20px;
    }

    .container {

      border: 1px solid black;
      border-radius: 10px;
      background-color: rgba(1, 0, 0, 0.5);
      background-blend-mode: multiply;
      padding: 30px;
    }
  </style>
</head>
<br>

<body>
  <center>
    <h1 style="color:white ; margin-left: 10px;">Ficha Gastos Corrientes</h1>
  </center>
  <div class="container">
    <form action="../../controladores/cre_fichas/registro_ficha.php" method="POST">
      <div class="row">
        <div class="col-md-6">
          <label>Nombre Ficha</label>
          <input type="text" name="name" placeholder="Favor ingresar nombre de la postulacion" class="form-control" required>
          <br>
          <label>Fecha</label>
          <input type="date" name="fecha" value="<?php echo date('Y-m-d') ?>" class="form-control" readonly>
          <br>
          <input type="hidden" name="id_ficha" value="<?= $datos->id_tipo_ficha ?>">
          <input type="hidden" name="id_usuario" value="<?= $resultado->id ?>">
          <input type="hidden" name="id_estado_ficha" value="<?= $resultad->id_estado_ficha ?>">
          <input type="hidden" name="direc_municipal" value="<?= $resulta1 -> id_direccion ?>">
          <label>Monto solicitado</label>
          <input type="text" name="monto_GC" placeholder="Monto solicitado" class="form-control" required>
          <br>
          <label>Favor ingresar justificacion del gasto</label>
          <textarea rows="6px" type="text" name="justificacion" placeholder="ingresar aqui la justificacion del gasto" class="form-control" required></textarea>
          <br>
          <label>Favor describir motivo del gasto</label>
          <textarea type="text" rows="4px" name="descripcion" placeholder="favor ingresar una descripcion del gasto" class="form-control" required></textarea>
        </div>
        <div class="col-md-6">
          <label>Prioridad</label>
          <br>
          <select name="prioridad_GC" class="form-control" required>
            <option selected disabled value="0">Prioridad:...</option>
            <?php
            $query = $conexion1->query("SELECT * FROM prioridad");
            while ($valores = mysqli_fetch_array($query)) {
              echo '<option value="' . $valores['id_prioridad'] . '">' . $valores['prioridades'] . '</option>';
            }
            ?>
          </select>
          <br>
          <label>Area de Gestion</label>
          <br>
          <select name="gestion_GC" class="form-control" required>
            <option selected disabled value="0">Area ...</option>
            <?php
            $query = $conexion1->query("SELECT * FROM areas_gestion");
            while ($valores = mysqli_fetch_array($query)) {
              echo '<option value="' . $valores['id_area_gestion'] . '">' . $valores['desc_area_gestion'] . '</option>';
            }
            ?>
          </select>
          <br>
          <label>Clasificar Presupuesto</label>
          <br>
          <select name="clasi_GC" class="form-control" required>
            <option selected disabled value="0">Favor clasificar...</option>
            <?php
            $query = $conexion1->query("SELECT * FROM clasificador_presupuestario");
            while ($valores = mysqli_fetch_array($query)) {
              echo '<option value="' . $valores['id_cla_presupuestario'] . '">' . $valores['nombre_cuenta'] . '</option>';
            }
            ?>
          </select>
          <br><br><br><br><br><br><br><br><br><br><br>

        </div>
      </div>
      <br>
      <input type="submit" name="reg_ficha_part_uno" class="btn btn-success" value="Siguiente" style="float:right">
          <a href="../crear_ficha.php" class="btn btn-primary">Regresar</a>
    </form>
  </div>

</body>

</html>