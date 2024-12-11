<?php
require 'control.php'; // Incluye el archivo de control para verificar el nivel de acceso
control(2); // Verifica que el usuario tenga al menos nivel 2 para acceder a la página
$username = $_SESSION['username']; // Obtiene el nombre de usuario de la sesión
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Página 1</h1> <!-- Muestra el título de la página -->
</body>
</html>
