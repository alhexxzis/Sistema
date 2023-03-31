<!--Vista creada para la modificacion de los datos de los usuarios generados-->
<!--Recepcion de datos por el motodo GET para el id asociado al usuario que se quiere modificar-->
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

include("/xampp/htdocs/Sistema/controladores/conexion.php");
include("/xampp/htdocs/Sistema/controladores/Admi/modificar_user.php");

$id = $_GET["id"];
$sql = "SELECT * FROM usuario INNER JOIN tipo_usuario ON usuario.id_tipo_usuario=tipo_usuario.id_tipo_usuario 
INNER JOIN direccion ON usuario.id_direccion=direccion.id_direccion where id =$id";
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
      font-family: Arial, Helvetica, sans-serif;
    }

    .header a {
      color: white;
      text-decoration: none;
      margin-right: 10px;
      font-size: 20px;
      font-family: Arial, Helvetica, sans-serif;
    }

    .header button {
      margin-left: 10px;
      font-family: Arial, Helvetica, sans-serif;
    }

    .container {

      border-radius: 10px;
      background-color: rgba(1, 0, 0, 0.5);
      background-blend-mode: multiply;
      padding: 20px;
      font-family: Arial, Helvetica, sans-serif;
    }

    #contenedor_tabla {
      margin-left: 10px;
      border: 1px solid black;
      border-radius: 10px;
      background-color: rgba(255, 0, 0, 0.3);
      background-blend-mode: multiply;
      padding: 20px;
      font-family: Arial, Helvetica, sans-serif;
    }

    hr {
      color: white;
    }

    th,
    td {
      color: white;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 18px;
    }

    h3 {
      color: white;
    }

    label {
      color: white;
      font-size: 20px;
      ;
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
<br><br>

<body>
  <h1 class="text-center">Favor completar los campos</h1>
  <br>
  <div class="container">
    <form action="" method="post">
      <!--Se extraen los datos desde la consulta realizada, y se muestran a traves del bucle while.-->
      <?php
      $mostrar = mysqli_query($conexion, $sql);
      while ($resultado = mysqli_fetch_array($mostrar)) {
      ?>
<!--Para las modificaciones de datos, se requiere que solo se modifique el dato que se necesita, por ende, es necesario enviar
a la pagina que procesa (en este caso es la pagina 'modificar_user.php') los datos ya guardados en la tabla asociada.
Esto se puede realizar, ingresando el dato en la opcion value de los imput generados, tal como se ve en las filas mas abajo-->
        <input type="hidden" name="id" class="form-control" placeholder="ID" value="<?php echo $resultado['id'] ?>" required=required>
        <br>
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" class="form-control" placeholder="Nombre" value="<?php echo $resultado['nombre'] ?>" required=required>
        <br>
        <input type="text" name="apellido" class="form-control" placeholder="Apellido" value="<?php echo $resultado['apellido'] ?>" required=required>
        <br>
        <input type="text" name="usuario" class="form-control" placeholder="Usuario" value="<?php echo $resultado['usuario'] ?>" required=required>
        <br>
        <input type="text" style="display: none; " name="correo" class="form-control" placeholder="Email" value="<?php echo $resultado['correo'] ?>" required=required>
        <br>
        <input type="text" name="clave" class="form-control" placeholder="Clave" value="<?php echo $resultado['clave'] ?>" required=required>
        <br>
        <label for="exampleFormControlTextarea1">Tipo de usuario </label><br>
        <select class="form-control" name="tipousu" required=required>
          <option selected disabled value="0">Tipo de usuario:</option>
          <?php
          $query = $conexion->query("SELECT * FROM tipo_usuario");
          while ($valores = mysqli_fetch_array($query)) {/*Mini conexion a la base de datos para la seleccion de tipo de usuario */
            echo '<option value="' . $valores['id_tipo_usuario'] . '">' . $valores['descripcion'] . '</option>';
          }
          ?>
        </select>
        <label for="exampleFormControlTextarea1">Dirección </label><br>
        <select id="element" class="form-control" name="direccion">
          <option selected disabled value="22">Direccion:</option>
          <?php
          $query = $conexion->query("SELECT * FROM direccion");
          while ($valores = mysqli_fetch_array($query)) {
            echo '<option value="' . $valores['id_direccion'] . '">' . $valores['desc_direccion'] . '</option>';
          }

          ?>
        </select>
      <?php
      }
      ?>
      <br><br>
      <div class="btn-admi-update">
        <a href="/Administrador/inicio_admi.php"><input type="submit" name="usupdate" class="btn btn-success" style="float : right;" value="Modificar"></a>
        <a href="../Administrador/lista_usuarios.php" class="btn btn-dark">Regresar</a>
      </div>
    </form>
  </div>
  </tbody>
</html>