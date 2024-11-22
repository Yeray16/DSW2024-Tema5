<?php
$name;
if (isset($_GET['delete'])) {
  setcookie('name', 'a', time() - 1);
} else {
  if (!empty($_GET['name'])) {
    setcookie('name', $_GET['name']);
    $name = $_GET['name'];
  } else {
    if (isset($_COOKIE['name'])) {
      $name = $_COOKIE['name'];
    }
  }
}

if (isset($name)) {
  printf("<p>Su nombre es %s</p>", $name);
?>
  <form action="name.php">
    <button type="submit" name="delete">Eliminar Cookie</button>
  </form>
<?php
} else {
  echo "<p>No sé su nombre</p>";
?>
  <form action="name.php">
    <input type="text" name="name">
    <input type="submit" value="Enviar">
  </form>
<?php
}
?>
<p><a href="name.php">Actualizar</a></p>