<!--Vista configurada para poder revisar el detalle de las fichas que se encuentran aceptadas.-->
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
header('Content-Type: text/html; charset=utf-8');
include("/xampp/htdocs/Sistema/controladores/cre_fichas/conexion_fichas.php");

$sql = "SELECT fichas_general_secpla.id_ficha_secpla,fichas_general_secpla.id_fichas, fichas_general_secpla.nombre_secpla,
fichas_general_secpla.fecha,
fichas_general_secpla.monto_solicitado_secpla,
fichas_general_secpla.area_gestion_secpla,
fichas_general_secpla.clasificador_secpla,
areas_gestion.desc_area_gestion,
clasificador_presupuestario.nombre_cuenta,
clasificador_presupuestario.clasificacion_presu,
usuario.nombre,
usuario.apellido,
tipo_ficha.desc_tipo_ficha,
direccion.desc_direccion,
prioridad.prioridades,
estado_ficha.desc_estado_ficha
FROM fichas_general_secpla
INNER JOIN direccion ON fichas_general_secpla.direccion_secpla = direccion.id_direccion
INNER JOIN prioridad ON fichas_general_secpla.prioridad_secpla = prioridad.id_prioridad
INNER JOIN tipo_ficha ON fichas_general_secpla.tipo_ficha_secpla = tipo_ficha.id_tipo_ficha
INNER JOIN usuario ON fichas_general_secpla.funcionario_usuario = usuario.id
INNER JOIN estado_ficha ON fichas_general_secpla.estado_secpla =  estado_ficha.id_estado_ficha
INNER JOIN areas_gestion ON fichas_general_secpla.area_gestion_secpla = areas_gestion.id_area_gestion
INNER JOIN clasificador_presupuestario ON fichas_general_secpla.clasificador_secpla = clasificador_presupuestario.id_cla_presupuestario
WHERE fichas_general_secpla.estado_secpla = 7 ";/*Aca destacamos el estado en 7, ya que, ese es el estado que determinamos para las fichas aprobadas. */
$mostrar = mysqli_query($conexion1, $sql);
?>
<!doctype html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<head>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
  <!--Una de las solicitudes que se realizaron para la creacion de la pagina, es poder exportar a excel el detalle que nosotros determinamos.
Para la realizacion de esto, se genero un scripts en javascripts como funcion llamada 'exportTableToExcel', te dejo en detalle mas explicacion en la parte de abajo.-->
  <script>
    function printTable() {
      window.print();
    }

    function exportTableToExcel(tableID, filename = '') {
      var downloadLink;
      var dataType = 'application/vnd.ms-excel';
      var tableSelect = document.getElementById(tableID);
      var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
      filename = filename ? filename + '.xls' : 'excel_data.xls';
      downloadLink = document.createElement("a");
      document.body.appendChild(downloadLink);
      if (navigator.msSaveOrOpenBlob) {
        var blob = new Blob(['\ufeff', tableHTML], {
          type: dataType
        });
        navigator.msSaveOrOpenBlob(blob, filename);
      } else {
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
        downloadLink.download = filename;
        downloadLink.click();
      }
    }
  </script>
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

    .container {
      max-width: 1900px;
    }


    table {
      border-collapse: collapse;
      border: 1px solid black;
      font-family: Arial, Helvetica, sans-serif;
    }

    th {
      text-align: center;
      padding: 5px;
      border: 1px solid black;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 16px;
    }

    td {
      padding: 5px;
      border: 1px solid black;
      font-family: Arial;
      font-size: 14px;
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
      <a href="../Secpla/fichas_rechazadas.php">Fichas Rechazadas</a>
      <a href="../controladores/usuario_cerrar_session.php">
        <button type="button" class="btn btn-dark">Cerrar sesión</button>
      </a>
    </div>
  </div>
</tbody>

<body>
  <br>
  <div class="container">
    <table id="tabla" class="table table-bordered table-hover table-dark">
      <button class="btn btn-success" style="float:right" onclick="exportTableToExcel('tabla')">Exportar a Excel</button><!--Aca llamamos la funcion con el metodo onclick
    recuerda que tiene que ir asociado siempre con el id escrito en la tabla que se requiere imprimir.-->
      <input type="text" id="search" placeholder="Buscar">
      <thead>
        <br><br>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Nombre Ficha</th>
          <th scope="col">Tipo ficha</th>
          <th scope="col">Fecha</th>
          <th scope="col">Direccion</th>
          <th scope="col">Monto</th>
          <th scope="col">Area Gestion</th>
          <th scope="col">Clasificacion</th>
          <th scope="col">Codigo</th>
          <th scope="col">Funcionario</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($secpla_detalle = mysqli_fetch_array($mostrar)) {
        ?>
          <tr>
            <td><?php echo $secpla_detalle['id_fichas'] ?></td>
            <td><?php echo $secpla_detalle['nombre_secpla'] ?></td>
            <td><?php echo $secpla_detalle['desc_tipo_ficha'] ?></td>
            <td><?php echo $secpla_detalle['fecha'] ?></td>
            <td><?php echo $secpla_detalle['desc_direccion'] ?></td>
            <td><?php echo $secpla_detalle['monto_solicitado_secpla'] ?></td>
            <td><?php echo $secpla_detalle['desc_area_gestion'] ?></td>
            <td><?php echo $secpla_detalle['nombre_cuenta'] ?></td>
            <td><?php echo $secpla_detalle['clasificacion_presu'] ?></td>
            <td><?php echo $secpla_detalle['nombre'] ?> <?php echo $secpla_detalle['apellido'] ?></td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
    <a href="../Secpla/inicio_secpla.php"><button class="btn btn-primary">Regresar</button></a>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!--el script mas abajo fue una prueba que realice para agregar un buscador a las tablas, funciona, pero la verdad es mejor datatable, ya que realiza mas funciones con menos codigo
de igual manera deje el codigo por si te interesa realizarlo de esta manera.-->
  <script>
    $(document).ready(function() {
      // Agregar el botón de búsqueda

      // Agregar la opción de ordenar las filas
      $('thead th').each(function(column) {
        $(this).addClass('sortable').click(function() {
          var sort_dir = $(this).hasClass('asc') ? 'desc' : 'asc';
          $('table').find('tbody > tr').sort(function(a, b) {
            var td_value_a = $(a).find('td').eq(column).text().toUpperCase();
            var td_value_b = $(b).find('td').eq(column).text().toUpperCase();
            if ($.isNumeric(td_value_a) && $.isNumeric(td_value_b)) {
              return td_value_a - td_value_b;
            } else {
              return td_value_a.localeCompare(td_value_b);
            }
          }).appendTo('table tbody');
          $('thead th').removeClass('asc desc');
          $(this).addClass(sort_dir);
        });
      });

      // Agregar la funcionalidad de búsqueda
      $('#search').keyup(function() {
        var value = $(this).val().toUpperCase();
        $('table').find('tbody > tr').each(function(index) {
          var row_text = $(this).text().toUpperCase();
          if (row_text.indexOf(value) != -1) {
            $(this).show();
          } else {
            $(this).hide();
          }
        });
      });
    });
  </script>
</body>

</html>

<!--Esta es una función en JavaScript que se utiliza para exportar una tabla HTML a un archivo de Excel. Esta función toma dos parámetros:

tableID: Es el identificador de la tabla HTML que se desea exportar.
filename: Es el nombre del archivo de Excel que se desea generar. Si no se especifica, se utilizará el valor predeterminado "excel_data.xls".
La función comienza creando una variable downloadLink, que se utiliza para crear un enlace de descarga para el archivo de Excel. A continuación, se especifica 
el tipo de datos como "application/vnd.ms-excel", que es el formato de archivo de Excel.
Luego, se obtiene el contenido HTML de la tabla especificada mediante el identificador tableID y se almacena en una variable llamada tableHTML. 
Se utiliza una expresión regular para reemplazar todos los espacios en blanco en el contenido HTML con %20, que es el código de porcentaje para un 
espacio en blanco en una URL.
Después, se crea un enlace de descarga con el objeto downloadLink. Si el navegador es Internet Explorer, s
e crea un objeto Blob que contiene el contenido de la tabla HTML y se utiliza el método navigator.msSaveOrOpenBlob para descargar el archivo. 
Si el navegador es otro, se utiliza el método downloadLink.href para establecer la URL del archivo y el método downloadLink.click() para iniciar la descarga.

En resumen, esta función es útil para exportar una tabla HTML a un archivo de Excel y puede ser utilizada en aplicaciones web que
 requieren la generación de informes o documentos en formato de hoja de cálculo.-->