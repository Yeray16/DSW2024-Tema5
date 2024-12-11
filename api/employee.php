<?php
require '../data/employees.php'; // Incluye el archivo de empleados que contiene el array $employees con la información de los empleados
header("Content-type: application/json; charset=utf-8"); // Establece el tipo de contenido de la respuesta como JSON y la codificación como UTF-8

// Verifica si se ha pasado un parámetro 'id' en la URL (por ejemplo, ?id=1)
if (isset($_GET['id'])) {
  // Filtra el array de empleados para encontrar el que tenga el 'id' igual al pasado en la URL
  $employee = array_filter($employees, fn($e) => $e['id'] == $_GET['id']);
  // Obtiene el primer elemento del array filtrado (en este caso solo debería haber uno)
  $employee = array_pop($employee);
  // Si se encuentra el empleado, lo convierte a formato JSON y lo imprime con una buena presentación
  if ($employee) {
    echo json_encode($employee, JSON_PRETTY_PRINT); // Devuelve el empleado en formato JSON
  } else {
    http_response_code(404); // Si no se encuentra el empleado, devuelve el código de estado HTTP 404 (No encontrado)
  }
} else if (isset($_GET['position'])){ // Si se pasa un parámetro 'position' en la URL
  // Filtra el array de empleados para encontrar aquellos que tengan la posición especificada
  $employeeFilter = array_filter($employees, fn($e) => $e['position'] == $_GET['position']);
  // Devuelve los empleados filtrados en formato JSON
  echo json_encode($employeeFilter, JSON_PRETTY_PRINT);
} else {
  // Si no se pasa ningún filtro, devuelve todos los empleados en formato JSON
  echo json_encode($employees, JSON_PRETTY_PRINT);
}
