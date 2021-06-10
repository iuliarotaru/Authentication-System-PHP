<?php
require_once(__DIR__.'/db.php');

try{
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
  $q = $db->prepare('DROP TABLE IF EXISTS password_recovery');
  $q->execute();
  $q = $db->prepare('CREATE TABLE password_recovery(
    email        TEXT UNIQUE,
    token        VARCHAR(32)
  )');
  $q->execute();
  echo 'Table created successfully';
}catch(PDOException $ex){
echo 'Error'.$ex->getMessage();
exit();}