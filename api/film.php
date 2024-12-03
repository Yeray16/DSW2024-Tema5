<?php
require 'connection.php';

header("Content-type: application/json; charset=utf-8");

if (!isset($_GET['id'])) {
  $stmtFilms = $link->prepare('SELECT film_id, title FROM film');
  $stmtFilms->execute();
  $films = $stmtFilms->fetchAll(PDO::FETCH_OBJ);
  echo json_encode($films);
} else {
  $stmtFilms = $link->prepare('SELECT * FROM film WHERE film_id = :id');
  $stmtFilms->bindParam(':id', $_GET['id']);
  $stmtFilms->execute();
  $film = $stmtFilms->fetchObject();
  if ($film) {
    echo json_encode($film);
  } else {
    http_response_code(404);
  }
  
}
