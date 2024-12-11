<?php
session_start(); // Inicia la sesión
require 'connection.php'; // Conexión a la base de datos

// Si los campos 'username' y 'password' no están vacíos
if(!empty($_GET['username']) && !empty($_GET['password'])) {
  try{
    // Prepara la consulta SQL para obtener el usuario de la base de datos
    $stmtLogin = $link->prepare('SELECT * FROM users WHERE username = :username');
    $stmtLogin->bindParam(':username', $_GET['username']); // Víncula el nombre de usuario
    $stmtLogin->execute(); // Ejecuta la consulta
    if($user = $stmtLogin->fetchObject()) { // Si el usuario existe
      // Verifica la contraseña encriptada
      if(password_verify($_GET['password'], $user->password)){
        // Si la contraseña es correcta, guarda la información en la sesión
        $_SESSION['username'] = $user->username;
        $_SESSION['level'] = $user->level;
        header('Location: index.php'); // Redirige al usuario a la página principal
      } else {
        header('Location: login.php'); // Si la contraseña es incorrecta, redirige al login
      }
    } else {
      header('Location: login.php'); // Si el usuario no existe, redirige al login
    }
  } catch(PDOException $e) { // Captura cualquier error en la base de datos
    echo "Error en el login: " . $e->getMessage();
  }
} 
