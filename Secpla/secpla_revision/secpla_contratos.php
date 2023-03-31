<!--La carperta secpla_revision nos muestra un resumen de las fichas generadas por los diferentes usuarios,
diferenciando por el tipo de ficha, ya sea de contratos, gastos, entre otros.
esta vista esta asociada al resumen de las fichas de contratos.-->
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
    if ($_SESSION['id_tipo_usuario'] != 2) {
        header('location:../login.php');
    }
}
include("/xampp/htdocs/Sistema/controladores/cre_fichas/conexion_fichas.php");
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
    .container{
max-width: 1800px;

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
            <a href="../controladores/usuario_cerrar_session.php">
                <button type="button" class="btn btn-dark">Cerrar sesión</button>
            </a>
        </div>
    </div>
</tbody>
<br>

<body>
    <div class="container">
        <table class="table table table-hover table-dark">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nombre Ficha</th>
                    <th scope="col">Tipo ficha</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Direccion</th>
                    <th scope="col">Monto solicitado</th>
                    <th scope="col">Funcionario</th>
                    <th scope="col">Prioridad</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql1 = "SELECT ficha_contratos.id_FC,
        ficha_contratos.nombre_FC,
        ficha_contratos.fecha_FC,
        ficha_contratos.total_FC,
        ficha_contratos.estado_ficha_FC,
        usuario.nombre,
        usuario.apellido,
        tipo_ficha.desc_tipo_ficha,
        direccion.desc_direccion,
        estado_ficha.desc_estado_ficha,
        prioridad.prioridades
        from ficha_contratos
        INNER JOIN direccion ON ficha_contratos.direccion_mun_FC = direccion.id_direccion
        INNER JOIN prioridad ON ficha_contratos.prioridad_FC = prioridad.id_prioridad
        INNER JOIN tipo_ficha ON ficha_contratos.tipo_ficha_FC = tipo_ficha.id_tipo_ficha
        INNER JOIN usuario ON ficha_contratos.usuario_FC = usuario.id
        INNER JOIN estado_ficha ON ficha_contratos.estado_ficha_FC = estado_ficha.id_estado_ficha
        WHERE ficha_contratos.estado_ficha_FC = 5";
                $mostrar1 = mysqli_query($conexion1, $sql1);
                while ($resultado1 = mysqli_fetch_array($mostrar1)) {
                ?>
                    <tr>
                        <td scope="row"><?php echo $resultado1['id_FC'] ?></td>
                        <td scope="row"><?php echo $resultado1['nombre_FC'] ?></td>
                        <td scope="row"><?php echo $resultado1['desc_tipo_ficha'] ?></td>
                        <td scope="row"><?php echo $resultado1['fecha_FC'] ?></td>
                        <td scope="row"><?php echo $resultado1['desc_direccion'] ?></td>
                        <td scope="row"><?php echo $resultado1['total_FC'] ?></td>
                        <td scope="row"><?php echo $resultado1['nombre'] ?> <?php echo $resultado1['apellido'] ?></td>
                        <td scope="row"><?php echo $resultado1['prioridades'] ?></td>
                        <td><a href="../../Secpla/secpla_fichas/secpla_ficha_FC.php?id_FC=<?php echo $resultado1['id_FC'] ?>" 
                        class="btn btn-secondary">Revisar</a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <a href="../../Secpla/revision_fichas_secpla.php" class="btn btn-dark">Regresar</a>
    </div>
</body>

</html>