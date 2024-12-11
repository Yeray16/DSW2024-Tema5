<?php
require 'control.php'; // Verifica el nivel de acceso antes de permitir la creación de cuentas
control(3); // Solo los administradores (nivel 3) pueden acceder
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Account</title>
</head>
<body>
  <h1>Create Account</h1> <!-- Título de la página -->
  <form action="create.php" method="post"> <!-- Formulario para crear una nueva cuenta -->
    <p>
      <input type="text" name="username" placeholder="username..."> <!-- Campo para el nombre de usuario -->
    </p>
    <p>
      <input type="password" name="password" placeholder="password..."> <!-- Campo para la contraseña -->
    </p>
    <p>
      <input type="text" name="name" placeholder="fullname"> <!-- Campo para el nombre completo -->
    </p>
    <p>
      <select name="level" id=""> <!-- Selección del nivel de acceso -->
        <option value="1">Usuario</option>
        <option value="2">Editor</option>
        <option value="3">Administrador</option>
      </select>
    </p>
    <p>
      <input type="submit" value="Crear Cuenta"> <!-- Botón para enviar el formulario -->
    </p>
  </form>
</body>
</html>
