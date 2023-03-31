<!--Ficha configurada para el ingreso del detalle de la ficha Proyecto.-->
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

include("/xampp/htdocs/Sistema/controladores/cre_fichas/conexion_fichas.php");
include('/xampp/htdocs/Sistema/controladores/cre_fichas/registro_ficha_PY.php');

$sql = "SELECT * FROM tipo_ficha WHERE id_tipo_ficha = 3";
$result = mysqli_query($conexion1, $sql);
$datos = mysqli_fetch_object($result);

$sql = "SELECT * FROM estado_ficha WHERE id_estado_ficha = 1";
$result = mysqli_query($conexion1, $sql);
$resultad = mysqli_fetch_object($result);

$sql = "SELECT * FROM usuario WHERE id = '" . $_SESSION['id'] . "'";
$result = mysqli_query($conexion1, $sql);
$resultado = mysqli_fetch_object($result);
?>

<!DOCTYPE html>
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
      font-family: Arial, Helvetica, sans-serif;
    }

        .container {
            border: 1px solid black;
            margin-left: 100px;
            margin-top: 20px;
            max-width: 1900px;
        }

        .container input {
            border: 1px solid black;
        }

        .container textarea {
            border: 1px solid black;
        }

        .container select {
            border: 1px solid black;
        }

        .left-column {
            border-radius: 10px;
            width: 100%;
            background-color: white;
            padding: 15px;
            box-shadow: 0px 0px 8px #c2c2c2;
        }

        .right-column {
            border-radius: 10px;
            width: 100%;
            background-color: white;
            padding: 15px;
            box-shadow: 0px 0px 8px #c2c2c2;
        }

        .table-container {
            border-radius: 10px;
            width: 100%;
            background-color: white;
            padding: 15px;
            box-shadow: 0px 0px 8px #c2c2c2;
        }

        .table-container table {
            margin: 30px;
            padding: 20px;
        }

        label {
            font-size: 22px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="" method="POST" style="display: flex; width: 100%;">
            <input type="hidden" name="tipo_ficha_PY" value="<?= $datos->id_tipo_ficha ?>">
            <input type="hidden" name="id_usuario_PY" value="<?= $resultado->id ?>">
            <input type="hidden" name="id_estado_ficha_PY" value="<?= $resultad->id_estado_ficha ?>">
            <input type="date" id="fecha" name="fecha_PY" class="form-control" value="<?php echo date('Y-m-d') ?>" readonly style="display: none;">

            <div class="left-column" style="flex-basis: 40%">
                <h2>Ficha Proyectos</h2>
                <hr>
                <label>Nombre Ficha</label>
                <input type="text" name="nombre_PY" class="form-control" placeholder="Favor ingresar nombre de la ficha" required>
                <br>
                <label>Descripcion del Proyecto</label>
                <textarea type="text" rows="5px" name="descripcion_PY" class="form-control" placeholder="Descripcion" required></textarea>
                <br>
                <label>Justificacion del Proyecto</label>
                <textarea type="text" rows="5px" name="justificacion_PY" class="form-control" placeholder="Justificacion" required></textarea>
                <br>
                <label>Area de Gestion</label>
                <br>
                <select name="gestion_PY" class="form-control" required>
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
                <select name="clasi_PY" class="form-control" required>
                    <option selected disabled value="0">Favor clasificar...</option>
                    <?php
                    $query = $conexion1->query("SELECT * FROM clasificador_presupuestario");
                    while ($valores = mysqli_fetch_array($query)) {
                        echo '<option value="' . $valores['id_cla_presupuestario'] . '">' . $valores['nombre_cuenta'] . '</option>';
                    }
                    ?>
                </select>
                <br>
                <label>Direccion Municipal</label>
                <select name="di_municipal_PY" class="form-select" required>
                    <option selected disabled value="0">Seleccione direccion perteneciente:...</option>
                    <?php
                    $query = $conexion1->query("SELECT * FROM direccion WHERE id_direccion = $id_direccion ");
                    while ($valores = mysqli_fetch_array($query)) {
                        echo '<option value="' . $valores['id_direccion'] . '">' . $valores['desc_direccion'] . '</option>';
                    }
                    ?>
                </select>
                <br>
                <br><br>
                <a href="../../Usuario/crear_ficha.php" class="btn btn-primary">Regresar</a>
            </div>
            <div class="right-column" style="flex-basis: 30%; margin-left: 30px;">
                <h2>Ubicacion del proyecto</h2>
                <hr>
                <label>Unidad vecinal</label>
                <input type="text" name="vecinal_PY" class="form-control" required>
                <br>
                <label>Poblacion</label>
                <input type="text" name="poblacion_PY" class="form-control" required>
                <br>
                <label>Direccion del terreno</label>
                <input type="text" name="terreno_PY" class="form-control" required>
                <br>
                <label>Propiedad del terreno</label>
                <input type="text" name="propiedad_PY" class="form-control" required>
                <br>
                <label>Plazo de ejecucion</label>
                <input type="text" name="plazoEje_PY" class="form-control" required>
                <br>
                <label>Fecha estimada de inicio</label>
                <input type="date" name="fecha_inicio_PY" class="form-control" required>
                <hr>
                <label>Fecha estimada de termino</label>
                <input type="date" name="fecha_ter_PY" class="form-control" required>
                <br>
                <label>Procedimiento propuesto de ejecucion del proyecto</label>
                <br>
                <select name="propuesta_eje_PY" class="form-control" required>
                    <option selected disabled value="0">Seleccione ....</option>
                    <option value="Contratacion Externa">Contratacion Externa</option>
                    <option value="Ejecucion Directa">Ejecucion Directa</option>
                </select>
            </div>
            <div class="table-container" style="flex-basis: 40%; margin-left: 30px;">
                <h2>Indicadores del proyecto</h2>
                <hr>
                <table>
                    <tr>
                        <th><label>Nº de Beneficiarios</label></th>
                        <th><label>Inversion por Beneficiario</label></th>
                    </tr>
                    <tr>
                        <td><input type="number" name="beneficiados_PY" style="width: 40%" class="form-control" required></td>
                        <td><input type="number" name="inversion_ben_PY" style="float:right" class="form-control" required></td>
                    </tr>
                </table>
                <label>Costo del M2 de contruccion</label>
                <input type="number" name="metros_PY" class="form-control" required>
                <br>
                <label>Costos anuales de mantencion de la obra</label>
                <input type="number" name="anual_costo_PY" class="form-control" required>
                <br>
                <label for="monto">Monto Solicitado:</label>
                <input type="number" id="monto" name="monto_solicitado_PY" step="0.01" class="form-control" required>
                <br>
                <label>Aportes Externos:</label>
                <input type="number" id="aportes" name="aportes_externos_PY" step="0.01" class="form-control" required>
                <br>
                <label>Total:</label>
                <input type="number" id="total" name="total_PY" readonly>
                <br>
                <br>
                <label>Prioridad</label>
                <br>
                <select name="prioridad_PY" class="form-select" required>
                    <option selected disabled value="0">Prioridad:...</option>
                    <?php
                    $query = $conexion1->query("SELECT * FROM prioridad");
                    while ($valores = mysqli_fetch_array($query)) {
                        echo '<option value="' . $valores['id_prioridad'] . '">' . $valores['prioridades'] . '</option>';
                    }
                    ?>
                </select>
                <br>
                <br><br><br><br><br><br><br>
                <input type="submit" class="btn btn-success" style="float:right" value="Guardar" name="guardar_PY">
            </div>
    </div>
    </form>
    </div>
</body>
</html>
<!--Aca usamos el mismo scripts de las paginas anteriores para ir mostrando el monto total de lo que se esta ingresando-->
<script>
    var monto_solicitado = document.getElementsByName('monto_solicitado_PY')[0];
    var aportes_externos = document.getElementsByName('aportes_externos_PY')[0];
    var total = document.getElementsByName('total_PY')[0];

    monto_solicitado.addEventListener('input', updateTotal);
    aportes_externos.addEventListener('input', updateTotal);

    function updateTotal() {
        var monto = parseFloat(monto_solicitado.value) || 0;
        var aportes = parseFloat(aportes_externos.value) || 0;
        total.value = (monto + aportes).toFixed(2);
    }
</script>