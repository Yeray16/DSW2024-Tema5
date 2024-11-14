<?php
//acceso a la base de datos.
if(empty($_GET['page'])){
  header('Location: indice.html');
} else {
  $page = $_GET['page'];
  header("Location: $page");
}