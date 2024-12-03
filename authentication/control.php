<?php
function control($level)
{
  session_start();

  if (!isset($_SESSION['username']) || $_SESSION['level'] < $level) {
    header('Location: login.php');
    exit();
  }
}
