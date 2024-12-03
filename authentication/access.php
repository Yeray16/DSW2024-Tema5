<?php
session_start();
require 'connection.php';

if(!empty($_GET['username']) && !empty($_GET['password'])) {
  try{
    $stmtLogin = $link->prepare('SELECT * FROM users WHERE username = :username');
    $stmtLogin->bindParam(':username', $_GET['username']);
    $stmtLogin->execute();
    if($user = $stmtLogin->fetchObject()) {
      if(password_verify($_GET['password'], $user->password)){
        $_SESSION['username'] = $user->username;
        $_SESSION['level'] = $user->level;
        header('Location: index.php');
      }else {
        header('Location: login.php');
      }
    } else {
      header('Location: login.php');
    }
  } catch(PDOException $e) {
    echo "Error en el login: " . $e->getMessage();
  }
  
}