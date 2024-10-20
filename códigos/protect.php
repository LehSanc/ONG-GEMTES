<?php
if (!function_exists("protect")) {
  function protect()
  {

    if (!isset($_SESSION)) session_start();

    if (!isset($_SESSION['CPF']) || !is_numeric($_SESSION['CPF']) || strlen($_SESSION['CPF']) != 11) {
      header("Location: ../index.php");
    }
  }
}
