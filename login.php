<!-- conexiones a las paginas designadas como controladores -->
<?php
include("/xampp/htdocs/Sistema/controladores/conexion.php");
include("/xampp/htdocs/Sistema/controladores/controlador_usuario.php");
?>
<!-- Pagina para el ingreso de los datos de usuarios -->
<!-- Las primeras instrucciones estan abajo -->

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- link de conexion para bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Presupuesto SECPLA </title>
    <style>
        body {
      background-image: url('img/1366_2000.webp');
      background-size: cover;
      font-family: Arial, Helvetica, sans-serif;
    }

        .card {
            margin-top: 130px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .card-header {
            background-color: black;
            color: #fff;
            font-weight: bold;
            text-align: center;
            padding: 1.5rem;
        }

        .card-body {
            padding: 2rem;
        }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 0;
            font-size: 1.2rem;
            padding: 1rem;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            font-weight: bold;
            padding: 1rem;
            border-radius: 0;
            width: 100%;
        }

        .btn-success:hover {
            background-color: #218838;
        }
    </style>
</head>
<!-- Ingreso de datos, Usuario y Clave -->
<body>
    <div class="card">
        <div class="card-header">
            <h1 class="animate__animated animate__backInLeft">Presupuesto</h1>
        </div>
        <div class="card-body">
            <form id="login-form" action="" method="post" role="form" style="display: block;">
                <div class="mb-3">
                    <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Usuario" value="" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Contraseña" required>
                </div>
                <div class="mb-3">
                    <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="btn btn-success" value="Iniciar sesión">
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<!-- Hola, si estas leyendo esto, es que te designaron la tarea de poder finalizar la programacion de la pagina web relacionada al ingreso de fichas para las
postulaciones de Presupuesto a SECPLA. En los siguientes parrafos y en algunas partes de las paginas, te dejare datos de las conexiones y como estas fueron realizadas,
con esto ojala puedas tener un mejor entendimiento de como fue programando y que me llevo a realizarlo de esta manera -->
<!-- Sin mas que agregar, comencemos jajaja -->

<!-- Los style se definieron por pagina y no por un anexo de css, siemplemente porque fui probando como se podria ver mejor el ingreso de las fichas -->

<!-- La mayoria de las paginas cuenta con codigo php, funciones como 'include' ayudaron a solo tener una conexion y poder llamarla de las otras paginas (cuando vallas
mas adelante notaras que use dos paginas de conexion, lo hice simplemente porque queria separar las conexiones del ingreso de los usuarios a las fichas, pero no
tiene mayor relevancia cual uses.) -->

<!-- En algunas paginas el ingreso, lectura o modificacion de los datos (o simplemente el orden) se realizo de maneras difentes, ya que, todo este proceso es de testing,
por ende, se fueron probando diferentes maneras de realizar los procesos, la idea es que identifiques cual es el que prefieres y programes en base a eso. -->

<!-- Para que las  fichas fueran diferenciandose, determine que la mejor manera era a traves de estados, los cuales se modifican dependiendo en que etapa esta la ficha.
De las 3 fichas que alcance a configurar, 2 de estas mantenian detalles que tenian que ser rellenados despues de guardar la primera etapa, ya sea que, se tenga 
que llenar un detalle de articulos comprados, o actividades a realizar, preferi no llenar todo en una parte para que se entienda mejor.
aca de detallo los estados y para que son cada uno.

1 en proceso : Este estado es para las fichas que fueron creadas por el usuario pero aun no se finalizan.
2 enviadas: Este estado es para las fichas que el usuario ya ingreso todos los datos necesarios, por ende, dejan de estar dsponibles para ellos y pasan al director
3 corregida: Ficha devuelta por director, esta viene con un comentario del motivo de la correccion, todavia no esta realizado, 
pero la idea es que cuando esta sea corregida, el usuario lea la ficha y pueda arreglar los detalles que describio el director,
logrando poder reenviar la misma ficha para que sea aprobada.
4 reenviada: no he utilizado este estado, pero lo deje listo para que las fichas devueltas puedes quedar en ese estado y saber cuales son.
5 aceptado: este estado es para las fichas que fueron revisadas por el director y aprobadas, pasando al ultimo proceso que seria la 
revision de SECPLA.
6 rechazado: este estado es para las fichas que pasaron el proceso con el director, pero fueron rechazadas por SECPLA, siendo devueltas
al director con los comentarios pertinentes.
7 aprobada: este es el ultimo estado para las fichas que pasaron todas las validaciones y se encuentran aprobadas.-->

<!-- espero que estos datos de den una mejor idea del codigo y sus funcionamientos, de igual manera en las paginas te dejare notas 
de las funciones de cada parte del codigo.-->

<!-- El llenado de los datos lo hare en orden, empezando por la primera carpeta que es Admnistrador, te comento porque algunas cosas
no las destacare en todas las paginas, sino en la primera segun el orden de manera descendente-->


