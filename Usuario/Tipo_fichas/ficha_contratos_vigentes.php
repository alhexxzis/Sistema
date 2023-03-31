<!--Vista relacionada al llenado de los contratos vigentes, esto esta asociado a las fichas Contratos.-->
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
include('/xampp/htdocs/Sistema/controladores/cre_fichas/registro_ficha_FC.php');
$id_FC_derivado_contrato = $_GET['id_FC'];
/*Recibimos el dato a traves de GET, luego realizamos las consultas a las tablas pertinentes para poder asociar los datos correctamente. */

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
            background-color: rgba(1, 0, 0, 0.8);
            background-blend-mode: multiply;
            padding: 20px;
        }

        .right-column {

            border: 1px solid black;
            border-radius: 10px;
            background-color: rgba(1, 0, 0, 0.8);
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

        #fecha {
            width: 30%;
        }

        #total {
            width: 30%;
        }
    </style>
</head>

<body>
    <center>
        <h1 style="color:white">Ficha Contratos Vigentes (Año Anterior)</h1>
    </center>
    <!--Aca usamos los form para realizar el envio de los datos hacia las vistas que ayudan a procesar los datos, en este caso enviamos
los datos a la vista registro_FC_vigente.-->
<!--Como se comento anteriormente, usamos los div para mantener un mejor orden, pero ya es decision personal que opcion usas, si div o nav o algun otra.-->
<!--a los div se le asocian clases, asi podemos configurar los estilos.-->    
<div class="container" style="width: 100%;">
        <form action="../../controladores/cre_fichas/registro_FC_vigente.php" method="POST" style="display: flex; width: 100%;">
            <div class="left-column" style="flex-basis: 60%; margin-right: 10px;">
            <!--Aca usamos el type 'hidden', ya que aunque tengamos que enviar este dato, no es necesario mostrarlo, ya que no es editable (reandoly se usa para eso)-->
            <!--La class form-control es una configuracion de bootstrap para mejorar la visual de los botones.
        para las fechas no es necesario que dejes la opcion abierta, es mejor que se llene de manera automatica, con el metodo mas abajo realizado en el value.-->    
            <input type="date" id="fecha" name="fecha_FC_vigente" class="form-control" value="<?php echo date('Y-m-d') ?>" readonly>
                <input type="hidden" name="id_FC_derivado" value="<?php echo $id_FC_derivado_contrato ?>">
                <label>Nombre del Contratista</label>
                <input type="text" name="nombre_FC_vigente" class="form-control" placeholder="Favor ingresar nombre de la ficha" required>
                <br>
                <label>Fecha Inicio Contrato</label>
                <input type="date" id="fecha" name="fecha_FC_vigente_ini" class="form-control" required>
                <br>
                <label>Fecha Termino Contrato</label>
                <input type="date" id="fecha" name="fecha_FC_vigente_ter" class="form-control" required>
                <br>
                <label>Total:</label>
                <input type="number" id="total" name="total_FC_vigente" class="form-control" required>
                <br>
                <label>Clausulas de Renovacion</label>
                <textarea type="text" rows="8px" name="clausulas_FC" class="form-control" placeholder="Favor ingresar nombre de la ficha" required></textarea>
                <br>
                <a href="../../Usuario/inicio_usuario.php" class="btn btn-primary">Regresar</a>
            </div>
            <div class="right-column" style="flex-basis: 40%; margin-left: 10px;">
                <br>
                <label>Clausulas y Condiciones de Ampliacion</label>
                <textarea type="text" rows="6px" name="condiciones_FC" class="form-control" placeholder="Favor ingresar nombre de la ficha" required></textarea>
                <br>
                <label>Tipos de reajuste</label>
                <input type="text" name="reajuste_FC" class="form-control" placeholder="Favor ingresar nombre de la ficha" required></input>
                <br><br>
                <label>Justificacion de la Continuidad (solo en caso de continuar el mismo contratista)</label>
                <textarea type="text" rows="6px" name="justificacion_FC" class="form-control" placeholder="Favor ingresar nombre de la ficha" required></textarea>
                <br>
<!--recuerda que para enviar el form, es necesario agregar un input type 'submit', el cual valida cuando se envian los datos (el required es necesario para obligar a llenar el campo)-->
                <input type="submit" class="btn btn-success" value="Guardar" name="guardar_FC_vigente">
            </div>
    </div>
    <div class="table-container">
        <table class="table table-striped table-dark">
            <h3>Detalle Mensual de los costos</h3>
            <thead>
                <tr>
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
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="number" name="enero_vigente" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="febrero_vigente" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="marzo_vigente" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="abril_vigente" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="mayo_vigente" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="junio_vigente" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="julio_vigente" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="agosto_vigente" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="sep_vigente" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="octu_vigente" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="nov_vigente" class="form-control" placeholder="0"></td>
                    <td><input type="number" name="dic_vigente" class="form-control" placeholder="0"></td>
                </tr>
            </tbody>
        </table>
        </form>
    </div>
</body>

</html>