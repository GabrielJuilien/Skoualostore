<?php
session_start();

//Connecting to database as 'site' user
try {
  $bdd = new PDO('mysql:host=localhost;dbname=juilien', 'site', 'bT49SdUkgl8aH8ny');
}
catch (PDOException $Exception) {
  echo "Couldn't connect to database.\n</html>";
  exit();
}



?>
<head>
  <title>Skoual'store</title>
  <link rel="stylesheet" href="css/style.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
