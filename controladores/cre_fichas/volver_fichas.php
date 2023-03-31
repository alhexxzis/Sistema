<!--Esta es una vista creada como prueba de lo ultimo que se solicito, lo cual tenia que ver con el proceso del llenado de la ficha,
ya que, segun lo que me comentaron si me devuelvo de vista con un botton descrito como regresar, la idea es poder volver a la parte 1
de la ficha desde el ingreso de los detalles (fichas con mas de una hoja de llenado).
para no sobre guardar fichas con los mismos datos, al momento de realizar realizo un delete a la ficha y dejo realizar el ingreso desde
el principio. -->

<?php
include("/xampp/htdocs/Sistema/controladores/cre_fichas/conexion_fichas.php");

$id_ficha_GC = $_GET['id_GC'];

mysqli_query($conexion1, "delete from ficha_gastos_corrientes where id_GC ='$id_ficha_GC'") or die("error al eliminar");

mysqli_close($conexion1);
header ("location:/Sistema/Usuario/Tipo_fichas/ficha_gastos_corrientes.php")


?>