<!--Vista relacionada con el detalle de las fichas de Proyectos.-->
<?php
include("/xampp/htdocs/Sistema/controladores/cre_fichas/conexion_fichas.php");
/*Para trabajar el detalle de las partidas de esta ficha, se realizo exactamente el mismo proceso que el detalle de la ficha gastos corrientes*/
if (isset($_POST['submit_PY_partida'])) {
    $id_derivado_py = $_POST['id_PY_derivado'];
    $monto_py = $_POST['id_PY_monto_derivado'];
    $partida_py = $_POST['py_partida'];
    $medicion_py = $_POST['py_medicion'];
    $cantidad_py = floatval($_POST['py_cantidad']);
    $precio_unitario_py = floatval($_POST['py_precio_unitario']);
    $total_PY = $cantidad_py * $precio_unitario_py;
/*suma de los datos guardados en la tabla, a esto se le suma el detalle que se esta ingresando, y, si este supera el total
solicitado en la ficha, se arroja un mensaje para el error y no permite el ingreso de los datos. */
    $query = "SELECT SUM(total_PY) AS total FROM ficha_py_detalle_anual WHERE id_PY_derivado = $id_derivado_py";
    $result = mysqli_query($conexion1, $query);
    $row = mysqli_fetch_assoc($result);
    $total_gasto_PY = $row['total'];

    /*Variable if para la validacion de los datos. */
    if ($total_PY + $total_gasto_PY > $monto_py) {
        $monto_superado = true;
    } else {
        $sql = "INSERT INTO ficha_py_detalle_anual (id_PY_detalle, id_PY_derivado, descripcion_gasto_PY, unidades_partida_PY, cantidad_PY_partida,
        precio_unit_PY, total_PY, enero_PY, febrero_PY, marzo_PY, abril_PY,mayo_PY,junio_PY,julio_PY,agosto_PY,septiembre_PY,octubre_PY,noviembre_PY,
        diciembre_PY, total_anual_PY)
                VALUES ('','$id_derivado_py','$partida_py','$medicion_py','$cantidad_py','$precio_unitario_py','$total_PY','','','','','',
                '','','','','','','','')";

        if (mysqli_query($conexion1, $sql)) {
            header("Location: http://localhost/Sistema/Usuario/Tipo_fichas/ficha_PY_detalle.php?id_PY=" . $id_derivado_py);
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conexion1);
        }
    }
    if ($monto_superado) {/*los div dentro del echo, es la forma de poder procesar funciones de html en una funcion de php, aca
        por ejemplo generamos un div para el mensaje, luego le añadimos  un scripts con un temporizador asociado, que se activa cuando
        la alerta es activada. */
        echo '<div class="alert alert-warning" id="mensaje">ERROR: Montos no puede ser ingresado</div>';
        echo '<script>window.onload = function() { setTimeout(function() { document.getElementById("mensaje").remove(); }, 2000); }</script>';
    }
}

/*Aca pasamos al detalle del ingreso para los datos de los gastos mensuales en el año, eso procesa de la misma manera que el detalle de la ficha
gastos corrientes. Primero validamos ciertos datos que se envien, asi podemos asegurarnos que los campos se esta llenando con datos validos */
if (isset($_POST['anual_py_guardar'])) {
    if(empty($_POST['PY_id_ficha_deriv']) || empty($_POST['PY_monto_requerido'])) {
        echo '<div class="alert alert-success">' . htmlspecialchars("Favor complete todos los campos") . '</div>';
      } else{

    $py_ficha = $_POST['PY_id_ficha_deriv'];
    $PY_id_det = $_POST['PY_id_ficha_det'];
    $monto_derivado = $_POST['PY_monto_requerido'];
    $py_Enero = $_POST['PY_Enero'];
    $py_Febrero = $_POST['PY_Febrero'];
    $py_Marzo = $_POST['PY_Marzo'];
    $py_Abril = $_POST['PY_Abril'];
    $py_Mayo = $_POST['PY_Mayo'];
    $py_Junio = $_POST['PY_Junio'];
    $py_Julio = $_POST['PY_Julio'];
    $py_Agosto = $_POST['PY_Agosto'];
    $py_Septiembre = $_POST['PY_Septiembre'];
    $py_Octubre = $_POST['PY_Octubre'];
    $py_Noviembre = $_POST['PY_Noviembre'];
    $py_Diciembre = $_POST['PY_Diciembre'];
    $error_encontrado1 = false;

/*Luego de la creacion de las variables, se proceso a traer los datos guardados en el arrays, con el metodo foreach */
    $actualizar = true;
    foreach ($PY_id_det as $key => $id_PY_detalle) {
        $enero = mysqli_real_escape_string($conexion1, $py_Enero[$key]);
        $febrero = mysqli_real_escape_string($conexion1, $py_Febrero[$key]);
        $marzo = mysqli_real_escape_string($conexion1, $py_Marzo[$key]);
        $abril = mysqli_real_escape_string($conexion1, $py_Abril[$key]);
        $mayo = mysqli_real_escape_string($conexion1, $py_Mayo[$key]);
        $junio = mysqli_real_escape_string($conexion1, $py_Junio[$key]);
        $julio = mysqli_real_escape_string($conexion1, $py_Julio[$key]);
        $agosto = mysqli_real_escape_string($conexion1, $py_Agosto[$key]);
        $septiembre = mysqli_real_escape_string($conexion1, $py_Septiembre[$key]);
        $octubre = mysqli_real_escape_string($conexion1, $py_Octubre[$key]);
        $noviembre = mysqli_real_escape_string($conexion1, $py_Noviembre[$key]);
        $diciembre = mysqli_real_escape_string($conexion1, $py_Diciembre[$key]);
        $meses = array(
            $py_Enero, $py_Febrero, $py_Marzo, $py_Abril, $py_Mayo, $py_Junio, $py_Julio, $py_Agosto,
            $py_Septiembre, $py_Octubre, $py_Noviembre, $py_Diciembre
        );
        $sumatotal = array_sum(array_column($meses, $key));

        $sql = "SELECT total_PY FROM ficha_py_detalle_anual WHERE id_PY_detalle = $id_PY_detalle";
        $mostrar_suma = mysqli_query($conexion1, $sql);
        $row = mysqli_fetch_array($mostrar_suma);
        $total = $row['total_PY'];

        if ($sumatotal != $total) {
            echo '<div class="alert alert-danger">' . htmlspecialchars("El monto de $sumatotal no coincide con lo solicitado, favor revisar $total") . '</div>';
            $actualizar = false;
            break;
        }
    }
    if ($actualizar) {

        foreach ($PY_id_det as $key => $id_PY_detalle) {
            $enero = mysqli_real_escape_string($conexion1, $py_Enero[$key]);
            $febrero = mysqli_real_escape_string($conexion1, $py_Febrero[$key]);
            $marzo = mysqli_real_escape_string($conexion1, $py_Marzo[$key]);
            $abril = mysqli_real_escape_string($conexion1, $py_Abril[$key]);
            $mayo = mysqli_real_escape_string($conexion1, $py_Mayo[$key]);
            $junio = mysqli_real_escape_string($conexion1, $py_Junio[$key]);
            $julio = mysqli_real_escape_string($conexion1, $py_Julio[$key]);
            $agosto = mysqli_real_escape_string($conexion1, $py_Agosto[$key]);
            $septiembre = mysqli_real_escape_string($conexion1, $py_Septiembre[$key]);
            $octubre = mysqli_real_escape_string($conexion1, $py_Octubre[$key]);
            $noviembre = mysqli_real_escape_string($conexion1, $py_Noviembre[$key]);
            $diciembre = mysqli_real_escape_string($conexion1, $py_Diciembre[$key]);
            $meses = array(
                $py_Enero, $py_Febrero, $py_Marzo, $py_Abril, $py_Mayo, $py_Junio, $py_Julio, $py_Agosto,
                $py_Septiembre, $py_Octubre, $py_Noviembre, $py_Diciembre
            );
            $sumatotal = array_sum(array_column($meses, $key));

            $sql = "UPDATE ficha_py_detalle_anual SET enero_PY = '$enero', febrero_PY = '$febrero', marzo_PY = '$marzo', 
            abril_PY = '$abril', mayo_PY = '$mayo', junio_PY = '$junio', julio_PY = '$julio', 
            agosto_PY = '$agosto', septiembre_PY = '$septiembre', 
            octubre_PY = '$octubre', noviembre_PY = '$noviembre', 
            diciembre_PY = '$diciembre', total_anual_PY = '$sumatotal' WHERE id_PY_detalle = '$id_PY_detalle'";
            $result = mysqli_query($conexion1, $sql);
            $error_encontrado1 = true;
            $sql = $conexion1->query("UPDATE ficha_proyectos SET estado_ficha_PY = 2 WHERE id_PY = $py_ficha");
            header("location:/Sistema/Usuario/inicio_usuario.php");
        }
    }
}
}
?>