<?php
session_start();

if (isset($_SESSION['visits'])){
  $_SESSION['visits']++;
} else {
  $_SESSION['visits'] = 1;
}

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
