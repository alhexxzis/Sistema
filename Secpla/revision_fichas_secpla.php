<!--Aca configuramos una vista para que SECPLA pueda elegir que fichas revisa. Se encuentra dividido por tipo de ficha.-->
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

include("/xampp/htdocs/Sistema/controladores/cre_fichas/conexion_fichas.php");

?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <title>Presupuesto SECPLA</title>
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

input[type=text], input[type=number] {
  padding: 6px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

input[type=submit] {
  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 10px 20px;
  text-decoration: none;
  margin: 4px 2px;
  cursor: pointer;
}
  </style>
</head>
<tbody>
  <div class="header">
    <h1><?php echo $_SESSION['nombre'] ?></h1>
    <div>
      <a href="../Secpla/inicio_secpla.php" >Inicio</a>
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
<body>
  <div class="table container">
  <table class ="table table-bordered table-hover table-dark">
    <h1 class ="text-center">Tipo de Ficha</h1>
    <br>
  <tr>
    <th>Fichas</th>
    <th>Acciones</th>
  </tr>
    <tr>
      <!--Enlaces a los diferentes tipos de fichas.-->
      <td>Gastos Corrientes</td>
      <td><a href="../Secpla/secpla_revision/secpla_gastos_corrientes.php"><button class ="btn btn-primary">Revisar</button></a></td>
    </tr>
    <tr>
      <td>Contratos</td>
      <td><a href="../Secpla/secpla_revision/secpla_contratos.php"><button class ="btn btn-primary">Revisar</button></a></td>
    </tr>
    <tr>
      <td>Proyectos de Inversion</td>
      <td><a href="../Secpla/secpla_revision/secpla_proyectos.php"><button class ="btn btn-primary">Revisar</button></a></td>
    </tr>
    <tr>
      <td>Programas Sociales</td>
      <td><a href=""><button class ="btn btn-primary">Revisar</button></a></td>
    </tr>
    <tr>
      <td>Actividades Municipales</td>
      <td><a href=""><button class ="btn btn-primary">Revisar</button></a></td>
    </tr>
    <tr>
      <td>Servicios Comunitarios</td>
      <td><a href=""><button class ="btn btn-primary">Revisar</button></a></td>
    </tr>
    <tr>
      <td>Estudios</td>
      <td><a href=""><button class ="btn btn-primary">Revisar</button></a></td>
    </tr>
    <tr>
      <td>Transferencias, Subvenciones o Convenios</td>
      <td><a href=""><button class ="btn btn-primary">Revisar</button></a></td>
    </tr>
    <tr>
      <td>Programas Asistenciales</td>
      <td><a href=""><button class ="btn btn-primary">Revisar</button></a></td>
    </tr>
    <tr>
      <td>Presupuesto</td>
      <td><a href=""><button class ="btn btn-primary">Revisar</button></a></td>
    </tr>
    </table>
    <a href="../Administrador/inicio_admi.php" class="btn btn-success">Regresar</a>
    </div>
</body>

</html>