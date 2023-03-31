<!--Vista creada para controlar la eliminacion del detalle de partidas de la ficha proyectos-->
<!--Como en las anteriores, se recibe el detalle de lo que se quiere eliminar por el metodo GET y luego se procede al delete-->
<?php
include('/xampp/htdocs/Sistema/controladores/cre_fichas/conexion_fichas.php');
$id_anual_PY_derivado = $_GET['id_PY_derivado'];

if(!empty($_GET['id_PY_detalle'])){
$id_anual_PY = $_GET['id_PY_detalle'];

/*Con esto podemos imprimir los datos enviados por GET, lo use mayoritariamente cuando tenia errores, asi validaba
si los datos desde la pagina que configure los imput enviaba o no el dato requerido, y asi, puedes saber de mejor manera donde ocurre el problema */
echo "<pre>";
print_r($_GET);
echo "</pre>";

/*conexion a la tabla para la eliminacion del detalle */
$sql=$conexion1->query("DELETE FROM ficha_py_detalle_anual WHERE id_PY_detalle = $id_anual_PY ");
if($sql){
    header("HTTP/1.1 302 Found");
    header("Location: http://localhost/Sistema/Usuario/Tipo_fichas/ficha_PY_detalle.php?id_PY=" . $id_anual_PY_derivado);
    exit;
    
}else { 
echo '<div class="alert alert-danger" >ERROR</div>';
}

}
?>