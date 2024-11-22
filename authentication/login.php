<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<h1>Control de Acceso</h1>
<form action="access.php" method="get">
  <p>
    <input type="text" name="username" placeholder="Nombre de usuario...">
  </p>
  <p>
    <input type="password" name="password" placeholder="password...">
  </p>
  <p>
    <input type="submit" value="Login">
  </p>
</form>
</body>
</html>