<?php
/*Como en otras fichas, aca procedemos a recibir el id por el metodo GET y generamos las funciones necesarias para el proceso requerido,
en este caso, para eliminar el detalle asociado a la ficha Gastos Corrientes*/
include('/xampp/htdocs/Sistema/controladores/cre_fichas/conexion_fichas.php');
$id_derivado_GC= $_GET ['id_fichas_GC'];


if (!empty($_GET["id_detalle_GC"])) {
    $id_ficha_detalle=$_GET["id_detalle_GC"];
    $sql=$conexion1->query("DELETE from ficha_gastos_detalle WHERE id_detalle_GC = $id_ficha_detalle");
    if ($sql==true) {
        /*lo que lleva arriba el header de location es para evitar errores al momento de realizar el cambio de vista en las fichas */
        header("HTTP/1.1 302 Found");
        header("Location: http://localhost/Sistema/Usuario/Tipo_fichas/ficha_gastos_corrientes_deta.php?id_GC=".$id_derivado_GC);
        exit;
            
    } else { 
    
    echo '<div class="alert alert-danger" >ERROR</div>';
    }
}
    ?>
