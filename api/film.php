<?php
require 'connection.php'; // Incluye el archivo de conexión a la base de datos (con PDO)

header("Content-type: application/json; charset=utf-8"); // Establece el tipo de contenido de la respuesta como JSON y la codificación UTF-8

// Verifica si se ha pasado un parámetro 'id' en la URL
if (!isset($_GET['id'])) {
  // Si no se pasa 'id', consulta todos los títulos de las películas en la base de datos
  $stmtFilms = $link->prepare('SELECT film_id, title FROM film'); // Prepara la consulta SQL para seleccionar el id y título de las películas
  $stmtFilms->execute(); // Ejecuta la consulta
  $films = $stmtFilms->fetchAll(PDO::FETCH_OBJ); // Recupera todos los resultados como objetos
  echo json_encode($films); // Devuelve la lista de películas en formato JSON
} else {
  // Si se pasa un 'id', consulta la película con ese id específico
  $stmtFilms = $link->prepare('SELECT * FROM film WHERE film_id = :id'); // Prepara la consulta SQL con un parámetro :id
  $stmtFilms->bindParam(':id', $_GET['id']); // Asocia el parámetro :id con el valor pasado en la URL
  $stmtFilms->execute(); // Ejecuta la consulta
  $film = $stmtFilms->fetchObject(); // Recupera el resultado como un objeto

  // Si se encuentra la película con ese id, la devuelve en formato JSON
  if ($film) {
    echo json_encode($film); // Devuelve la película en formato JSON
  } else {
    http_response_code(404); // Si no se encuentra la película, devuelve el código de estado HTTP 404 (No encontrado)
  }
}
