<!--Vista generada como controlador para el ingreso del detalle de los articulos a comprar en la ficha Gastos Corrientes-->
<?php
///Conexion base de datos
include("/xampp/htdocs/Sistema/controladores/cre_fichas/conexion_fichas.php");

/*Sistema para el llenado de la primera parte del detalle,  Fichas Gastos Corrientes*/
if (isset($_POST['submit'])) {
    $idGCD = $_POST['id_GC_derivado'];
    $monto_solicitado_GC = $_POST['id_GC_monto_derivado'];
    $articulo = $_POST['gc_articulo'];
    $cantidad = floatval($_POST['gc_cantidad']); /*Usamos floatval para poder recibir en detalle los numeros enviados, incluyendo si estos tienen decimales */
    $precio_unitario = floatval($_POST['gc_precio_unitario']);
    $total = $cantidad * $precio_unitario;
    $monto_superado = false;

    if (!$conexion1) {/*Prueba de conexion a la base de datos */
        die("Conexión fallida: " . mysqli_connect_error());
    }

    /*Como se puede apreciar en esta QRY, aca  extrajimos el total de la suma de los valores ingresados en la tabla total_gasto_GC,
    el motivo de esto, es poder lograr una de las validaciones solicitadas, lo cual era restringir el ingreso de los articulos al momento de que la suma de sus valores
    fuera mayor al monto solicitado en la primera parte de la ficha (el dato fue enviado en la variable $monto_solicitado_GC) */
    $query = "SELECT SUM(total_gasto_GC) AS total FROM ficha_gastos_detalle WHERE id_fichas_GC = $idGCD";
    $result = mysqli_query($conexion1, $query);
    $row = mysqli_fetch_assoc($result);
    $total_gasto_GC = $row['total'];

    /*Condicion if para la validacion, aca se suma la variable $total + $total_gasto_GC, ya que, total_gasto_GC va sumando los valores de la columna total_gasto_GC,
    pero la validacion tiene que ser incluyendo los datos que se estan ingresando, para esto, la variable $total multiplica los montos que se estan ingresando y esta se 
    agrega a la validacion para dar con el dato. */
    if ($total + $total_gasto_GC > $monto_solicitado_GC) {/*Aca simplemente se dice que si las sumas son mayores a la variable, arroje el mensaje almacenado en $monto_superado. */
        $monto_superado = true;
    } else {/*Aca realizamos el ingreso de los datos si es que cumplen con la condicion. */
        $sql = "INSERT INTO ficha_gastos_detalle (id_detalle_GC,id_fichas_GC,descripcion_producto_GC, unidades_GC, valor_GC, total_gasto_GC,
        enero_GC,febrero_GC,marzo_GC,abril_GC,mayo_GC,junio_GC,julio_GC,agosto_GC,septiembre_GC,octubre_GC,
        noviembre_GC,diciembre_GC,total_mensual_GC)
                VALUES ('',$idGCD,'$articulo', '$cantidad', '$precio_unitario', '$total','','','','','','','','','','','','','')";

        if (mysqli_query($conexion1, $sql)) {/*si el proceso se realiza con exito, se cambia a la vista escrita en header */
            header("Location: http://localhost/Sistema/Usuario/Tipo_fichas/ficha_gastos_corrientes_deta.php?id_GC=" . $idGCD);
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conexion1);
        }
    }/*Aca escribimos la variable $monto_superado, la cual se muestra dependiendo de la condicion descrita mas arriba. */
    if ($monto_superado) {
        echo '<div class="alert alert-warning">' . htmlspecialchars("Error: El articulo ingresado no es valido, ya que supera el monto solicitado en la ficha") . '</div>';
    }
}
?>

<?php
///Sistema para el guardado de datos asociados a los gastos anuales ////Ficha Gastos Corrientes ///
/*Como podras apreciar cuando revises la pagina, el ingreso del detalle de los articulos fue realizado en 2 partes, primero se ingresa el nombre, cantidad y precio unitario,
ya con estos datos, se pide poder realizar un ingreso de los montos que se gastaran mensualmente los cuales no pueden superar el valor descrito para el articulo, y la suma de todos,
no puede superar el total solicitado en la ficha, ademas el ingreso anual tiene que ser de manera completa para todos los articulos. */
/*Por lo descrito anteriormente, se validaron opciones y la que me sirvio para realizarlo, fue enviar todo el detalle a traves de un array y recibirlos con el metodo
foreach, lo cual me deja ingresar todo el detalle, ya que recorre todos los arrays enviados y va realizando el proceso solicitado para cada uno de ellos. */
if (isset($_POST['registro_FGC_anual'])) {
    if (empty($_POST['GC_id_ficha_deriv']) || empty($_POST['GC_monto_requerido'])) {
        echo '<div class="alert alert-success">' . htmlspecialchars("Favor complete todos los campos") . '</div>';
    } else {

        $GC_detalle_id_derivado = $_POST['GC_id_ficha_deriv'];
        $GC_id_ficha_det = $_POST['GC_id_ficha_det'];
        $GC_monto_anual_requerido = $_POST['GC_monto_requerido'];
        $GC_Enero = $_POST['GC_Enero'];
        $GC_Febrero = $_POST['GC_Febrero'];
        $GC_Marzo = $_POST['GC_Marzo'];
        $GC_Abril = $_POST['GC_Abril'];
        $GC_Mayo = $_POST['GC_Mayo'];
        $GC_Junio = $_POST['GC_Junio'];
        $GC_Julio = $_POST['GC_Julio'];
        $GC_Agosto = $_POST['GC_Agosto'];
        $GC_Septiembre = $_POST['GC_Septiembre'];
        $GC_Octubre = $_POST['GC_Octubre'];
        $GC_Noviembre = $_POST['GC_Noviembre'];
        $GC_Diciembre = $_POST['GC_Diciembre'];
        $error_encontrado1 = false;

        /*Como las validaciones tienes que ser por los ingresos mensuales versus el monto total solicitado para el articulo, realizamos la validacion a traves de verdadero o falso,
        ya que esto permite que el foreach realice la revision de todos los arrays enviados, y no deje realizar el guardado si uno de los montos no cuadra, en cualquier parte de los arreglos enviados.
         */
        $actualizar = true;
        foreach ($GC_id_ficha_det as $key => $id_detalle_GC) {
            $enero = mysqli_real_escape_string($conexion1, $GC_Enero[$key]);
            $febrero = mysqli_real_escape_string($conexion1, $GC_Febrero[$key]);
            $marzo = mysqli_real_escape_string($conexion1, $GC_Marzo[$key]);
            $abril = mysqli_real_escape_string($conexion1, $GC_Abril[$key]);
            $mayo = mysqli_real_escape_string($conexion1, $GC_Mayo[$key]);
            $junio = mysqli_real_escape_string($conexion1, $GC_Junio[$key]);
            $julio = mysqli_real_escape_string($conexion1, $GC_Julio[$key]);
            $agosto = mysqli_real_escape_string($conexion1, $GC_Agosto[$key]);
            $septiembre = mysqli_real_escape_string($conexion1, $GC_Septiembre[$key]);
            $octubre = mysqli_real_escape_string($conexion1, $GC_Octubre[$key]);
            $noviembre = mysqli_real_escape_string($conexion1, $GC_Noviembre[$key]);
            $diciembre = mysqli_real_escape_string($conexion1, $GC_Diciembre[$key]);
            $meses = array(
                $GC_Enero, $GC_Febrero, $GC_Marzo, $GC_Abril, $GC_Mayo, $GC_Junio, $GC_Julio, $GC_Agosto,
                $GC_Septiembre, $GC_Octubre, $GC_Noviembre, $GC_Diciembre
            );
            $sumatotal = array_sum(array_column($meses, $key)); /*Aca rescatamos la suma total de los meses ingresados. */

            /*aca extraemos el dato del totol que se solicito en el articulo, para posteriormente realizar la validacion mas abajo en el if */
            $sql = "SELECT total_gasto_GC FROM ficha_gastos_detalle WHERE id_detalle_GC = $id_detalle_GC";
            $mostrar_suma = mysqli_query($conexion1, $sql);
            $row = mysqli_fetch_array($mostrar_suma);
            $total = $row['total_gasto_GC'];

            if ($sumatotal != $total) {
                echo '<div class="alert alert-danger">' . htmlspecialchars("Montos mensuales no coinciden con el total del articulo, favor volver a ingresar") . '</div>';
                $actualizar = false;
                break;
            }
        }/*Si todos los arrays enviados cumplen las condiciones descritas, la variable actualizar queda en verdadero y se realiza el proceso de guardado de cada dato enviado. */
        if ($actualizar) {
            foreach ($GC_id_ficha_det as $key => $id_detalle_GC) {
                $enero = mysqli_real_escape_string($conexion1, $GC_Enero[$key]);
                $febrero = mysqli_real_escape_string($conexion1, $GC_Febrero[$key]);
                $marzo = mysqli_real_escape_string($conexion1, $GC_Marzo[$key]);
                $abril = mysqli_real_escape_string($conexion1, $GC_Abril[$key]);
                $mayo = mysqli_real_escape_string($conexion1, $GC_Mayo[$key]);
                $junio = mysqli_real_escape_string($conexion1, $GC_Junio[$key]);
                $julio = mysqli_real_escape_string($conexion1, $GC_Julio[$key]);
                $agosto = mysqli_real_escape_string($conexion1, $GC_Agosto[$key]);
                $septiembre = mysqli_real_escape_string($conexion1, $GC_Septiembre[$key]);
                $octubre = mysqli_real_escape_string($conexion1, $GC_Octubre[$key]);
                $noviembre = mysqli_real_escape_string($conexion1, $GC_Noviembre[$key]);
                $diciembre = mysqli_real_escape_string($conexion1, $GC_Diciembre[$key]);
                $meses = array(
                    $GC_Enero, $GC_Febrero, $GC_Marzo, $GC_Abril, $GC_Mayo, $GC_Junio, $GC_Julio, $GC_Agosto,
                    $GC_Septiembre, $GC_Octubre, $GC_Noviembre, $GC_Diciembre
                );
                $sumatotal = array_sum(array_column($meses, $key));

                $sql = "UPDATE ficha_gastos_detalle SET enero_GC = '$enero', febrero_GC = '$febrero', marzo_GC = '$marzo', 
            abril_GC = '$abril', mayo_GC = '$mayo', junio_GC = '$junio', julio_GC = '$julio', 
            agosto_GC = '$agosto', septiembre_GC = '$septiembre', 
            octubre_GC = '$octubre', noviembre_GC = '$noviembre', 
            diciembre_GC = '$diciembre', total_mensual_GC = '$sumatotal' WHERE id_detalle_GC = '$id_detalle_GC'";
                $result = mysqli_query($conexion1, $sql);
                $error_encontrado1 = true;
                $sql = $conexion1->query("UPDATE ficha_gastos_corrientes SET estado_ficha_GC = 2 WHERE id_GC = $GC_detalle_id_derivado");
                header("location:/Sistema/Usuario/inicio_usuario.php");
            }
        }
    }
}
?>
