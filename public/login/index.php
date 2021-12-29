 <!DOCTYPE html>
 <html lang="fr" dir="ltr">

   <head>

     <title></title>
     <meta charset="UTF-8">
     <meta name="viewport" content="viewport-fit=cover, initial-scale=1">
     <meta name="theme-color" content="#000">
     <link rel="shortcut icon" type="image/png" href="../img/logo192.png"/>
     <link rel="apple-touch-icon" href="../img/logo192.png"/>
     <link rel="stylesheet" type="text/css" href="index.css">

   </head>

   <div id="container">
     <div id="title">
       <img src="../img/white.png" alt="">
       <h1>SIGN IN</h1>
     </div>


     <form method="POST" action="." id="myForm">
       <input type="text" name="username" placeholder="Username" value="<?php if (isset($_POST['username'])) echo $_POST['username'] ?>" id="formUsername" autocomplete="username" required>
       <input type="password" name="password" placeholder="Password" id="formPassword" autocomplete="current-password" required>
       <button type="submit" name="submitButton" value="Submit">Sign In</button>
     </form>


      <?php

        if (session_status() == PHP_SESSION_NONE) {
          session_start();
        }

        function verifyAPIKey($username, $password) {
          $csv = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/../database.csv');
          $hashes = explode(PHP_EOL, $csv);
          foreach ($hashes as $hash) {
            $hash = explode(';', $hash);
            if ($hash[0] == $username) {
              $hash = substr($hash[1], 0, 60);
              return password_verify($password, $hash);
            }
          }
          return false;
        }

        if ($_POST['submitButton'] == "Submit") {

          $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
          $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);

          if (verifyAPIKey($username, $password)) {
            $_SESSION['loginUsername'] = $username;
            header('Location: https://up.barillot.net');
          } else {

            unset($_SESSION['loginUsername']);
            echo '<p id="answer">The account name or password that you have entered is incorrect.</p>';
            echo '<style>body{animation: bw 1s;animation-fill-mode: forwards;}#container{animation: shake 0.2s;animation-iteration-count: 2;}</style>';
          }

          //echo '<p>' . $username . ';' . password_hash($password, PASSWORD_DEFAULT) . '</p>';

        }

        ?>

   </div>





   <script type="text/javascript">
      var username = document.getElementById("formUsername");
      if (username.value == '') {
        username.select()
      } else {
        document.getElementById("formPassword").select()
      }

   </script>

 </html>
