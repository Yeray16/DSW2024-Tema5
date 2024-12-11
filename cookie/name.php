<?php
//Creamos una variable name
$name;
//Comprueba si se ha pasado el atributo delete por la URL
if (isset($_GET['delete'])) {
  //En caso de que se haya pasado se elimina la cookie
  setcookie('name', 'a', time() - 1);
} else { //Si no se ha pasado el parámetro delete
  //Comprueba si se ha pasado el parámetro name por URL
  if (!empty($_GET['name'])) {
    //Se crea una cookie llamada name, con el valor que se pasa por la URL
    setcookie('name', $_GET['name']);
    //Damos valor a la variable nombre
    $name = $_GET['name'];
  } else { //Comprueba el caso en el que el parámetro name no esté en la URL pero la cookie si
    if (isset($_COOKIE['name'])) {
      //Si existe dicha cookie, asignamos a la variable el valor de dicha cookie
      $name = $_COOKIE['name'];
    }
  }
}

//Comprueba si existe la variable name, para que se muestre en la frase
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