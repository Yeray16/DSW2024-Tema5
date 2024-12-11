<?php
session_start(); // Inicia la sesión, permitiendo usar variables de sesión (como $_SESSION)
session_destroy(); // Destruye la sesión, cerrando cualquier sesión previa (usuario logueado)

//Esta página destruye la sesión y muestra el formulario para ingresar el nombre de usuario y la contraseña
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<h1>Control de Acceso</h1> <!-- Título de la página -->
<form action="access.php" method="get"> <!-- Formulario que envía los datos al archivo access.php con método GET -->
  <p>
    <input type="text" name="username" placeholder="Nombre de usuario..."> <!-- Campo para el nombre de usuario -->
  </p>
  <p>
    <input type="password" name="password" placeholder="password..."> <!-- Campo para la contraseña -->
  </p>
  <p>
    <input type="submit" value="Login"> <!-- Botón de envío del formulario -->
  </p>
</form>
</body>
</html>
