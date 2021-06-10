<?php
require_once(__DIR__.'/db.php');

try{
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
  $q = $db->prepare('DROP TABLE IF EXISTS users');
  $q->execute();
  $q = $db->prepare('CREATE TABLE users(
    uuid         VARCHAR(32) UNIQUE,
    name         TEXT,
    last_name    TEXT,
    email        TEXT UNIQUE,
    phone        TEXT UNIQUE,
    password     TEXT,
    active       INTEGER,
    token        VARCHAR(32),
    verified     INT,
    image_path   VARCHAR(255) NOT NULL,
    PRIMARY KEY(uuid)
  )');
  $q->execute();
  echo 'Table created successfully';
}catch(PDOException $ex){
echo 'Error'.$ex->getMessage();
exit();}