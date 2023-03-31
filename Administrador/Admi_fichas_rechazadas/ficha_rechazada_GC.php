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
  $id_usaurio = htmlspecialchars($id_usuarioSession);
}
if (!isset($_SESSION['id_tipo_usuario'])) {
  header('location:../login.php');
} else {
  if ($_SESSION['id_tipo_usuario'] != 1) {
    header('location:../login.php');
  }
}
?>

<?php
include("/xampp/htdocs/Sistema/controladores/cre_fichas/conexion_fichas.php");
$iden_FGC = $_GET['id_GC'];
$sql = "SELECT  ficha_gastos_corrientes.id_GC,
ficha_gastos_corrientes.nombre_GC,
ficha_gastos_corrientes.fecha_GC,
ficha_gastos_corrientes.financiamiento_sol_GC,
ficha_gastos_corrientes.estado_ficha_GC,
ficha_gastos_corrientes.justificacion_GC,
ficha_gastos_corrientes.descripcion_gasto_GC,
ficha_gastos_corrientes.gestion_GC,
ficha_gastos_corrientes.clasificador_GC,
areas_gestion.desc_area_gestion,
clasificador_presupuestario.nombre_cuenta,
usuario.id,
usuario.nombre,
usuario.apellido,
tipo_ficha.desc_tipo_ficha,
direccion.desc_direccion,
prioridad.prioridades,
estado_ficha.desc_estado_ficha
from ficha_gastos_corrientes
INNER JOIN direccion ON ficha_gastos_corrientes.direccion_mun_GC = direccion.id_direccion
INNER JOIN prioridad ON ficha_gastos_corrientes.prioridad_GC = prioridad.id_prioridad
INNER JOIN tipo_ficha ON ficha_gastos_corrientes.tipo_ficha_GC = tipo_ficha.id_tipo_ficha
INNER JOIN usuario ON ficha_gastos_corrientes.GC_usuario = usuario.id
INNER JOIN estado_ficha ON ficha_gastos_corrientes.estado_ficha_GC = estado_ficha.id_estado_ficha
INNER JOIN areas_gestion ON ficha_gastos_corrientes.gestion_GC = areas_gestion.id_area_gestion
INNER JOIN clasificador_presupuestario ON ficha_gastos_corrientes.clasificador_GC = clasificador_presupuestario.id_cla_presupuestario
WHERE id_GC = $iden_FGC";
$mostrar = mysqli_query($conexion1, $sql);
$datos_FGC = mysqli_fetch_assoc($mostrar);

$sql = "SELECT * FROM ficha_gastos_detalle where id_fichas_GC = $iden_FGC";
$mostrar2 = mysqli_query($conexion1, $sql);

$query = "SELECT SUM(total_gasto_GC) AS total FROM ficha_gastos_detalle WHERE id_fichas_GC = $iden_FGC ";
$result = mysqli_query($conexion1, $query);
$row = mysqli_fetch_assoc($result);
$total_gasto_FGC = $row['total'];

$sql = "SELECT * FROM caja_comentarios_secpla WHERE id_ficha_GC = $iden_FGC AND LENGTH(comentarios_secpla) > 0 LIMIT 1";
$mostrar3 = mysqli_query($conexion1, $sql);
$comentarios = mysqli_fetch_assoc($mostrar3);
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <title>Presupuesto SECPLA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <style>
    body {
      background-image: url('../../img/OIP.jfif');
      background-size: cover;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px;
      background-color: #343a40;
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
    }

    .header button {
      margin-left: 10px;
    }

    table {
      margin: 0 auto;
      max-width: 90%;
      justify-content: space-between;

    }

    .container {
      display: flex;
      justify-content: left;
    }

    .left-column {
      width: 50%;
    }

    .right-column {
      width: 48%;
    }

    .button-container {
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="header">
    <h1><?php echo $_SESSION['nombre'] ?></h1>
    <div>
      <a href="../../Administrador/inicio_admi.php">Inicio</a>
      <a href="../../Administrador/lista_usuarios.php">Lista Usuarios</a>
      <a href="../Administrador/crear_usuarios_admi.php">Crear usuarios</a>
      <a href="../../Administrador/fichas_revisar.php">Revisar Fichas</a>
      <a href="../../controladores/usuario_cerrar_session.php"><button type="button" class="btn btn-dark">Cerrar sesión</button></a>
    </div>
  </div>
  <br>
  <br>
  <body>
    <div class="container">
      <div class="left-column">
        <table class="table table-striped table-dark">
          <tbody>
            <tr>
              <td><strong>Nombre:</strong></td>
              <td><?php echo $datos_FGC['nombre_GC'] ?></td>
            </tr>
            <tr>
              <td><strong>Tipo Ficha:</strong></td>
              <td><?php echo $datos_FGC['desc_tipo_ficha'] ?></td>
            </tr>
            <tr>
              <td><strong>Fecha:</strong></td>
              <td><?php echo $datos_FGC['fecha_GC'] ?></td>
            </tr>
            <tr>
              <td><strong>Direccion:</strong></td>
              <td><?php echo $datos_FGC['desc_direccion'] ?></td>
            </tr>
            <tr>
              <td><strong>Monto Solicitado:</strong></td>
              <td><?php echo $datos_FGC['financiamiento_sol_GC'] ?></td>
            </tr>
            <tr>
              <td><strong>Personal:</strong></td>
              <td><?php echo $datos_FGC['nombre'] ?> <?php echo $datos_FGC['apellido'] ?></td>
            </tr>
            <tr>
              <td><strong>Estado:</strong></td>
              <td><?php echo $datos_FGC['desc_estado_ficha'] ?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="right-column">
        <table class="table table-striped table-dark">
          <tr>
            <td><strong>Area Gestion:</strong></td>
            <td><?php echo $datos_FGC['desc_area_gestion'] ?></td>
          </tr>
          <tr>
            <td><strong>Clasificador:</strong></td>
            <td><?php echo $datos_FGC['nombre_cuenta'] ?></td>
          </tr>
          <tr>
            <td><strong>Justificacion:</strong></td>
            <td><?php echo $datos_FGC['justificacion_GC'] ?></td>
          </tr>
          <tr>
            <td><strong>Descripcion:</strong></td>
            <td><?php echo $datos_FGC['descripcion_gasto_GC'] ?></td>
          </tr>
          <tr>
            <td><strong>Comentarios:</strong></td>
            <td><?php echo $comentarios['comentarios_secpla'] ?></td>
          </tr>
        </table>
      </div>
    </div>
    <table class="table table-striped table-dark">
      <thead>
        <tr>
          <th>Articulo</th>
          <th>Cantidad</th>
          <th>Precio Unitario</th>
          <th>Total Unidad</th>
          <th>Enero</th>
          <th>Febrero</th>
          <th>Marzo</th>
          <th>Abril</th>
          <th>Mayo</th>
          <th>Junio</th>
          <th>Julio</th>
          <th>Agosto</th>
          <th>Sep</th>
          <th>Octubre</th>
          <th>Nov</th>
          <th>Dic</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($detalle_FGC = mysqli_fetch_array($mostrar2)) {
        ?>
          <tr>
            <td><?php echo $detalle_FGC['descripcion_producto_GC'] ?></td>
            <td><?php echo $detalle_FGC['unidades_GC'] ?></td>
            <td><?php echo $detalle_FGC['valor_GC'] ?></td>
            <td><?php echo $detalle_FGC['total_gasto_GC'] ?></td>
            <td><?php echo $detalle_FGC['enero_GC'] ?></td>
            <td><?php echo $detalle_FGC['febrero_GC'] ?></td>
            <td><?php echo $detalle_FGC['marzo_GC'] ?></td>
            <td><?php echo $detalle_FGC['abril_GC'] ?></td>
            <td><?php echo $detalle_FGC['mayo_GC'] ?></td>
            <td><?php echo $detalle_FGC['junio_GC'] ?></td>
            <td><?php echo $detalle_FGC['julio_GC'] ?></td>
            <td><?php echo $detalle_FGC['agosto_GC'] ?></td>
            <td><?php echo $detalle_FGC['septiembre_GC'] ?></td>
            <td><?php echo $detalle_FGC['octubre_GC'] ?></td>
            <td><?php echo $detalle_FGC['noviembre_GC'] ?></td>
            <td><?php echo $detalle_FGC['diciembre_GC'] ?></td>
          </tr>
        <?php
        }
        ?>
        <tr>
          <th>Total Invertido</th>
          <td colspan="14"></td>
          <th><?php echo $total_gasto_FGC ?></th>
        </tr>
      </tbody>
    </table>
    <!-- Botones relacionados a las acciones a realizar -->
    <div class="button-container">
      <a href="../../Administrador/inicio_admi.php"><button class="btn btn-dark">Regresar</button></a>
    </div>
  </body>

</html>