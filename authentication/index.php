<?php
//Muestra un mensaje de bienvenida y verifica si el usuario tiene acceso al contenido
require 'control.php'; // Incluye el archivo de control para comprobar el nivel de acceso
control(1); // Llama a la función control() para verificar que el usuario tiene al menos el nivel 1
$username = $_SESSION['username']; // Asigna el nombre de usuario guardado en la sesión a la variable $username
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Bienvenido <?=$username?></h1> <!-- Muestra un mensaje de bienvenida con el nombre del usuario -->
  <p><a href="login.php">Cerrar sesión</a></p> <!-- Enlace para cerrar sesión -->
</body>
</html>
