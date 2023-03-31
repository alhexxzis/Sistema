<!--vista esta asociada al resumen de las fichas Gastos Corrientes.-->
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
      <a href="../../Secpla/inicio_secpla.php" >Inicio</a>
      <a href="../../Secpla/secpla_administrar_fichas.php">Administrar Fichas</a>
      <a href="../../Secpla/revision_fichas_secpla.php">Revision Fichas</a>
      <a href="../../controladores/usuario_cerrar_session.php">
        <button type="button" class="btn btn-dark">Cerrar sesión</button>
      </a>
    </div>
  </div>
</tbody>
<br>
<body>
  <div class="container">
    <h1 class="text-center">Gastos Corrientes</h1>
    <br>
    <table class="table table-bordered table-hover table-dark">
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
        $sql = " SELECT  ficha_gastos_corrientes.id_GC,
        ficha_gastos_corrientes.nombre_GC,
        ficha_gastos_corrientes.fecha_GC,
        ficha_gastos_corrientes.financiamiento_sol_GC,
        ficha_gastos_corrientes.estado_ficha_GC,
        usuario.nombre,
        usuario.apellido,
        tipo_ficha.desc_tipo_ficha,
        direccion.desc_direccion,
        prioridad.prioridades
        from ficha_gastos_corrientes
        INNER JOIN direccion ON ficha_gastos_corrientes.direccion_mun_GC = direccion.id_direccion
        INNER JOIN prioridad ON ficha_gastos_corrientes.prioridad_GC = prioridad.id_prioridad
        INNER JOIN tipo_ficha ON ficha_gastos_corrientes.tipo_ficha_GC = tipo_ficha.id_tipo_ficha
        INNER JOIN usuario ON ficha_gastos_corrientes.GC_usuario = usuario.id
        WHERE ficha_gastos_corrientes.estado_ficha_GC = 5";
        $mostrar = mysqli_query($conexion1, $sql);
        while ($resultado = mysqli_fetch_array($mostrar)) {
        ?>
          <tr>
            <td scope="row"><?php echo $resultado['id_GC'] ?></td>
            <td scope="row"><?php echo $resultado['nombre_GC'] ?></td>
            <td scope="row"><?php echo $resultado['desc_tipo_ficha'] ?></td>
            <td scope="row"><?php echo $resultado['fecha_GC'] ?></td>
            <td scope="row"><?php echo $resultado['desc_direccion'] ?></td>
            <td scope="row"><?php echo $resultado['financiamiento_sol_GC'] ?></td>
            <td scope="row"><?php echo $resultado['nombre'] ?>  <?php echo $resultado['apellido'] ?></td>
            <td scope="row"><?php echo $resultado['prioridades'] ?></td>
            <td><a href="../../Secpla/secpla_fichas/secpla_ficha_GC.php?id_GC=<?php echo $resultado['id_GC'] ?>" 
            class="btn btn-secondary">Detalle</a></td>
            </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>
<br>
<br>
<a href="../../Secpla/revision_fichas_secpla.php" class="btn btn-dark">Regresar</a>
</body>
</html>