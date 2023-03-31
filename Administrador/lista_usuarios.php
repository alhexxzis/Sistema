<!--Vista generada para administrar los usuarios creados-->

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
<br><br>
<!--Como lo realizado con las fichas, para los usuarios se realizado una consulta a la base de datos, esto se realiza con el 
metodo de bucle while para que muestre los datos solicitados.-->
<body>
  <div class="container">
    <h1 style="color:white;" class="text-center">Lista de Usuarios</h1>
    <br>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Id</th>
          <th scope="col">Nombre</th>
          <th scope="col">Apellidos</th>
          <th scope="col">Usuario</th>
          <th scope="col">Tipo</th>
          <th scope="col">Direccion</th>
          <th scope="col">Correo</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        require("/xampp/htdocs/Sistema/controladores/conexion.php");
        $sql = "SELECT usuario.id,
    usuario.usuario,
    usuario.nombre,
    usuario.apellido,
    usuario.id_tipo_usuario,
    usuario.id_direccion,
    usuario.correo,
    tipo_usuario.descripcion,
    direccion.desc_direccion,
    direccion.codigo_direccion
    FROM usuario 
    INNER JOIN tipo_usuario ON usuario.id_tipo_usuario=tipo_usuario.id_tipo_usuario 
    INNER JOIN direccion ON usuario.id_direccion=direccion.id_direccion
    ORDER BY `usuario`.`id` ASC";
        $mostrar = mysqli_query($conexion, $sql);/*Conexion a la base*/
        while ($resultado = mysqli_fetch_array($mostrar)) { /* Metodo while para traer los datos */
        ?>
          <tr>
            <td scope="row"><?php echo $resultado['id'] ?></td>
            <td scope="row"><?php echo $resultado['nombre'] ?></td>
            <td scope="row"><?php echo $resultado['apellido'] ?></td>
            <td scope="row"><?php echo $resultado['usuario'] ?></td>
            <td scope="row"><?php echo $resultado['descripcion'] ?></td>
            <td scope="row"><?php echo $resultado['desc_direccion'] ?></td>
            <td scope="row"><?php echo $resultado['correo'] ?></td>
            <td>
              <!--Como habiamos comentado anteriormente, para poder trabajar solo el usuario que se requiere modificar, es necesario enviar
            a la pagina que procesa algun dato de referencia, en este caso se uso el id asociado.-->
              <a class="btn btn-warning" href="../Administrador/modi_user.php?id=<?php echo $resultado['id'] ?>">Editar</a>
              <!--Para la eliminacion de usuarios se genero un mini form, el cual envia datos con el metodo post, recuerda que los datos enviados
            por el metodo POST se asocian a traves del nombre, por ende, es necesario tener una claridad de los nombres usados para cada dato enviado-->
              <form action="../controladores/Admi/eliminar_user.php" method="post">
                <input type="hidden" value="<?php echo $resultado['id'] ?>" name="txtid" readonly>
            <td>
              <input type="submit" value="Eliminar" id="btnEliminar" onclick="return confirmarEliminar(<?php echo $resultado['id'] ?>)" name="btnEliminar" class="btn btn-danger">
            </td>
            </form>
            </td>
          </tr>
        <?php
        }
        ?>
    </table>
    </tbody>
  </div>
</body>

</html>
<!--El siguiente script se utiliza para confirmar la eliminacion del usuario, asi evitamos eliminaciones por error-->
<!--En el input tipo submit se agrego la variable 'confirmarEliminar' a traves de onclick, lo cual determina que 
la variable solo se aplique al presionar el boton asociado-->
<!--La script realiza la pregunta y, dependiendo de la respuesta, realiza la eliminacion. -->
<script>
  function confirmarEliminar(id) {
    var respuesta = confirm("¿Está seguro de que desea eliminar este registro?");
    if (respuesta == true) {
      return true;
    } else {
      return false;
    }
  }
</script>