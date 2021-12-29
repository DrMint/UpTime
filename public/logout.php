<?php
  require($_SERVER['DOCUMENT_ROOT'] . '/../session.php');
  session_destroy();
  header("Refresh:0");
 ?>
