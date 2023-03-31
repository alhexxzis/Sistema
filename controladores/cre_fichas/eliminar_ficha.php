<!--Desde esta vista controlamos la eliminacion de las fichas, con los metodos ya conocidos, en este caso, se uso POST para
recibir los datos de las fichas que se quieran eliminar-->
<?php

include('/xampp/htdocs/Sistema/controladores/conexion.php');
/*Ficha Gastos Corrientes */
/*Para la eliminacion de una ficha, es necesario primero eliminar las tablas derivadas de la principal, ya que la conexion por foranea
en SQL no permite eliminar la principal sin eliminar las que estan enlazadas por foranea, por ende, tenemos que eliminar en order.
por ej: aca eliminamos primero el detalle de la tabla ficha_gastos_detalle que se encuentra asociado al id de la ficha_gastos_corrientes,
ya con eso eliminado, podemos proceder a eliminar la ficha, ademas eliminamos de igual manera la ficha de la tabla general. */
if(isset($_POST['btnEliminar_GC'])){
$id_ficha_GCDetalle=$_POST ['id'];
mysqli_query($conexion, "delete from ficha_gastos_detalle where id_fichas_GC = $id_ficha_GCDetalle") or die("error al eliminar");

$id_ficha=$_POST ['id'];
mysqli_query($conexion, "delete from ficha_gastos_corrientes where id_GC = $id_ficha") or die("error al eliminar");
mysqli_query($conexion, "delete from fichas_general_secpla where id_fichas = $id_ficha") or die("error al eliminar");


mysqli_close($conexion);
header ("location:/Sistema/Administrador/inicio_admi.php");
}
?>

<?php
include('/xampp/htdocs/Sistema/controladores/conexion.php');
/*Ficha Contratos */
if(isset($_POST['btnEliminar_FC'])){
$id_ficha_GCDetalle=$_POST ['id_FC'];
mysqli_query($conexion, "delete from ficha_contratos_vigente where id_FC_derv = $id_ficha_GCDetalle") or die("error al eliminar");

$id_ficha=$_POST ['id_FC'];
mysqli_query($conexion, "delete from ficha_contratos where id_FC = $id_ficha") or die("error al eliminar");
mysqli_query($conexion, "delete from fichas_general_secpla where id_fichas = $id_ficha") or die("error al eliminar");

mysqli_close($conexion);
header ("location:/Sistema/Administrador/inicio_admi.php");
}
?>

<?php
include('/xampp/htdocs/Sistema/controladores/conexion.php');
/*Ficha Proyectos */
if(isset($_POST['btnEliminar_PY'])){
$id_ficha_GCDetalle=$_POST ['id_PY'];

mysqli_query($conexion, "delete from ficha_py_detalle_anual where id_PY_derivado = $id_ficha_GCDetalle") or die("error al eliminar");

$id_ficha=$_POST ['id_PY'];
mysqli_query($conexion, "delete from ficha_proyectos where id_PY = $id_ficha") or die("error al eliminar");
mysqli_query($conexion, "delete from fichas_general_secpla where id_fichas = $id_ficha") or die("error al eliminar");

mysqli_close($conexion);
header ("location:/Sistema/Administrador/inicio_admi.php");
}
?>


