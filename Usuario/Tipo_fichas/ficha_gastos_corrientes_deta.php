<!--Vista creada para el ingreso del detalle de los articulos a comprar en la ficha Gastos Corrientes.-->
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
include("/xampp/htdocs/Sistema/controladores/cre_fichas/conexion_fichas.php");
$iddet = $_GET['id_GC'];
include('/xampp/htdocs/Sistema/controladores/cre_fichas/registro_FGC_detalle.php');

$sql = "SELECT * FROM ficha_gastos_corrientes where id_GC = $iddet";
$mostrar = mysqli_query($conexion1, $sql);
$fila = mysqli_fetch_assoc($mostrar);

/*aca determinamos algo super importante para realizar el proceso, algo que se comento en la vista que controla el ingreso,
para realizar el ingreso de los montos mensuales de todos los articulos de manera conjunta, lo realizamos a traves del metodo foreach con arrays de los datos,
datos que tienen que ser determinados de manera correcta, sino, esto no realiza todo correctamente.*/
$sql = "SELECT * FROM ficha_gastos_detalle WHERE id_fichas_GC = $iddet ";
$mostrar1 = mysqli_query($conexion1, $sql);
$GC_id_ficha_det = array(); /*Aca determinamos la variable arrays que ira guardando los datos. */
$suma_total = 0; /*aca inicializamos la variable suma en 0, asi podemos ir agregando las valores ingresados. */
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
      font-family: Arial, Helvetica, sans-serif;
      font-size: 18px;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px;
      background-color: rgba(1, 0, 0, 0.4);
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
      width: 100%;

    }

    .table-container {
      margin: 20px;
      font-size: 18px;
    }

    th {
      font-size: 18px;
    }

    .table.table-dark {

      border-radius: 10px;
    }

    h3 {
      border: 1px solid black;
      padding: 10px;
      border-radius: 10px;
      background-color: black;
    }
    h2{
      margin-left: 20px;
      
    }
  </style>
</head>
<tbody>
  <div class="header">
    <h1><?php echo $_SESSION['nombre'] ?></h1>
    <div>
      <a href="../../Usuario/inicio_usuario.php">Inicio</a>
      <a href="../../controladores/usuario_cerrar_session.php">
        <button type="button" class="btn btn-dark">Cerrar sesión</button>
      </a>
    </div>
  </div>
</tbody>
<br>

<body>
  <center><h1 style="color:white;">FICHA GASTOS CORRIENTES (ARTICULOS A COMPRAR).</h1></center>
  <h2 style="color:white;">DETALLE</h2>
  <tr>
    <td colspan="18">
      <hr>
    </td>
  </tr>
  <h3 style="float:right ; margin-right:20px ; color: white;">Solicitado: $ <?php echo $fila['financiamiento_sol_GC'] ?></h3>
  <div class="container" id="tabla_articulos">
    <!--Aca realizamos el ingreso de la primera parte del detalle, con el nombre, la cantidad y el valor unitario. Con esto, podemos realizar validaciones en el ingreso del detalle anual-->
    <form action="" method="post">
      <table class="table table-bordered table-hover table-dark table-responsive">
        <tr>
          <th>Bien o servicio a adquirir</th>
          <th>Cantidad</th>
          <th>Valor Unitario</th>
          <th>Accion</th>
        <tr>
          <input type="hidden" name="total" readonly>
          <input type="hidden" name="id_GC_derivado" value="<?php echo $fila['id_GC'] ?>">
          <input type="hidden" name="id_GC_monto_derivado" value="<?php echo $fila['financiamiento_sol_GC'] ?>">
          <td><input type="text" class="form-control" name="gc_articulo" required></td>
          <td> <input type="number" class="form-control" name="gc_cantidad" required></td>
          <td><input type="number" class="form-control" name="gc_precio_unitario" required></td>
          <td><input type="submit" class="btn btn-primary" value="Agregar" name="submit"></td>
        </tr>
      </table>
    </form>
    <br>
  </div>
  <div class="table-container">
    <form action="" method="post">
      <table class="table table-bordered table-hover table-dark">
        <tr>
          <th scope="col">Articulo</th>
          <th scope="col">Cantidad</th>
          <th scope="col">P.Unitario</th>
          <th scope="col">Total</th>
          <th scope="col">Ene</th>
          <th scope="col">Feb</th>
          <th scope="col">Marz</th>
          <th scope="col">Abril</th>
          <th scope="col">Mayo </th>
          <th scope="col">Junio</th>
          <th scope="col">Julio</th>
          <th scope="col">Agosto</th>
          <th scope="col">Sep</th>
          <th scope="col">Octub</th>
          <th scope="col">Nov</th>
          <th scope="col">Dic</th>
          <th scope="col">Compra</th>
          <th scope="col"></th>
        </tr>
        <?php
        while ($detalle_arti = mysqli_fetch_array($mostrar1)) { /*Aca con el metodo while, traemos los datos de la tabla. */
          $GC_id_ficha_det[] = $detalle_arti['id_detalle_GC']; /*De esta forma vamos guardando los datos ingresados en la variable $GC_id_ficha_det, colocar [] al final
          es de suma importancia para los datos que se van guardando en el arrays, ya que eso determina que datos van o no.*/
          $suma_total += $detalle_arti['total_gasto_GC']; /*De esta forma se realiza el guardado de los montos en la variable $suma_total. */
        ?>
          <tr>
            <!--Como se puede apreciar en los name, todos los datos que se tienen que guardar en el arrays como una lista, tienen que ser determinados por [], ya que, al momento
          de enviar los datos a la vista procesadora, esta sabra que variables son o no diferentes y a que id van asociada.-->
            <td><?php echo $detalle_arti['descripcion_producto_GC'] ?></td>
            <td><?php echo $detalle_arti['unidades_GC'] ?></td>
            <td><?php echo $detalle_arti['valor_GC'] ?></td>
            <td><?php echo $detalle_arti['total_gasto_GC'] ?></td>
            <input type="hidden" class="form-control" name="GC_id_ficha_det[]" value="<?php echo $detalle_arti['id_detalle_GC'] ?>">
            <input type="hidden" class="form-control" name="GC_id_ficha_deriv" value="<?php echo $detalle_arti['id_fichas_GC'] ?>">
            <input type="hidden" class="form-control" name="GC_monto_requerido" value="<?php echo $fila['financiamiento_sol_GC'] ?>">
            <th><input type="text" class="form-control" name="GC_Enero[]" placeholder="0"></th>
            <th><input type="text" class="form-control" name="GC_Febrero[]" placeholder="0"></th>
            <th><input type="text" class="form-control" name="GC_Marzo[]" placeholder="0"></th>
            <th><input type="text" class="form-control" name="GC_Abril[]" placeholder="0"></th>
            <th><input type="text" class="form-control" name="GC_Mayo[]" placeholder="0"></th>
            <th><input type="text" class="form-control" name="GC_Junio[]" placeholder="0"></th>
            <th><input type="text" class="form-control" name="GC_Julio[]" placeholder="0"></th>
            <th><input type="text" class="form-control" name="GC_Agosto[]" placeholder="0"></th>
            <th><input type="text" class="form-control" name="GC_Septiembre[]" placeholder="0"></th>
            <th><input type="text" class="form-control" name="GC_Octubre[]" placeholder="0"></th>
            <th><input type="text" class="form-control" name="GC_Noviembre[]" placeholder="0"></th>
            <th><input type="text" class="form-control" name="GC_Diciembre[]" placeholder="0"></th>
            <th><?php echo $detalle_arti['total_gasto_GC'] ?></th>
            <!--Aca agregamos una opcion para eliminar el detalle agregado en caso de cometer algun error, esto se realiza enviando el dato con el metodo GET, o sea, en la URL.
          el & visto entre los echo es para poder enviar mas de un dato en caso de ser necesario.-->
            <th><a href="../../controladores/cre_fichas/eliminar_fGC_detalle.php?id_detalle_GC=<?php echo $detalle_arti['id_detalle_GC'] ?>& id_fichas_GC=<?php echo $detalle_arti['id_fichas_GC'] ?>">
            <button type="button" class="btn btn-danger">Eliminar</button></a>
          </tr>
        <?php
        }
        ?>
        <th>Total:</th>
        <th colspan="15"></th>
        <th><?php echo $suma_total; ?></th>
        <th></th>
        </tr>
      </table>
      <th></th>
      <br>
      <!--Aca tenemos el input para el envio, el a para referencia no tiene ninguna utilidad, solo esta probando algun metodo diferente de enviar los datos.
    De igual manera, se genera un a de referencia para realizar la accion de poder volver a llenar la primera parte de la ficha.-->
      <th><a href="" style="float:right"><input type="submit" name="registro_FGC_anual" class="btn btn-success" value="Enviar"></a>
        <a href="../../controladores/cre_fichas/volver_fichas.php?id_GC=<?php echo $iddet ?>"><button type="button" class="btn btn-light">Regresar, Ficha Gastos Corrientes 1º Parte</button></a>
        <br><br>
        <a href="../../Usuario/inicio_usuario.php" class="btn btn-primary">Inicio</a>
      </th>
    </form>
</body>
</div>
</html>