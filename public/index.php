<?php
  require('../session.php');
  require('../fetch.php');
  require('../io.php');
  $userdataPath = $_SERVER['DOCUMENT_ROOT'] . '/../userdata/' . $_SESSION['loginUsername'] . '/';
  $configPath = $userdataPath . '/config.json';
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">

  <head>

    <?php
      $title = getPageTitle($configPath);
      if ($title != '') {
        echo "<title>$title</title>";
      }
     ?>

    <meta charset="UTF-8">
    <meta name="viewport" content="viewport-fit=cover, initial-scale=1">
    <meta name="theme-color" content="#000">
    <link rel="shortcut icon" type="image/png" href="img/logo192.png"/>
    <link rel="apple-touch-icon" href="img/logo192.png"/>
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="global.css">
    <meta http-equiv="refresh" content="300" />

  </head>

  <body>
    <?php

      if (isset($_GET['ssl'])) {
        // Imports
        require('../testSSL.php');
        echo '<link rel="stylesheet" type="text/css" href="testSSL.css">';
        generateWebPageSSL(retrieveSSLData($userdataPath, $_GET['ssl']), convertURL($_GET['ssl']));

      } elseif (isset($_GET['web'])) {
        // Imports
        require('../lighthouse.php');
        echo '<link rel="stylesheet" type="text/css" href="lighthouse.css">';
        generateWebPageLH(retrieveLHData($userdataPath, $_GET['web']));

      } else {
        generateWebPageMonitors($configPath, $userdataPath);
      }

      echo '<div id="sidePanel">';
      echo    '<p id="closePanel" onclick="closeSidePanel()">X</p>';
      echo    '<p id="panelTitle"></p>';
      echo    '<p id="panelSeverity"></p>';
      echo    '<h3>Description</h3>';
      echo    '<p id="panelDescr"></p>';
      echo    '<h3 id="panelAdviceTitle">Advice</h3>';
      echo    '<p id="panelAdvice"></p>';
      echo '</div>';

    ?>


  </body>

  <script src="sidePanel.js" charset="utf-8"></script>

</html>
