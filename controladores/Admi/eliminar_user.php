<!--En esta carpeta (Controladores) realizamos las vistas para la recepcion de los datos enviados a traves de los imput, Ademas,
se programan las validaciones necesarias dependiendo de lo solicitado por el area-->
<!--Los controladores al igual que las vistas estan divididas en carpetas, asi mantenemos un orden y configuramos las paginas en 
relacion a que usuario se esta trabajando-->
<!--Admi: Carpeta relacionada a los controladores del usuario Administrador-->
<!--controlador_secpla: Carpeta relacionada a los controladores del usuario SECPLA-->
<!--cre_fichas: Carpeta relacionada a la creacion y configuracion de las fichas-->
<?php
/*Se incluye la pagina relacionada con la conexion a la base de datos*/
include('/xampp/htdocs/Sistema/controladores/conexion.php');
$id=$_POST ['txtid']; /*Se recepcionan los datos enviados a traves de imput, recuerda que se asocian a traves del 'name'*/
$idusuarioelim = $_POST['txtid'];

/*Se incluye la pagina relacionada con la conexion*/
/*Se realizado una consulta a la tabla fichas, motivo de que para eliminar el usuario, es necesario eliminar las fichas asociadas
por clave foranea a la tabla usuario, mas especificamente al id. */
$sql = "SELECT id_GC FROM ficha_gastos_corrientes WHERE GC_usuario = $idusuarioelim";
$resultado = mysqli_query($conexion, $sql);
if ($resultado) {
  $fila = mysqli_fetch_assoc($resultado);
  $detalleidelim = $fila['id_GC'];
}
/*Eliminacion de fichas y usuario, esto se realizado a traves del proceso delete del lenguaje SQL */
mysqli_query($conexion, "delete from ficha_gastos_detalle where id_fichas_GC ='$detalleidelim'") or die("error al eliminar");
mysqli_query($conexion, "delete from ficha_gastos_corrientes where GC_usuario ='$idusuarioelim'") or die("error al eliminar");
mysqli_query($conexion, "delete from usuario where id ='$id'") or die("error al eliminar");

/* Se cierra la conexion y se utiliza el header, para que al momento de finalizar los procesos escritos, se derive a la pagina que uno determine */
mysqli_close($conexion);
header ("location:/Sistema/Administrador/lista_usuarios.php")

?>
