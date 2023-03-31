<!--Vista configurada para que Secpla pueda habilitar o no las fichas, asi al usuario solo se muestran las fichas habilitadas.-->
<?php
session_start();
if (empty($_SESSION['nombre']) and empty($_SESSION['apellido'])) {
    header('location:../login.php');
}
if (!isset($_SESSION['id_tipo_usuario'])) {
    header('location:../login.php');
} else {
    if ($_SESSION['id_tipo_usuario'] != 2) {
        header('location:../login.php');
    }
}
/*La configuracion de las fichas se realizo de manera individual, ya que al ser un numero determinado, se puede separar de manera mas facil.*/
include('/xampp/htdocs/Sistema/controladores/cre_fichas/conexion_fichas.php');

/*Consultas a la base de datos por ficha. */
$sql = "SELECT *FROM tipo_ficha WHERE id_tipo_ficha  = 1 ";
$mostrar = mysqli_query($conexion1, $sql);
$fila1 = mysqli_fetch_assoc($mostrar);

$sql = "SELECT *FROM tipo_ficha WHERE id_tipo_ficha  =  2";
$mostrar = mysqli_query($conexion1, $sql);
$fila2 = mysqli_fetch_assoc($mostrar);

$sql = "SELECT *FROM tipo_ficha WHERE id_tipo_ficha  =  3";
$mostrar = mysqli_query($conexion1, $sql);
$fila3 = mysqli_fetch_assoc($mostrar);

$sql = "SELECT *FROM tipo_ficha WHERE id_tipo_ficha  =  4";
$mostrar = mysqli_query($conexion1, $sql);
$fila4 = mysqli_fetch_assoc($mostrar);

$sql = "SELECT *FROM tipo_ficha WHERE id_tipo_ficha  =  5";
$mostrar = mysqli_query($conexion1, $sql);
$fila5 = mysqli_fetch_assoc($mostrar);

$sql = "SELECT *FROM tipo_ficha WHERE id_tipo_ficha  =  6";
$mostrar = mysqli_query($conexion1, $sql);
$fila6 = mysqli_fetch_assoc($mostrar);

$sql = "SELECT *FROM tipo_ficha WHERE id_tipo_ficha  =  7";
$mostrar = mysqli_query($conexion1, $sql);
$fila7 = mysqli_fetch_assoc($mostrar);

$sql = "SELECT *FROM tipo_ficha WHERE id_tipo_ficha  =  8";
$mostrar = mysqli_query($conexion1, $sql);
$fila8 = mysqli_fetch_assoc($mostrar);

$sql = "SELECT *FROM tipo_ficha WHERE id_tipo_ficha  =  9";
$mostrar = mysqli_query($conexion1, $sql);
$fila9 = mysqli_fetch_assoc($mostrar);

$sql = "SELECT *FROM tipo_ficha WHERE id_tipo_ficha  = 11";
$mostrar = mysqli_query($conexion1, $sql);
$fila11 = mysqli_fetch_assoc($mostrar);

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
      background-image: url('../img/1366_2000.webp');
      background-size: cover;
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
      font-size: 20px;
    }

    .header button {
      margin-left: 10px;
      font-size: 20px;
    }
    table {
  border-collapse: collapse;
  margin:  auto;
}

table, th, td {
  border: 1px solid black;
}
h1{
  color: white;
}

th {
  text-align: center;
  padding: 5px;
  font-size: 20px;
}

td{
  text-align: center;
  padding: 5px;
  font-size: 18px;
}
    </style>
</head>
<tbody>
    <div class="header">
        <h1><?php echo $_SESSION['nombre'] ?></h1>
        <div>
            <a href="../Secpla/inicio_secpla.php">Inicio</a>
            <a href="../Secpla/secpla_administrar_fichas.php">Administrar Fichas</a>
            <a href="../Secpla/revision_fichas_secpla.php">Revision Fichas</a>
            <a href="../Secpla/fichas_aceptadas.php">Fichas Aceptadas</a>
            <a href="../Secpla/fichas_rechazadas.php">Fichas Rechazadas</a>
            <a href="../controladores/usuario_cerrar_session.php">
                <button type="button" class="btn btn-dark">Cerrar sesión</button>
            </a>
        </div>
    </div>
</tbody>
<br><br>
<body>
    <div class="container">
        <center>
            <h1>Estado Fichas</h1>
        </center>
        <br>
        <form action="" method="POST">
            <?php include('/xampp/htdocs/Sistema/controladores/controlador_secpla/fichas_HD_secpla.php')?>
            <table class="table table-bordered table-hover table-dark">
                <tr>
                    <th>Ficha</th>
                    <th>Acciones</th>
                </tr>
                <tr>
                    <!--Aca no quisimos enviar la info guardada en la tabla, motivo de que la idea es que cada ves que quiera realizar
                un cambio el usuario, lo realice con todas las fichas, asi evitar errrores.-->
                    <td><?php echo $fila1['desc_tipo_ficha'] ?></td>
                    <td><select name="HD_fichaGC">
                            <option selected disabled value="0">Seleccionar ...</option>
                            <option value="deshabilitado">deshabilitado</option>
                            <option value="habilitado">habilitado</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $fila2['desc_tipo_ficha'] ?></td>
                    <td><select name="HD_fichaCon" required>
                    <option selected disabled value="0">Seleccionar ...</option>
                            <option value="deshabilitado">deshabilitado</option>
                            <option value="habilitado">habilitado</option>
                        </select></td>
                </tr>
                <tr>
                    <td><?php echo $fila3['desc_tipo_ficha'] ?></td>
                    <td><select name="HD_fichaPY" required>
                    <option selected disabled value="0">Seleccionar ...</option>
                            <option value="deshabilitado">deshabilitado</option>
                            <option value="habilitado">habilitado</option>
                        </select></td>
                </tr>
                <tr>
                    <td><?php echo $fila4['desc_tipo_ficha'] ?></td>
                    <td><select name="HD_fichaPS" required>
                    <option selected disabled value="0">Seleccionar ...</option>
                            <option value="deshabilitado">deshabilitado</option>
                            <option value="habilitado">habilitado</option>
                        </select></td>
                </tr>
                <tr>
                    <td><?php echo $fila5['desc_tipo_ficha'] ?></td>
                    <td><select name="HD_fichaAM" required>
                    <option selected disabled value="0">Seleccionar ...</option>
                            <option value="deshabilitado">deshabilitado</option>
                            <option value="habilitado">habilitado</option>
                        </select></td>
                </tr>
                <tr>
                    <td><?php echo $fila6['desc_tipo_ficha'] ?></td>
                    <td><select name="HD_fichaSC" required>
                    <option selected disabled value="0">Seleccionar ...</option>
                            <option value="deshabilitado">deshabilitado</option>
                            <option value="habilitado">habilitado</option>
                        </select></td>
                </tr>
                <tr>
                    <td><?php echo $fila7['desc_tipo_ficha'] ?></td>
                    <td><select name="HD_fichaES" required>
                    <option selected disabled value="0">Seleccionar ...</option>
                            <option value="deshabilitado">deshabilitado</option>
                            <option value="habilitado">habilitado</option>
                        </select></td>
                </tr>
                <tr>
                    <td><?php echo $fila8['desc_tipo_ficha'] ?></td>
                    <td><select name="HD_fichaTR" required>
                    <option selected disabled value="0">Seleccionar ...</option>
                            <option value="deshabilitado">deshabilitado</option>
                            <option value="habilitado">habilitado</option>
                        </select></td>
                </tr>
                <tr>
                    <td><?php echo $fila9['desc_tipo_ficha'] ?></td>
                    <td><select name="HD_fichaPA" required>
                    <option selected disabled value="0">Seleccionar ...</option>
                            <option value="deshabilitado">deshabilitado</option>
                            <option value="habilitado">habilitado</option>
                        </select></td>
                </tr>
                <tr>
                    <td><?php echo $fila11['desc_tipo_ficha'] ?></td>
                    <td><select name="HD_fichaPRE" required="required">
                    <option selected disabled value="0">Seleccionar ...</option>
                            <option value="deshabilitado">deshabilitado</option>
                            <option value="habilitado">habilitado</option>
                        </select></td>
                </tr>
            </table>
            <br>
            <a href="../Secpla/inicio_secpla.php" class="btn btn-dark">Regresar</a>
            <input type="submit" style="float:right" name="guardar_fichasHD" class="btn btn-success" value="Guardar">
        </form>
    </div>
</body>

</html>