<?php
$host = 'localhost';
$db = 'pedidos';
$user = 'root';
$pswd = '';

try {
  $link = new PDO("mysql:host=$host;dbname=$db", $user, $pswd);
  $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die('Error de conexión: '.$e->getMessage());
}