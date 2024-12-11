<?php
//Con la función control verificamos si el usuario está logueado y tiene el nivel adecuado para acceder a una página
function control($level)
{
  session_start(); // Inicia la sesión

  // Si no hay un usuario logueado o el nivel de acceso es inferior al requerido, redirige al login
  if (!isset($_SESSION['username']) || $_SESSION['level'] < $level) {
    header('Location: login.php'); // Redirige al usuario a la página de login
    exit(); // Finaliza el script para que no se ejecute más código
  }
}
