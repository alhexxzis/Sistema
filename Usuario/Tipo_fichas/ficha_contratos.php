<!--Vista realizada para el llenado de los datos de la ficha contratos.-->
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
<!--Conexion a la base de datos y las tablas.-->
<?php
include("/xampp/htdocs/Sistema/controladores/cre_fichas/conexion_fichas.php");


$sql = "SELECT * FROM tipo_ficha WHERE id_tipo_ficha = 2";
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

        .left-column {
            border: 1px solid black;
            border-radius: 10px;
            background-color: rgba(1,0,0,0.9);
            background-blend-mode: multiply;
            padding: 20px;
        }

        .right-column {
            border: 1px solid black;
            border-radius: 10px;
            background-color: rgba(1,0,0,0.9);
            background-blend-mode: multiply;
            padding: 20px;
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
    </style>
</head>

<body>
    <center>
        <h1 style="color:white">Ficha Contratos</h1>
    </center>
    <div class="container">
        <!--Metodo form para el envio de los datos, como te habia comentado, la opcion 'hidden' la usamos para que el dato no se refleje en la Vista-->
        <form action="../../controladores/cre_fichas/registro_ficha_FC.php" method="POST" style="display: flex; width: 100%;">
            <input type="hidden" name="id_ficha_FC" value="<?= $datos->id_tipo_ficha ?>">
            <input type="hidden" name="id_usuario_FC" value="<?= $resultado->id ?>">
            <input type="hidden" name="id_estado_ficha_FC" value="<?= $resultad->id_estado_ficha ?>">

            <div class="left-column" style="flex-basis: 60%; margin-right: 10px;">
                <label>Nombre Ficha</label>
                <input type="text" name="nombre_FC" class="form-control" placeholder="Favor ingresar nombre de la ficha" required>
                <br>
                <label>Fecha</label>
                <input type="date" id="fecha" name="fecha_FC" class="form-control" value="<?php echo date('Y-m-d') ?>" readonly>
                <br>
                <label>Descripcion del Contrato</label>
                <textarea type="text" name="descripcion_FC" class="form-control" placeholder="Favor ingresar nombre de la ficha" required></textarea>
                <br>
                <label>Area de Gestion</label>
                <br>
                <!--Aca, como hemos realizado antes, se realiza una mini consulta a la base de datos, asi limitamos las opciones de seleccion a las determinadas por el area.-->
                <select name="gestion_FC" class="form-control" required>
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
                <select name="clasi_FC" class="form-control" required>
                    <option selected disabled value="0">Favor clasificar...</option>
                    <?php
                    $query = $conexion1->query("SELECT * FROM clasificador_presupuestario");
                    while ($valores = mysqli_fetch_array($query)) {
                        echo '<option value="' . $valores['id_cla_presupuestario'] . '">' . $valores['nombre_cuenta'] . '</option>';
                    }
                    ?>
                </select>
                <br>
                <label for="contratovigente">Favor, marque la casilla en caso de tener un contrato vigente.</label>
                <br>
                <input type="checkbox" name="contrato_vigente_si_no" value="opcion1" id="opcion1">
                <br>
                <br>
            </div>
            <div class="right-column" style="flex-basis: 40%; margin-left: 10px;">
                <label for="monto">Monto Solicitado:</label>
                <input type="number" id="monto" name="monto_solicitado_FC" step="0.01" class="form-control" required>
                <br>
                <label>Aportes Externos:</label>
                <input type="number" id="aportes" name="aportes_externos_FC" step="0.01" class="form-control" required>
                <hr>
                <label>Total:</label>
                <input type="number" id="total" name="total_FC" readonly>
                <br>
                <br>
                <label>Direccion Municipal</label>
                <select name="di_municipal_FC" class="form-select" required>
                    <option selected disabled value="0">Seleccione direccion perteneciente:...</option>
                    <?php
                    $query = $conexion1->query("SELECT * FROM direccion WHERE id_direccion = $id_direccion ");
                    while ($valores = mysqli_fetch_array($query)) {
                        echo '<option value="' . $valores['id_direccion'] . '">' . $valores['desc_direccion'] . '</option>';
                    }
                    ?>
                </select>
                <br>
                <label>Prioridad</label>
                <br>
                <select name="prioridad_FC" class="form-select" required>
                    <option selected disabled value="0">Prioridad:...</option>
                    <?php
                    $query = $conexion1->query("SELECT * FROM prioridad");
                    while ($valores = mysqli_fetch_array($query)) {
                        echo '<option value="' . $valores['id_prioridad'] . '">' . $valores['prioridades'] . '</option>';
                    }
                    ?>
                </select>
                <br>

            </div>
    </div>
    <hr>
    <div class="table-container">
        <table class="table table-hover table-dark">
            <thead>
                <tr>
                    <th>Detalle</th>
                    <th>Ene</th>
                    <th>Feb</th>
                    <th>Mar</th>
                    <th>Abril</th>
                    <th>Mayo</th>
                    <th>Jun</th>
                    <th>Jul</th>
                    <th>Ago</th>
                    <th>Sept</th>
                    <th>Octu</th>
                    <th>Nov</th>
                    <th>Dic</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Costo Mensual sin Ampliacion</td>
                    <td><input type="number" name="enero_SA" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="febrero_SA" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="marzo_SA" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="abril_SA" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="mayo_SA" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="junio_SA" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="julio_SA" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="agosto_SA" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="sep_SA" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="octu_SA" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="nov_SA" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="dic_SA" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="total_FC_SA" class="form-control" readonly></td>
                </tr>
                <tr>
                    <td>Costo Mensual con Ampliacion</td>
                    <td><input type="number" name="enero_CA" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="febrero_CA" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="marzo_CA" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="abril_CA" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="mayo_CA" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="junio_CA" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="julio_CA" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="agosto_CA" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="sep_CA" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="octu_CA" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="nov_CA" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="dic_CA" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="total_FC_CA" class="form-control" readonly></td>
                </tr>
            </tbody>
        </table>
        <input type="submit" class="btn btn-success" value="Guardar" style="float:right" name="guardar_FC">
        <a href="../../Usuario/crear_ficha.php" class="btn btn-primary">Regresar</a>
        </form>
    </div>
</body>

<!--aca realizamos un scripts para poder revisar los montos que se van agregando-->

<script>
    var monto_solicitado = document.getElementsByName('monto_solicitado_FC')[0];/*Aca creamos las variables asociadas al name del imput */
    var aportes_externos = document.getElementsByName('aportes_externos_FC')[0];
    var total = document.getElementsByName('total_FC')[0];


    monto_solicitado.addEventListener('input', updateTotal);
    aportes_externos.addEventListener('input', updateTotal);

    /* Con esta funcion realizamos el calculo requerido */
    function updateTotal() {
        var monto = parseFloat(monto_solicitado.value) || 0;
        var aportes = parseFloat(aportes_externos.value) || 0;
        total.value = (monto + aportes).toFixed(2);
    }
</script>
<!--Aca es lo mismo, solo que la suma se realiza con los montos mensuales que vamos agregando-->
<script>
    var enero_CA = document.getElementsByName('enero_CA')[0];
    var febrero_CA = document.getElementsByName('febrero_CA')[0];
    var marzo_CA = document.getElementsByName('marzo_CA')[0];
    var abril_CA = document.getElementsByName('abril_CA')[0];
    var mayo_CA = document.getElementsByName('mayo_CA')[0];
    var junio_CA = document.getElementsByName('junio_CA')[0];
    var julio_CA = document.getElementsByName('julio_CA')[0];
    var agosto_CA = document.getElementsByName('agosto_CA')[0];
    var sep_CA = document.getElementsByName('sep_CA')[0];
    var octu_CA = document.getElementsByName('octu_CA')[0];
    var nov_CA = document.getElementsByName('nov_CA')[0];
    var dic_CA = document.getElementsByName('dic_CA')[0];
    var total_FC_CA = document.getElementsByName('total_FC_CA')[0];

    enero_CA.addEventListener('input', updateTotal);
    febrero_CA.addEventListener('input', updateTotal);
    marzo_CA.addEventListener('input', updateTotal);
    abril_CA.addEventListener('input', updateTotal);
    mayo_CA.addEventListener('input', updateTotal);
    junio_CA.addEventListener('input', updateTotal);
    julio_CA.addEventListener('input', updateTotal);
    agosto_CA.addEventListener('input', updateTotal);
    sep_CA.addEventListener('input', updateTotal);
    octu_CA.addEventListener('input', updateTotal);
    nov_CA.addEventListener('input', updateTotal);
    dic_CA.addEventListener('input', updateTotal);
    total_FC_CA.addEventListener('input', updateTotal);

    function updateTotal() {
        var ene = parseFloat(enero_CA.value) || 0;
        var feb = parseFloat(febrero_CA.value) || 0;
        var mar = parseFloat(marzo_CA.value) || 0;
        var abr = parseFloat(abril_CA.value) || 0;
        var may = parseFloat(mayo_CA.value) || 0;
        var jun = parseFloat(junio_CA.value) || 0;
        var jul = parseFloat(julio_CA.value) || 0;
        var ago = parseFloat(agosto_CA.value) || 0;
        var sep = parseFloat(sep_CA.value) || 0;
        var oct = parseFloat(octu_CA.value) || 0;
        var nov = parseFloat(nov_CA.value) || 0;
        var dic = parseFloat(dic_CA.value) || 0;
        total_FC_CA.value = (ene + feb + mar + abr + may + jun + jul + ago + sep + oct + nov + dic).toFixed(2);
    }
</script>

<script>
    var enero_SA = document.getElementsByName('enero_SA')[0];
    var febrero_SA = document.getElementsByName('febrero_SA')[0];
    var marzo_SA = document.getElementsByName('marzo_SA')[0];
    var abril_SA = document.getElementsByName('abril_SA')[0];
    var mayo_SA = document.getElementsByName('mayo_SA')[0];
    var junio_SA = document.getElementsByName('junio_SA')[0];
    var julio_SA = document.getElementsByName('julio_SA')[0];
    var agosto_SA = document.getElementsByName('agosto_SA')[0];
    var sep_SA = document.getElementsByName('sep_SA')[0];
    var octu_SA = document.getElementsByName('octu_SA')[0];
    var nov_SA = document.getElementsByName('nov_SA')[0];
    var dic_SA = document.getElementsByName('dic_SA')[0];
    var total_FC_SA = document.getElementsByName('total_FC_SA')[0];

    enero_SA.addEventListener('input', updateTotal);
    febrero_SA.addEventListener('input', updateTotal);
    marzo_SA.addEventListener('input', updateTotal);
    abril_SA.addEventListener('input', updateTotal);
    mayo_SA.addEventListener('input', updateTotal);
    junio_SA.addEventListener('input', updateTotal);
    julio_SA.addEventListener('input', updateTotal);
    agosto_SA.addEventListener('input', updateTotal);
    sep_SA.addEventListener('input', updateTotal);
    octu_SA.addEventListener('input', updateTotal);
    nov_SA.addEventListener('input', updateTotal);
    dic_SA.addEventListener('input', updateTotal);
    total_FC_SA.addEventListener('input', updateTotal);

    function updateTotal() {
        var ene = parseFloat(enero_SA.value) || 0;
        var feb = parseFloat(febrero_SA.value) || 0;
        var mar = parseFloat(marzo_SA.value) || 0;
        var abr = parseFloat(abril_SA.value) || 0;
        var may = parseFloat(mayo_SA.value) || 0;
        var jun = parseFloat(junio_SA.value) || 0;
        var jul = parseFloat(julio_SA.value) || 0;
        var ago = parseFloat(agosto_SA.value) || 0;
        var sep = parseFloat(sep_SA.value) || 0;
        var oct = parseFloat(octu_SA.value) || 0;
        var nov = parseFloat(nov_SA.value) || 0;
        var dic = parseFloat(dic_SA.value) || 0;
        total_FC_SA.value = (ene + feb + mar + abr + may + jun + jul + ago + sep + oct + nov + dic).toFixed(2);
    }
</script>

</html>