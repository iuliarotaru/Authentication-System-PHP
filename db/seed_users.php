<?php
require_once(__DIR__ . '/db.php');
require_once(__DIR__ . '/../faker/autoload.php');

try {
  // require_once "{$_SERVER['DOCUMENT_ROOT']}/faker/autoload.php";
  $faker = Faker\Factory::create();
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $q = $db->prepare("INSERT INTO users VALUES (:user_uuid, :user_name, :user_last_name, :user_email, :user_phone, :user_password, :user_active, :user_token, :user_verified, :user_image_path, :user_role)");
  for ($i = 0; $i < 15; $i++) {
    $q->bindValue(':user_uuid', bin2hex(random_bytes(16)));
    $q->bindValue(':user_name', $faker->firstName());
    $q->bindValue(':user_last_name', $faker->lastName());
    $q->bindValue(':user_email', $faker->email());
    $q->bindValue(':user_phone', mt_rand(10000000, 99999999));
    $q->bindValue(':user_password', password_hash($faker->password(), PASSWORD_DEFAULT));
    $q->bindValue(':user_active', 1);
    $q->bindValue(':user_token', bin2hex(random_bytes(16)));
    $q->bindValue(':user_verified', 0);
    $q->bindValue(':user_image_path', 'default.png');
    $q->bindValue(':user_role', 1);
    $q->execute();
  }
} catch (PDOException $ex) {
  echo 'Error:' . $ex->getMessage();
  exit();
}
