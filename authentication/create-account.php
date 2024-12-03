<?php
require 'control.php';
control(3);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Account</title>
</head>
<body>
  <h1>Create Account</h1>
  <form action="create.php" method="post">
    <p>
      <input type="text" name="username" placeholder="username...">
    </p>
    <p>
      <input type="password" name="password" placeholder="password...">
    </p>
    <p>
      <input type="text" name="name" placeholder="fullname">
    </p>
    <p>
      <select name="level" id="">
        <option value="1">Usuario</option>
        <option value="2">Editor</option>
        <option value="3">Administrador</option>
      </select>
    </p>
    <p>
      <input type="submit" value="Crear Cuenta">
    </p>
  </form>
</body>
</html>