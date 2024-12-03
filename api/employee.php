<?php
require '../data/employees.php';
header("Content-type: application/json; charset=utf-8");

//filtro por id
if (isset($_GET['id'])) {
  $employee = array_filter($employees, fn($e) => $e['id'] == $_GET['id']);
  $employee = array_pop($employee);
  if ($employee) {
    echo json_encode($employee, JSON_PRETTY_PRINT);
  } else {
    http_response_code(404);
  }
} else if (isset($_GET['position'])){
  $employeeFilter = array_filter($employees, fn($e) => $e['position'] == $_GET['position']);
  echo json_encode($employeeFilter, JSON_PRETTY_PRINT);
} else {
  echo json_encode($employees, JSON_PRETTY_PRINT);
}
