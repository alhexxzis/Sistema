<!--Vista principal del Usuario Administrador-->
<?php
session_start();
if (empty($_SESSION['nombre']) and empty($_SESSION['apellido'])) {
  header('location:../login.php');
}
if (!isset($_SESSION['id_tipo_usuario'])) {
  header('location:../login.php');
} else {
  if ($_SESSION['id_tipo_usuario'] != 1) {
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
    <!--link de conexiones a librerias, como jquery o bootstrap-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
    }
    .header button {
      margin-left: 10px;
    }
    .container {
      margin-left: 10px;
      border: 1px solid black;
      border-radius: 10px;
      background-color: rgba(1, 0, 0, 0.5);
      background-blend-mode: multiply;
      padding: 20px;
    }
    #contenedor_tabla {
      margin-left: 10px;
      border: 1px solid black;
      border-radius: 10px;
      background-color: rgba(255, 0, 0, 0.3);
      background-blend-mode: multiply;
      padding: 20px;
    }

    h3,
    th,
    td {
      color: white;
    }
  </style>
</head>
<tbody>
  <div class="header">
    <h1><?php echo $_SESSION['nombre'] ?></h1>
    <div>
      <a href="../Administrador/inicio_admi.php">Inicio</a>
      <a href="../Administrador/lista_usuarios.php">Lista Usuarios</a>
      <a href="../Administrador/crear_usuarios_admi.php">Crear usuarios</a>
      <a href="../Administrador/vistas_detalle_fichas/detalle_fichas_usuarios_area.php">Revisar Fichas</a>
      <a href="../controladores/usuario_cerrar_session.php"><button type="button" class="btn btn-dark">Cerrar sesión</button></a>
    </div>
  </div>
</tbody>
<br>
  <!--Para poder concentrar la revision de las fichas en una sola pagina (las fichas tienen diferentes tablas donde se guardan los datos)
se creo una table donde, a traves del metodo while, se fueran realizando consultas a las tablas relacionadas a las fichas que queremos mostrar,
por ende, se extrajeron datos que coincidieran en todas las fichas y se creo una table con el detalle.-->
<body>
  <div class="container">
    <h3>Fichas rechazadas por SECPLA</h3>
    <hr>
    <table class="table">
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
        WHERE ficha_gastos_corrientes.estado_ficha_GC = 6"; /* Determina el estado de la ficha que queremos que se muestre, en este caso es 6, ya que esta tabla es para 
        revisar las fichas rechazadas por SECPLA.*/
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
            <td scope="row"><?php echo $resultado['nombre'] ?> <?php echo $resultado['apellido'] ?></td>
            <td scope="row"><?php echo $resultado['prioridades'] ?></td>
            <td><a href="../Administrador/Admi_fichas_rechazadas/ficha_rechazada_GC.php?id_GC=<?php echo $resultado['id_GC'] ?>" class="btn btn-secondary">Revisar</a></td>
          </tr>
        <?php
        }
        ?>
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
        WHERE ficha_contratos.estado_ficha_FC = 6";
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
            <td><a href="../Administrador/Admi_fichas_rechazadas/ficha_rechazada_FC.php?id_FC=<?php echo $resultado1['id_FC'] ?>" class="btn btn-secondary">Revisar</a>
              </form>
          </tr>
        <?php
        }
        ?>
        <?php
        $sql2 = "SELECT ficha_proyectos.id_PY,
        ficha_proyectos.nombre_ficha_PY,
        ficha_proyectos.fecha_PY,
        ficha_proyectos.total_PY,
        ficha_proyectos.usuario_PY,
        ficha_proyectos.prioridad_PY,
        usuario.nombre,
        usuario.apellido,
        tipo_ficha.desc_tipo_ficha,
        direccion.desc_direccion,
        estado_ficha.desc_estado_ficha,
        prioridad.prioridades
        FROM ficha_proyectos
        INNER JOIN direccion ON ficha_proyectos.direccion_PY  = direccion.id_direccion
        INNER JOIN prioridad ON ficha_proyectos.prioridad_PY  = prioridad.id_prioridad
        INNER JOIN tipo_ficha ON ficha_proyectos.tipo_ficha_PY = tipo_ficha.id_tipo_ficha
        INNER JOIN usuario ON ficha_proyectos.usuario_PY = usuario.id
        INNER JOIN estado_ficha ON ficha_proyectos.estado_ficha_PY = estado_ficha.id_estado_ficha
        WHERE ficha_proyectos.estado_ficha_PY = 6";
        $mostrar2 = mysqli_query($conexion1, $sql2);
        while ($resultado2 = mysqli_fetch_array($mostrar2)) {
        ?>
          <tr>
            <td scope="row"><?php echo $resultado2['id_PY'] ?></td>
            <td scope="row"><?php echo $resultado2['nombre_ficha_PY'] ?></td>
            <td scope="row"><?php echo $resultado2['desc_tipo_ficha'] ?></td>
            <td scope="row"><?php echo $resultado2['fecha_PY'] ?></td>
            <td scope="row"><?php echo $resultado2['desc_direccion'] ?></td>
            <td scope="row"><?php echo $resultado2['total_PY'] ?></td>
            <td scope="row"><?php echo $resultado2['nombre'] ?> <?php echo $resultado2['apellido'] ?></td>
            <td scope="row"><?php echo $resultado2['prioridades'] ?></td>
            <td><a href="../Administrador/Admi_fichas_rechazadas/ficha_rechazada_PY.php?id_PY=<?php echo $resultado2['id_PY'] ?>" class="btn btn-secondary">Revisar</a>

          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>

  </div>
</body>

</html>