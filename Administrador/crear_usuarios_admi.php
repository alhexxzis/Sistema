<!--Ficha generada para el proceso de creacion de usuarios-->

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
  if ($_SESSION['id_tipo_usuario'] != 1) {
    header('location:../login.php');
  }
}
?>
<?php
include("/xampp/htdocs/Sistema/controladores/conexion.php");
include("/xampp/htdocs/Sistema/controladores/Admi/registrar_user.php");
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
      background-color: rgba(1, 0, 0, 0.3);
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

      border: 1px solid black;
      border-radius: 10px;
      background-color: rgba(1, 0, 0, 0.5);
      background-blend-mode: multiply;
      padding: 20px;
    }

    h3,
    th,
    td,
    h1 {
      color: white;
    }

    label {
      color: white;
      font-size: 20px;
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
<!--Detalles de ingreso, aca utilizamos el FORM para el envio de datos, pero no el action, ya que en la pagina de recepciona los datos,
agregamos un condicial, donde realiza la extraccion de los datos a traves del metodo POST, pero con la condicion de que el input type submit haya sido presionado.
Para poder realizar esto, tenemos que incluir en nuestra pagina, la pagina que usaremos para procesar los datos, en este caso, la pagina "registrar_user.php"-->

<body>
  <center>
    <h1>Crear Usuario</h1>
  </center>
  <div class="container">
    <form action="" method="POST">
      <label for="exampleFormControlTextarea1">Nombre </label>
      <input type="text" name="name" id="name" tabindex="1" class="form-control" minlength="3" maxlength="15" placeholder="Nombre" required=required>
      <br>
      <label for="exampleFormControlTextarea1">Apellido </label>
      <input type="text" name="apellido" id="apellido" tabindex="1" class="form-control" minlength="3" maxlength="15" placeholder="Apellido" value="" required=required>
      <br>
      <label for="exampleFormControlTextarea1">Nombre de usuario </label>
      <input type="text" name="username" id="username" tabindex="1" class="form-control" minlength="5" maxlength="15" placeholder="Usuario" value="" required=required>
      <br>
      <label for="exampleFormControlTextarea1">Correo</label>
      <input type="email" name="email" id="email" tabindex="1" class="form-control" minlength="5" maxlength="30" placeholder="Correo" value="" required=required>
      <br>
      <label for="exampleFormControlTextarea1">Contraseña</label>
      <input type="password" name="clave" id="clave" tabindex="1" class="form-control" minlength="5" maxlength="15" placeholder="Contraseña" value="" required=required>
      <br>

      <!-- Existen datos del usuario que tienen que ser determinados por el detalle que se encuentra en otras tablas, 
      por ejemplo, la direccion del usuario esta determinada por las direcciones entregadas por secpla, por ende, 
      solo puede ser seleccionado un dato ya prestablecido, por este motivo, para este tipo de datos se hace una mini consulta 
      a la base de datos para que de las opciones a seleccionar.
      Esta consulta es realiza mediante php, la cual trae el id asociado  y el detalle del dato, el motivo de esto es que las Fichas
      fueron configuradas para que lo que se ingrese en ellas sea el ID asociado, no el nombre en general.-->

      <label for="exampleFormControlTextarea1">Tipo de usuario </label>
      <select id="show" class="form-select" name="tipousu" style="width:20%;" required=required>
        <option selected disabled value="0">Seleccione tipo de usuario:</option>
        <?php
        $query = $conexion->query("SELECT * FROM tipo_usuario");
        while ($valores = mysqli_fetch_array($query)) {
          echo '<option value="' . $valores['id_tipo_usuario'] . '">' . $valores['descripcion'] . '</option>';
        }
        ?>
      </select>
      <br>
      <label for="exampleFormControlTextarea1">Dirección </label><br>
      <select id="element" class="form-select" style="width:20%;" name="direccion">
        <option selected disabled value="22">Seleccione la direccion a la que pertenece:</option>
        <?php
        $query = $conexion->query("SELECT * FROM direccion");
        while ($valores = mysqli_fetch_array($query)) {
          echo '<option value="' . $valores['id_direccion'] . '">' . $valores['desc_direccion'] . '</option>';
        }
        ?>
      </select>
      <br>
      <a href="../Administrador/inicio_admi.php" class="btn btn-dark">Regresar</a>
      <a> <input type="submit" name="adminusu" style="float:right" tabindex="4" class="btn btn-success" value=" Registrar"></a>
  </div>
  </form>
</body>
</html>