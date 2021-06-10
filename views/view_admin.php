 <?php
//Check if the user is logged in
session_start();
if(!$_SESSION['uuid']) {
header('Location: /login');
exit(); }

require_once($_SERVER['DOCUMENT_ROOT'].'/views/view_top.php');
require_once(__DIR__.'/../db/db.php');

try{
  $q = $db->prepare('SELECT * FROM users WHERE uuid = :user_uuid');
  $q->bindValue(':user_uuid', $_SESSION['uuid']);
  $q->execute();
  $user = $q->fetch();
  if( ! $user ){
    header('Location: /login');
    exit();
  }
  ?>
  <h1>Hi there <?php echo "$user->name"?>!Welcome</h1>
  <a href="/logout">Log out</a>
  <a href="/delete">Delete account</a> 
  <a href="/update">Profile information</a> 

  <?php
}catch(PDOException $ex){
  echo $ex;
}

require_once($_SERVER['DOCUMENT_ROOT'].'/views/view_bottom.php');
?>