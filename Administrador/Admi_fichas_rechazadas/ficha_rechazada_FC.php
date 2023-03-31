<!--En esta carpeta (admi_fichas_rechazadas) guardamos las vistas programadas para mostrar el detalle de las fichas que han sido
rechazadas por SECPLA, esto se divide en una pagina por ficha. -->

<!--Conexion realizada para diferenciar los usuarios. En algunos casos el codigo php es mas larga, ya que se determinaron
otras variables para destacar en las consultas mas abajo-->
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
  if ($_SESSION['id_tipo_usuario'] != 1) {
    header('location:../login.php');
  }
}
?>
<!-- Este codigo PHP se usa para recoger la variable enviada por el metodo GET desde la pagina antecesora, y asi podemos validar
solo los datos que se seleccionaron.
Ademas, la variable $sql nos realiza una consulta a la base de datos, logrando extraer los datos que necesitamos.
-->
<?php
include("/xampp/htdocs/Sistema/controladores/cre_fichas/conexion_fichas.php");
$iden_FC = $_GET['id_FC'];

$sql = "SELECT ficha_contratos.id_FC,
ficha_contratos.nombre_FC,
ficha_contratos.fecha_FC,
ficha_contratos.descripcion_contrato_FC,	
ficha_contratos.financiamiento_FC,
ficha_contratos.aportes_externos_FC,
ficha_contratos.enero_FC, ficha_contratos.febrero_FC, ficha_contratos.marzo_FC, ficha_contratos.abril_FC, ficha_contratos.mayo_FC, ficha_contratos.junio_FC,
ficha_contratos.julio_FC, ficha_contratos.agosto_FC, ficha_contratos.septiembre_FC, ficha_contratos.octubre_FC, ficha_contratos.noviembre_FC,
ficha_contratos.diciembre_FC, ficha_contratos.total_FC_detalle_SA,
ficha_contratos.enero_FC_CA, ficha_contratos.febrero_FC_CA, ficha_contratos.marzo_FC_CA, ficha_contratos.abril_FC_CA, 
ficha_contratos.mayo_FC_CA, ficha_contratos.junio_FC_CA, ficha_contratos.julio_FC_CA, ficha_contratos.agosto_FC_CA, 
ficha_contratos.septiembre_FC_CA, ficha_contratos.octubre_FC_CA, ficha_contratos.noviembre_FC_CA,
ficha_contratos.diciembre_FC_CA, ficha_contratos.total_FC_CA,
ficha_contratos.total_FC,
ficha_contratos.estado_ficha_FC,
areas_gestion.desc_area_gestion,
clasificador_presupuestario.nombre_cuenta,
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
INNER JOIN areas_gestion ON ficha_contratos.gestion_FC = areas_gestion.id_area_gestion
INNER JOIN clasificador_presupuestario ON ficha_contratos.clasificador_FC = clasificador_presupuestario.id_cla_presupuestario
WHERE id_FC = $iden_FC";
$mostrar = mysqli_query($conexion1, $sql);
$datos_FC = mysqli_fetch_assoc($mostrar);

$sql = "SELECT * FROM ficha_contratos_vigente WHERE id_FC_derv = $iden_FC";
$mostrar2 = mysqli_query($conexion1, $sql);

$sql = "SELECT * FROM caja_comentarios_secpla WHERE id_ficha_C = $iden_FC AND LENGTH(comentarios_secpla) > 0 LIMIT 1";
$mostrar3 = mysqli_query($conexion1, $sql);
$comentarios = mysqli_fetch_assoc($mostrar3);
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
      background-image: url('../../img/OIP.jfif');
      background-size: cover;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px;
      background-color: #343a40;
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

    table {
      margin: 0 auto;
      max-width: 90%;
      justify-content: space-between;

    }

    .container {
      display: flex;
      justify-content: left;
    }

    .left-column {
      width: 50%;
    }

    .right-column {
      width: 48%;
    }

    .button-container {
      text-align: center;
    }
  </style>
</head>

<body>
  <!--Enlaces a las paginas relacionadas con el perfil-->
  <div class="header">
    <h1><?php echo $_SESSION['nombre'] ?></h1>
    <div>
      <a href="../../Administrador/inicio_admi.php">Inicio</a>
      <a href="../../Administrador/lista_usuarios.php">Lista Usuarios</a>
      <a href="../Administrador/crear_usuarios_admi.php">Crear usuarios</a>
      <a href="../../Administrador/fichas_revisar.php">Revisar Fichas</a>
      <a href="../../controladores/usuario_cerrar_session.php"><button type="button" class="btn btn-dark">Cerrar sesión</button></a>
    </div>
  </div>
  <br>
  <br>
  <body>
    <!--Para ordenar los datos se usan los div, en este caso yo use las clases container, left-column y right-column para dividir en 2 la pagina-->
        <div class="container">
            <div class="left-column">
                <table class="table table-striped table-dark">
                    <tbody>
                        <tr>
                            <td><strong>Nombre Contrato:</strong></td>
                            <td><?php echo $datos_FC['nombre_FC'] ?></td><!-- este metodo se utiliza para hacer una llamado 
                            a la base de datos y mostrar los datos requeridos, echo nos imprime el dato y las variables determinan que
                          dato es.-->
                        </tr>
                        <tr>
                            <td><strong>Tipo Ficha:</strong></td>
                            <td><?php echo $datos_FC['desc_tipo_ficha'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Fecha:</strong></td>
                            <td><?php echo $datos_FC['fecha_FC'] ?></td>
                        </tr>

                        <tr>
                            <td><strong>Direccion:</strong></td>
                            <td><?php echo $datos_FC['desc_direccion'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Descripcion:</strong></td>
                            <td><?php echo $datos_FC['descripcion_contrato_FC'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Financiamiento:</strong></td>
                            <td><?php echo $datos_FC['financiamiento_FC'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Aportes Externos:</strong></td>
                            <td><?php echo $datos_FC['aportes_externos_FC'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Total:</strong></td>
                            <td><?php echo $datos_FC['total_FC'] ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="right-column">
                <table class="table table-striped table-dark">
                    <tr>
                        <td><strong>Usuario:</strong></td>
                        <td><?php echo $datos_FC['nombre'] ?> <?php echo $datos_FC['apellido'] ?></td>
                    </tr>
                    <tr>
                        <td><strong> Estado:</strong></td>
                        <td><?php echo $datos_FC['desc_estado_ficha'] ?></td>
                    </tr>
                    <tr>
                        <td><strong> Area Gestion:</strong></td>
                        <td><?php echo $datos_FC['desc_area_gestion'] ?></td>
                    </tr>
                    <tr>
                        <td><strong> Clasificacion:</strong></td>
                        <td><?php echo $datos_FC['nombre_cuenta'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Prioridad:</strong></td>
                        <td><?php echo $datos_FC['prioridades'] ?></td>
                    </tr>
                    <tr>
                        <td><strong>Contrato Vigente:</strong></td>
                        <td>
                          <!-- En este caso, utilizamos funciones de php para realizar un llamado de los datos del contrato vigente asociado, el cual es ordenado en un
                        modal, para que solo se muestren los datos al momento de apretar el button 'Ver' (boton determinado dentro de los conectores de php).-->
                            <?php
                            if (mysqli_num_rows($mostrar2) == 0) {
                                $mensaje = "Sin contrato vigente";
                                echo "<p>$mensaje</p>";
                            } else {
                                $datos = mysqli_fetch_assoc($mostrar2);

                                $modal_contenido = "<center><h1> Contrato Vigente </h1></center>
                                <br>
                                <p> Fecha:    " . $datos['fecha_FC_vige'] . "</p>
                                <p> Contratista:    " . $datos['nombre_contratista_FC'] . "</p>
                                <p>Fecha Inicio: " . $datos['fecha_inicio_FC_vigente'] . "</p=>
                                <p>Fecha Termino: " . $datos['fecha_term_FC_vigente'] . "</p>
                                <p>Monto contratado: " . $datos['monto_contratado_anter'] . "</pyle=>
                                <hr>
                                <table class='table table striped table-dark'>
                                <thead>
                                <center><h3> Detalle Mensual </h3></center>
                                <tr>
                                <th>Ene</th>
                                <th>Feb</th>
                                <th>Mar</th>
                                <th>Abr</th>
                                <th>May</th>
                                <th>Jun</th>
                                <th>Jul</th>
                                <th>Ago</th>
                                <th>Sep</th>
                                <th>Oct</th>
                                <th>Nov</th>
                                <th>Dic</th>
                                <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                <td>" . $datos['enero_FCV'] . "</td>
                                <td>" . $datos['febrero_FCV'] . "</td>
                                <td>" . $datos['marzo_FCV'] . "</td>
                                <td>" . $datos['abril_FCV'] . "</td>
                                <td>" . $datos['mayo_FCV'] . "</td>
                                <td>" . $datos['junio_FCV'] . "</td>
                                <td>" . $datos['julio_FCV'] . "</td>
                                <td>" . $datos['agosto_FCV'] . "</td>
                                <td>" . $datos['septiembre_FCV'] . "</td>
                                <td>" . $datos['octubre_FCV'] . "</td>
                                <td>" . $datos['noviembre_FCV'] . "</td>
                                <td>" . $datos['diciembre_FCV'] . "</td>
                                <td>" . $datos['total_FCV'] . "</td>
                                </tr>
                                </tbody>
                                </table>
                                ";
                                $mensaje = $modal_contenido;

                                echo "<button class='btn btn-info' id='mostrarModal'>Ver</button>";
                                echo "<div id='myModal' class='modal' style='display:none;'>
        <div class='modal-content' style='width: 90%; max-width: 60%; margin: 5% auto; font-size: 20px; padding: 20px; background-color: rgba(1, 0, 0, 0.95); border-radius: 10px; box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.3);'>
          <span class='close' style='float: right; font-size: 24px; font-weight: bold; cursor: pointer;'>&times;</span>
          $mensaje
        </div>
    </div>";

                                echo "<script>
        var botonModal = document.getElementById('mostrarModal');
        var modal = document.getElementById('myModal');
        var span = modal.getElementsByClassName('close')[0];

        botonModal.onclick = function() {
            modal.style.display = 'block';
        }

        span.onclick = function() {
            modal.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
            <td><strong>Comentarios:</strong></td>
            <td><?php echo $comentarios['comentarios_secpla'] ?></td>
          </tr>
                </table>
            </div>
        </div>
        <table class="table table-striped table-dark">
            <thead>
                <tr>
                    <th>Detalle</th>
                    <th>Ene</th>
                    <th>Feb</th>
                    <th>Mar</th>
                    <th>Abril</th>
                    <th>Mayo</th>
                    <th>Jun</th>
                    <th>Jul</th>
                    <th>Ago</th>
                    <th>Sept</th>
                    <th>Octu</th>
                    <th>Nov</th>
                    <th>Dic</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                    <tr>
                        <td>Costo Sin Ampliacion</td>
                        <td><?php echo $datos_FC['enero_FC'] ?></td>
                        <td><?php echo $datos_FC['febrero_FC'] ?></td>
                        <td><?php echo $datos_FC['marzo_FC'] ?></td>
                        <td><?php echo $datos_FC['abril_FC'] ?></td>
                        <td><?php echo $datos_FC['mayo_FC'] ?></td>
                        <td><?php echo $datos_FC['junio_FC'] ?></td>
                        <td><?php echo $datos_FC['julio_FC'] ?></td>
                        <td><?php echo $datos_FC['agosto_FC'] ?></td>
                        <td><?php echo $datos_FC['septiembre_FC'] ?></td>
                        <td><?php echo $datos_FC['octubre_FC'] ?></td>
                        <td><?php echo $datos_FC['noviembre_FC'] ?></td>
                        <td><?php echo $datos_FC['diciembre_FC'] ?></td>
                        <td><?php echo $datos_FC['total_FC_detalle_SA'] ?></td>
                        </tr>
                        <tr>
                        <td>Costo con Ampliacion</td>
                        <td><?php echo $datos_FC['enero_FC_CA'] ?></td>
                        <td><?php echo $datos_FC['febrero_FC_CA'] ?></td>
                        <td><?php echo $datos_FC['marzo_FC_CA'] ?></td>
                        <td><?php echo $datos_FC['abril_FC_CA'] ?></td>
                        <td><?php echo $datos_FC['mayo_FC_CA'] ?></td>
                        <td><?php echo $datos_FC['junio_FC_CA'] ?></td>
                        <td><?php echo $datos_FC['julio_FC_CA'] ?></td>
                        <td><?php echo $datos_FC['agosto_FC_CA'] ?></td>
                        <td><?php echo $datos_FC['septiembre_FC_CA'] ?></td>
                        <td><?php echo $datos_FC['octubre_FC_CA'] ?></td>
                        <td><?php echo $datos_FC['noviembre_FC_CA'] ?></td>
                        <td><?php echo $datos_FC['diciembre_FC_CA'] ?></td>
                        <td><?php echo $datos_FC['total_FC_CA'] ?></td>
                        </tr>
            </tbody>
        </table>
        <!-- Botones relacionados a las acciones a realizar -->
        <div class="button-container">
            <a href="../../Administrador/inicio_admi.php"><button class="btn btn-dark">Regresar</button></a>

    </body>
</html>