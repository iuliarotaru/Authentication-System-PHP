<?php
require_once(__DIR__.'/db.php');

try{
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $q = $db->prepare('DROP TABLE IF EXISTS user_role');
    $q->execute();
    $q = $db->prepare('CREATE TABLE user_role(
      id_user_role SERIAL,
      role_name    TEXT,
      PRIMARY KEY(id_user_role))'
    );
    $q->execute();
    echo 'Table created successfully';
  }catch(PDOException $ex){
  echo 'Error'.$ex->getMessage();
  exit();}