<?php
//Permite a los administradores crear nuevas cuentas de usuarios
control(3); // Verifica que el usuario tenga el nivel de acceso 3 (Administrador)
require 'connection.php'; // Incluye el archivo para la conexión a la base de datos

// Verifica que todos los campos del formulario estén completos
if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['name']) && !empty($_POST['level'])){
  try{
    // Prepara la consulta SQL para insertar un nuevo usuario en la base de datos
    $stmtCreate = $link->prepare('INSERT INTO users (username, password, name, level) VALUES (:username, :pw, :name, :level)');
    $stmtCreate->bindParam(':username', $_POST['username']); // Víncula el nombre de usuario
    $encrypt = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encripta la contraseña
    $stmtCreate->bindParam(':pw', $encrypt); // Víncula la contraseña encriptada
    $stmtCreate->bindParam(':name', $_POST['name']); // Víncula el nombre del usuario
    $stmtCreate->bindParam(':level', $_POST['level']); // Víncula el nivel de acceso
    $stmtCreate->execute(); // Ejecuta la consulta
  } catch(PDOException $e) { // Captura cualquier error y lo muestra
    die('Error al crear el usuario:' . $e->getMessage());
  }

} else {
  die ('Error en los datos'); // Muestra un error si no se han ingresado todos los campos
}
