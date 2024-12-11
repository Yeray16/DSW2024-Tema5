<?php
//Empezamos la sesión
session_start();

//Comprueba si existe la sesión de visitas, si existe la incrementa
if (isset($_SESSION['visits'])){
  $_SESSION['visits']++;
} else { //Si no existe dicha sesión, la crea y le da un valor por defecto
  $_SESSION['visits'] = 1;
}

//Empezamos una sesión de horas que sea igual al la hora y fecha actual
$_SESSION['hours'][] = time();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<!--Mostramos la cantidad de visitas-->
<p>Número de visitas: <?=$_SESSION['visits'];?></p>
<ul>
<?php
  foreach($_SESSION['hours'] as $time) {
    printf('<li>%s</li>', date("d/m/Y H:i:s", $time));
  }
?>
</ul>
 
</body>
</html>
