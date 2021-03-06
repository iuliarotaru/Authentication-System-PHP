<?php
try {
  $sDatabaseUserName = 'root';
  $sDatabasePassword = '';
  $sDatabaseConnection = "mysql:host=localhost; dbname=exam; charset=utf8mb4";
  $aDatabaseOptions = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ // Array with object
  );
  $db = new PDO($sDatabaseConnection, $sDatabaseUserName, $sDatabasePassword, $aDatabaseOptions);
} catch (PDOException $e) {
  echo 'Connectin failed:' . $e->getMessage();
  exit();
}
