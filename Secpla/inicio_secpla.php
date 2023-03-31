<!--Esta vista fue creada para ser lo primero que secpla vea al entrar, de igual manera todavia no tiene nada configurado.-->
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
      background-image: url('../img/1366_2000.webp');
      background-size: cover;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px;
      background-color: rgba(1, 0, 0, 0.7);
      font-size: 20px;
      color: white;
    }

    .header h1 {
      margin: 0;
      font-size: 30px;
    }

    .header a {
      color: white;
      text-decoration: none;
      margin-right: 10px;
      font-size: 20px;
    }

    .header button {
      margin-left: 10px;
    }
    table {
  border-collapse: collapse;
  margin:  auto;
}


table, th, td {
  border: 1px solid black;
  
}

th, td {
  text-align: center;
  padding: 5px;
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
.botones-menu {
  display: inline-block;
  margin-bottom: 10px;
  border-bottom: 1px solid #ccc;
  padding-bottom: 5px;
}

  </style>
</head>
<tbody>
  <nav class="header">
    <h1><?php echo $_SESSION['nombre'] ?></h1>
    <div>
      <a href="../Secpla/inicio_secpla.php" >Inicio</a>
      <a href="../Secpla/secpla_administrar_fichas.php">Administrar Fichas</a>
      <a href="../Secpla/revision_fichas_secpla.php">Revision Fichas</a>
      <a href="../Secpla/fichas_rechazadas.php">Fichas Rechazadas</a>
      <a href="../Secpla/fichas_aceptadas.php">Fichas Aceptadas</a>
      <a href="../controladores/usuario_cerrar_session.php">
        <button type="button" class="btn btn-dark">Cerrar sesión</button>
      </a>
    </div>
  </nav>
</tbody>
  
<body>
  
</body>

</html>