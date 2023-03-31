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
$iden_PY = $_GET['id_PY'];
$sql = "SELECT ficha_proyectos.id_PY,
ficha_proyectos.nombre_ficha_PY,
ficha_proyectos.fecha_PY,
ficha_proyectos.total_PY,
ficha_proyectos.usuario_PY,
ficha_proyectos.prioridad_PY,
ficha_proyectos.descripcion_PY,
ficha_proyectos.justificacion_PY,
ficha_proyectos.financiamiento_PY,
ficha_proyectos.aportes_externos_PY,
ficha_proyectos.total_PY,
ficha_proyectos.unidad_vecinal_PY,
ficha_proyectos.poblacion_PY,
ficha_proyectos.direccion_comuna_PY,
ficha_proyectos.propiedad_terreno_PY,
ficha_proyectos.plazo_ejecucion_PY,
ficha_proyectos.fecha_estima_inicio_PY,
ficha_proyectos.fecha_estima_termi_PY,
ficha_proyectos.procedimiento_PY,
ficha_proyectos.numero_benef_PY,
ficha_proyectos.inversionx_benefi_PY,
ficha_proyectos.costo_M2_construccion_PY,
ficha_proyectos.costo_anual_PY,
usuario.id,
usuario.nombre,
usuario.apellido,
tipo_ficha.desc_tipo_ficha,
direccion.desc_direccion,
estado_ficha.desc_estado_ficha,
areas_gestion.desc_area_gestion,
clasificador_presupuestario.nombre_cuenta,
prioridad.prioridades
FROM ficha_proyectos
INNER JOIN direccion ON ficha_proyectos.direccion_PY  = direccion.id_direccion
INNER JOIN prioridad ON ficha_proyectos.prioridad_PY  = prioridad.id_prioridad
INNER JOIN tipo_ficha ON ficha_proyectos.tipo_ficha_PY = tipo_ficha.id_tipo_ficha
INNER JOIN usuario ON ficha_proyectos.usuario_PY = usuario.id
INNER JOIN estado_ficha ON ficha_proyectos.estado_ficha_PY = estado_ficha.id_estado_ficha
INNER JOIN areas_gestion ON ficha_proyectos.gestion_PY = areas_gestion.id_area_gestion
INNER JOIN clasificador_presupuestario ON ficha_proyectos.clasificacion_PY = clasificador_presupuestario.id_cla_presupuestario
WHERE id_PY = $iden_PY";
$mostrar = mysqli_query($conexion1, $sql);
$datos_PY = mysqli_fetch_assoc($mostrar);

$sql = "SELECT * FROM ficha_py_detalle_anual where id_PY_derivado = $iden_PY";
$mostrar2 = mysqli_query($conexion1, $sql);

$query = "SELECT SUM(total_PY) AS total FROM ficha_py_detalle_anual WHERE id_PY_derivado = $iden_PY ";
$result = mysqli_query($conexion1, $query);
$row = mysqli_fetch_assoc($result);
$total_gasto_PY = $row['total'];
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
      background-image: url('../../img/1366_2000.webp');
      background-size: cover;
      font-size: 20px;
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
padding: 10px;
      border: 1px solid white;
      max-width: 1900px;
    }
    .left-column{
        width: 40%;
    }
    .right-column{
        width: 50%;
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
  <!-- Tablas para que los datos se reflejen-->
  <body>
    <div class="container">
      <div class="left-column">
        <table class="table  table-hover table-dark">
          <tbody>
            <tr>
              <td><strong>Nombre:</strong></td>
              <td><?php echo $datos_PY['nombre_ficha_PY'] ?></td>
            </tr>
            <tr>
              <td><strong>Tipo Ficha:</strong></td>
              <td><?php echo $datos_PY['desc_tipo_ficha'] ?></td>
            </tr>
            <tr>
              <td><strong>Fecha:</strong></td>
              <td><?php echo $datos_PY['fecha_PY'] ?></td>
            </tr>
            <tr>
              <td><strong>Direccion:</strong></td>
              <td><?php echo $datos_PY['desc_direccion'] ?></td>
            </tr>
            <tr>
              <td><strong>Monto Solicitado:</strong></td>
              <td><?php echo $datos_PY['financiamiento_PY'] ?></td>
            </tr>
            <tr>
              <td><strong>Aportes Externos:</strong></td>
              <td><?php echo $datos_PY['aportes_externos_PY'] ?></td>
            </tr>
            <tr>
              <td><strong>Total:</strong></td>
              <td><?php echo $datos_PY['total_PY'] ?></td>
            </tr>
            <tr>
              <td><strong>Personal:</strong></td>
              <td><?php echo $datos_PY['nombre'] ?> <?php echo $datos_PY['apellido'] ?></td>
            </tr>
            <tr>
            <td><strong>Area Gestion:</strong></td>
            <td><?php echo $datos_PY['desc_area_gestion'] ?></td>
          </tr>
          <tr>
            <td><strong>Clasificador:</strong></td>
            <td><?php echo $datos_PY['nombre_cuenta'] ?></td>
          </tr>
          <tr>
            <td><strong>Justificacion:</strong></td>
            <td><?php echo $datos_PY['justificacion_PY'] ?></td>
          </tr>
          <tr>
            <td><strong>Descripcion:</strong></td>
            <td><?php echo $datos_PY['descripcion_PY'] ?></td>
          </tr>
          </tbody>
        </table>
      </div>
      <div class="right-column">
        <table class="table  table-hover table-dark">
        <tr>
            <td><strong>Unidad Vecinal:</strong></td>
            <td><?php echo $datos_PY['unidad_vecinal_PY'] ?></td>
          </tr>
          <tr>
            <td><strong>Poblacion:</strong></td>
            <td><?php echo $datos_PY['poblacion_PY'] ?></td>
          </tr>
          <tr>
            <td><strong>Direccion Comuna:</strong></td>
            <td><?php echo $datos_PY['direccion_comuna_PY'] ?></td>
          </tr>
          <tr>
            <td><strong>Propiedad Terreno:</strong></td>
            <td><?php echo $datos_PY['propiedad_terreno_PY'] ?></td>
          </tr>
          <tr>
            <td><strong>Plazo de ejecucion:</strong></td>
            <td><?php echo $datos_PY['plazo_ejecucion_PY'] ?></td>
          </tr>
          <tr>
            <td><strong>Fecha estimada Inicio:</strong></td>
            <td><?php echo $datos_PY['fecha_estima_inicio_PY'] ?></td>
          </tr>
          <tr>
            <td><strong>Fecha estimada Termino:</strong></td>
            <td><?php echo $datos_PY['fecha_estima_termi_PY'] ?></td>
          </tr>
          <tr>
            <td><strong>Tipo de Procedimiento:</strong></td>
            <td><?php echo $datos_PY['procedimiento_PY'] ?></td>
          </tr>
          <tr>
          <td><strong>Nº de Beneficiarios:</strong></td>
            <td><?php echo $datos_PY['numero_benef_PY'] ?></td>
          </tr>
          <tr>
            <td><strong>Inversion por Beneficiario:</strong></td>
            <td><?php echo $datos_PY['inversionx_benefi_PY'] ?></td>
          </tr>
          <tr>
            <td><strong>Costo M2 de Contruccion:</strong></td>
            <td><?php echo $datos_PY['costo_M2_construccion_PY'] ?></td>
          </tr>
          <tr>
            <td><strong>Inversion Anual:</strong></td>
            <td><?php echo $datos_PY['costo_anual_PY'] ?></td>
          </tr>
        </table>
      </div>
    </div>
    <hr>
    <table class="table  table-hover table-dark">
      <thead>
        <tr>
          <th>Partida</th>
          <th>Unidad Medicicion</th>
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
        while ($detalle_PY = mysqli_fetch_array($mostrar2)) {
        ?>
          <tr>
            <td><?php echo $detalle_PY['descripcion_gasto_PY'] ?></td>
            <td><?php echo $detalle_PY['unidades_partida_PY'] ?></td>
            <td><?php echo $detalle_PY['cantidad_PY_partida'] ?></td>
            <td><?php echo $detalle_PY['precio_unit_PY'] ?></td>
            <td><?php echo $detalle_PY['total_PY'] ?></td>
            <td><?php echo $detalle_PY['enero_PY'] ?></td>
            <td><?php echo $detalle_PY['febrero_PY'] ?></td>
            <td><?php echo $detalle_PY['marzo_PY'] ?></td>
            <td><?php echo $detalle_PY['abril_PY'] ?></td>
            <td><?php echo $detalle_PY['mayo_PY'] ?></td>
            <td><?php echo $detalle_PY['junio_PY'] ?></td>
            <td><?php echo $detalle_PY['julio_PY'] ?></td>
            <td><?php echo $detalle_PY['agosto_PY'] ?></td>
            <td><?php echo $detalle_PY['septiembre_PY'] ?></td>
            <td><?php echo $detalle_PY['octubre_PY'] ?></td>
            <td><?php echo $detalle_PY['noviembre_PY'] ?></td>
            <td><?php echo $detalle_PY['diciembre_PY'] ?></td>
          </tr>
        <?php
        }
        ?>
        <tr>
          <th>Total Invertido</th>
          <td colspan="15"></td>
          <th><?php echo $total_gasto_PY ?></th>
        </tr>
      </tbody>
    </table>
    <!-- Botones relacionados a las acciones a realizar -->
    <div class="button-container">
      <a href="../../Administrador/vistas_detalle_fichas/detalle_fichas_usuarios_area.php"><button class="btn btn-dark">Regresar</button></a>
      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-rechazar">Rechazar</button>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-aceptar">Aceptar</button>
    </div>

    <!-- Ventanas desplegables para el envio de los datos -->
    <!-- Aceptar -->
    <div class="modal fade" id="modal-aceptar" tabindex="-1" role="dialog" aria-labelledby="modal-aceptar-label" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal-aceptar-label">Aceptar ficha</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="../../controladores/Admi/ficha_aceptar.php" method="POST">
              <input type="hidden" name="ficha_acept_PY" value="<?php echo $iden_PY ?>">
              <input type="hidden" name="ficha_acep_PY_user" value="<?php echo $datos_PY['id'] ?>">
              <div class="form-group">
                <label>Fecha</label>
                <input type="date" name="fecha_director_aceptar_PY" value="<?php echo date('Y-m-d') ?>" class="form-control" readonly>
              </div>
              <div class="form-group">
                <label for="observaciones">Observaciones:</label>
                <textarea type="text" class="form-control" id="observaciones" name="observaciones_director_aceptar_PY"></textarea>
              </div>
              <button type="submit" name="ficha_aceptar_director_PY" class="btn btn-success">Aceptar</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Rechazar -->
    <div class="modal fade" id="modal-rechazar" tabindex="-1" role="dialog" aria-labelledby="modal-rechazar-label" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal-rechazar-label">Rechazar ficha</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="../../controladores/Admi/ficha_rechazar.php" method="POST">
              <input type="hidden" name="ficha_rechazar_PY" value="<?php echo $iden_PY ?>">
              <input type="hidden" name="ficha_recha_PY_user" value="<?php echo $datos_PY['id'] ?>">

              <div class="form-group">
                <label>Fecha</label>
                <input type="date" name="fecha_director_rechazar_PY" value="<?php echo date('Y-m-d') ?>" class="form-control" readonly>
              </div>
              <div class="form-group">
                <label for="motivo">Motivo:</label>
                <textarea class="form-control" id="motivo" name="observaciones_director_rechazar_PY" ></textarea>
              </div>
              <button type="submit" name="ficha_rechazar_director_PY" class="btn btn-danger">Rechazar</button>
            </form>
          </div>
        </div>
  </body>
</html>