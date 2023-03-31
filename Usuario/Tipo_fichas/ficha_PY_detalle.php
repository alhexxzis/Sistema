<!--Esta vista fue configurada para ingresar el detalle de las partidas asociadas a la ficha contratos.
Como en la vista ficha_gastos_corrientes_detalle usamos el procedimiento de arrays para ir guardando los datos.-->
<?php
session_start();
if (empty($_SESSION['nombre']) and empty($_SESSION['apellido'])) {
  header('location:../login.php');
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
include("/xampp/htdocs/Sistema/controladores/cre_fichas/registro_PY_detalle.php");
$id_PY = $_GET['id_PY'];

$sql = "SELECT * FROM ficha_proyectos where id_PY = $id_PY";
$mostrar = mysqli_query($conexion1, $sql);
$fila = mysqli_fetch_assoc($mostrar);

$sql = "SELECT * FROM ficha_py_detalle_anual WHERE id_PY_derivado = $id_PY ";
$mostrar2 = mysqli_query($conexion1, $sql);
$suma_anual_py = 0; /*$variable para ir guardando las sumas. */
$PY_id_det = array(); /*Aca dejamos el arrays para ir guardando los datos. */

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Presupuesto SECPLA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <style>
    body {
      background-image: url('../../img/1366_2000.webp');
      background-size: cover;
      font-family: Arial, Helvetica, sans-serif;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px;
      background-color: rgba(1, 0, 0, 0.7);
      color: white;
    }

    .header h1 {
      margin: 0;
      font-size: 24px;
    }

    .header a {
      color: white;
      text-decoration: none;
      margin-right: 10px;
      font-size: 24px;
    }

    .header button {
      margin-left: 10px;
      font-size: 24px;
    }

    .container {
      margin: 20px;
      width: 100%;
      max-width: 1950px;
      font-family: Arial, Helvetica, sans-serif;
      border: 1px solid white;
    }

    .table-container {
      margin: 20px;
      font-family: Arial, Helvetica, sans-serif;
      max-width: 1950px;
      border: 1px solid white;
    }

    #tabla_partida {
      max-width: 1200px;
    }

    th {
      font-size: 22px;
    }

    td {
      font-size: 18px;
    }

    h3 {
      border: 1px solid white;
      padding: 10px;
      border-radius: 10px;
      background-color: black;
    }
  </style>
</head>
<tbody>
  <div class="header">
    <h1><?php echo $_SESSION['nombre'] ?></h1>
    <div>
      <a href="../../Usuario/inicio_usuario.php">Inicio</a>
      <a href="../../controladores/usuario_cerrar_session.php">
        <button type="button" class="btn btn-dark">Cerrar sesión</button>
      </a>
    </div>
  </div>
</tbody>
<br>
<!--Aca realizamos el mismo proceso, ingresamos el detalle y luego los montos anuales.-->
<body>
<center><h1 style="color:white;">FICHA PROYECTOS (DETALLE DE PARTIDAS).</h1></center>
<br>
  <h2 style="color:white; margin-left:30px">Detalle de Partidas</h2>
  <tr>
    <td colspan="18">
      <hr>
    </td>
  </tr>
  <h3 style="float:right ; margin-right:20px ; color: white;">Solicitado: $ <?php echo $fila['total_PY'] ?></h3>
  <div class="container">
    <form action="" method="post">
      <table id="tabla_partida" class="table table-bordered table-hover table-dark table-responsive">
        <tr>
          <th>Descripcion de partidas</th>
          <th>Unidad de medicion</th>
          <th>Cantidad</th>
          <th>Precio Unitario</th>
          <th>Total</th>
          <th>Acciones</th>
        <tr>
          <input type="hidden" name="id_PY_derivado" value="<?php echo $id_PY ?>">
          <input type="hidden" name="id_PY_monto_derivado" value="<?php echo $fila['total_PY'] ?>">
          <td><input type="text" class="form-control" name="py_partida" placeholder="Indicando las partidas de: terreno, obras civiles, y del equipamiento si se postula con este. " required></td>
          <td> <input type="text" class="form-control" name="py_medicion" placeholder="ej: personas, centimentros, kilogramos, etc ..." required></td>
          <td><input type="number" class="form-control" name="py_cantidad" required></td>
          <td><input type="number" class="form-control" name="py_precio_unitario" required></td>
          <td><input type="number" name="total_partida" class="form-control" readonly></td>
          <td><input type="submit" class="btn btn-primary" value="Agregar" name="submit_PY_partida"></td>
        </tr>
      </table>
    </form>
    <form action="" method="post">
      <hr style="color:white;">
      <table class="table table-bordered table-hover table-dark table-responsive">
        <tr>
        <th scope="col">ID</th>
          <th scope="col">Partidas</th>
          <th scope="col">Unidad de medicion</th>
          <th scope="col">Cantidad</th>
          <th scope="col">Precio Unitario</th>
          <th scope="col">Total Unidad</th>
          <th scope="col">Ene</th>
          <th scope="col">Feb</th>
          <th scope="col">Marz</th>
          <th scope="col">Abril</th>
          <th scope="col">Mayo </th>
          <th scope="col">Junio</th>
          <th scope="col">Julio</th>
          <th scope="col">Agosto</th>
          <th scope="col">Sep</th>
          <th scope="col">Octub</th>
          <th scope="col">Nov</th>
          <th scope="col">Dic</th>
          <th scope="col">Total</th>
          <th>Acciones</th>
        </tr>
        <?php
        while ($detalle_anual = mysqli_fetch_array($mostrar2)) {
          $PY_id_det[] = $detalle_anual['id_PY_detalle']; /*Aca vamos almacenando en una lista los datos que necesitamos que se guarden. */
          $suma_anual_py += $detalle_anual['total_PY'];
        ?>
          <tr>
          <td><?php echo $detalle_anual['id_PY_detalle'] ?></td>
            <td><?php echo $detalle_anual['descripcion_gasto_PY'] ?></td>
            <td><?php echo $detalle_anual['unidades_partida_PY'] ?></td>
            <td><?php echo $detalle_anual['cantidad_PY_partida'] ?></td>
            <td><?php echo $detalle_anual['precio_unit_PY'] ?></td>
            <td><?php echo $detalle_anual['total_PY'] ?></td>
            <input type="hidden" class="form-control" name="PY_id_ficha_det[]" value="<?php echo $detalle_anual['id_PY_detalle'] ?>">
            <input type="hidden" class="form-control" name="PY_id_ficha_deriv" value="<?php echo $detalle_anual['id_PY_derivado'] ?>">
            <input type="hidden" class="form-control" name="PY_monto_requerido" value="<?php echo $fila['total_PY'] ?>">
            <td><input type="text" class="form-control py-input" name="PY_Enero[]" placeholder="0"></td>
            <td><input type="text" class="form-control py-input" name="PY_Febrero[]" placeholder="0"></td>
            <td><input type="text" class="form-control py-input" name="PY_Marzo[]" placeholder="0"></td>
            <td><input type="text" class="form-control py-input" name="PY_Abril[]" placeholder="0"></td>
            <td><input type="text" class="form-control py-input" name="PY_Mayo[]" placeholder="0"></td>
            <td><input type="text" class="form-control py-input" name="PY_Junio[]" placeholder="0"></td>
            <td><input type="text" class="form-control py-input" name="PY_Julio[]" placeholder="0"></td>
            <td><input type="text" class="form-control py-input" name="PY_Agosto[]" placeholder="0"></td>
            <td><input type="text" class="form-control py-input" name="PY_Septiembre[]" placeholder="0"></td>
            <td><input type="text" class="form-control py-input" name="PY_Octubre[]" placeholder="0"></td>
            <td><input type="text" class="form-control py-input" name="PY_Noviembre[]" placeholder="0"></td>
            <td><input type="text" class="form-control py-input" name="PY_Diciembre[]" placeholder="0"></td>
            <td><?php echo $detalle_anual['total_PY'] ?></td>
            <td><a href="../../controladores/cre_fichas/eliminar_PY_anual.php?id_PY_detalle=<?php echo $detalle_anual['id_PY_detalle'] ?>&id_PY_derivado=<?php echo $id_PY ?>">
                <button type="button" class="btn btn-danger">Eliminar</button></a>
            </td>
          </tr>
        <?php
        }
        ?>
              <th>Total:</th>
      <th colspan="17"></th>
      <th><?php echo $suma_anual_py; ?></th>
      <th></th>
      </tr>
      </table>
      <th><a href="" style="float:right"><input type="submit" name="anual_py_guardar" class="btn btn-success" value="Enviar"></a>
        <a href="../inicio_usuario.php"><button type="button" class="btn btn-light">Regresar</button></a>
      </th>
    </form>
  </div>
</body>
<!--Aca realizamos la multiplicacion y vamos mostrando el dato.-->

<script>
  var unidades_sol = document.getElementsByName('py_cantidad')[0];
  var py_precio_unitario = document.getElementsByName('py_precio_unitario')[0];
  var total = document.getElementsByName('total_partida')[0];

  unidades_sol.addEventListener('input', updateTotal);
  py_precio_unitario.addEventListener('input', updateTotal);

  function updateTotal() {
    var monto = parseFloat(unidades_sol.value) || 0;
    var aportes = parseFloat(py_precio_unitario.value) || 0;
    total.value = (monto * aportes).toFixed(2);
  }
</script>

</html>