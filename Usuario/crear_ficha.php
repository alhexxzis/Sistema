<!--Aca tenemos la vista para poder realizar la derivacion a la ficha que queremos crear.-->
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
require("/xampp/htdocs/Sistema/controladores/conexion.php");
$sql = $conexion->query("SELECT * FROM tipo_ficha where estado = 'habilitado'");
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
      background-color: rgba(1, 0, 0, 0.5);
      background-blend-mode: multiply;
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

    input[type=text],
    input[type=number] {
      padding: 6px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    table {
  border-collapse: collapse;
  margin-left: 20px;
  text-align: center;
  box-shadow: 0px 0px 2px #c2c2c2;
}
    th,
    td {
      padding: 5px;
      color: white;
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
      <a href="../Usuario/inicio_usuario.php">Inicio</a>
      <a href="../Usuario/crear_ficha.php">Crear Ficha</a>
      <a href="../controladores/usuario_cerrar_session.php">
        <button type="button" class="btn btn-dark">Cerrar sesión</button>
      </a>
    </div>
  </div>
</tbody>
<br>
<body>
  <div class='container' >
    <h1 style="text-align: center; font-size: 50px; color:white">Fichas disponibles</h1>
    <br>
    <table class="table table-bordered table-hover table-dark table-responsive">
      <thead>
        <tr>
          <th scope="col" style="font-size: 20px; font-weight: bold;">Nombre</th>
          <th scope="col" style="font-size: 20px; font-weight: bold;">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <!--Aca la derivacion la podemos realizar con el metodo while, ya que en la base de datos guardamos una columna con el nombre que le iremos
      dando a las primeras vistas de las fichas.-->
        <?php
        while ($datos = $sql->fetch_object()) { ?>
          <tr>
            <td style="color:white; font-size:18px;"><?= $datos->desc_tipo_ficha ?></td> <!--Aca llamamos la variable $datos, que esta definida en la parte superior y el nombre de la columna a asociar.-->
            <td><a href="Tipo_fichas/<?= $datos->codigo_tipo_ficha ?>.php" type="button" class="btn btn-primary" style="font-size: 16px;">Crear</a></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <center><a href="../Usuario/inicio_usuario.php"" class="btn btn-light">Regresar</a></center>
  </div>
</body>


</html>