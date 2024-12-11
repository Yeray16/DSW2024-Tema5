<?php
$animals = [
  'fish' => ['nemo', 'dorada', 'vieja', 'abade', 'cherne', 'medregal'],
  'insect' => ['beatle', 'ant', 'butterfly', 'fly', 'mosquito'],
  'reptil' => ['snake', 'lizard', 'tortoise', 'cocodrile']
];

$listOfAnimals = [];
//Si no se pasa sepcies en la URL, el código comprueba si existe una cookie llamada species
if (empty($_GET['species'])) {
  //Si no existe la cookie species, se agregan todos los animales de todas las categorías a listOfAnimals
  if (empty($_COOKIE['species'])) {
    foreach ($animals as $species) {
      $listOfAnimals = array_merge($listOfAnimals, $species);
    }
  } else { //SI existe una cookie species el código solo carga los animales de dicha categrotía/especie
    $listOfAnimals = $animals[$_COOKIE['species']];
  }
} else { //En el caso que se pase un parámetro species por la URL
  //Si el parámetro de species es all, se agregan todos los animales a listOfAnimals
  if ($_GET['species'] == 'all') {
    foreach ($animals as $species) {
      $listOfAnimals = array_merge($listOfAnimals, $species);
    }
    //Se elimina lo cookie
    setcookie('species', '', time() - 1);
  } else { //En el caso en que se pase una categoría específica
    //Se añaden solo los animales de dicha categoría
    $listOfAnimals = $animals[$_GET['species']];
    //Guarda dicha categoría en la cookie con una duración de 120 segundos (2 minutos)
    setcookie('species', $_GET['species'], time() + 120);
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <nav>
    <ul>
      <?php
      foreach ($animals as $name => $value) {
        printf('<li><a href="preferencias.php?species=%s">%s</a></li>', $name, $name);
      }
      ?>

      <li><a href="preferencias.php?species=all">Todos</a></li>
    </ul>
  </nav>
  <ul>
    <?php
    foreach ($listOfAnimals as $animal) {
      printf('<li>%s</li>', $animal);
    }
    ?>
  </ul>
</body>

</html>