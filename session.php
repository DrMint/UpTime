<?php

  $loginPageURL = 'https://up.barillot.net/login';

  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }

  if (!isset($_SESSION['loginUsername'])) {
    header("Location: $loginPageURL");
    exit();
  }

 ?>
