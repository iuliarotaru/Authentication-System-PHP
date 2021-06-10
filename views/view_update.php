<?php
//Check if the user is logged in
session_start();
if(!$_SESSION['uuid']) {
header('Location: /login');
exit(); }

require_once($_SERVER['DOCUMENT_ROOT'].'/views/view_top.php');
require_once(__DIR__.'/../db/db.php');

try{
    $q = $db->prepare('SELECT name, last_name, email, phone FROM users WHERE uuid = :user_uuid');
    $q->bindValue(':user_uuid', $_SESSION['uuid']);
    $q->execute();
    $user = $q->fetch();
    if( ! $user ){
      header('Location: /login');
      exit();
    }
    // $img = $user->image_path;
    // $img_path = "../images/".$img;
    ?>
    
    <form id="update_form">
    <div>
    <input type="file" name="my_profile_image" id="my_profile_image" onchange="showFile()" accept="image/*" data-validate="img">
    </div>
    <div>
    name
    <input name="user_name" type="text" value="<?php echo $user->name ?>" onclick="clear_error()" maxlength="20" data-validate="str" data-min="2" data-max="20">
    </div>
    <div>
    last name
    <input name="user_last_name" type="text" value="<?php echo $user->last_name ?>" onclick="clear_error()" maxlength="20" data-validate="str" data-min="2" data-max="20">
    </div>
    <div>
    email
    <input name="user_email" type="email" value="<?php echo $user->email ?>" onclick="clear_error()" data-validate="email">
    </div>
    <div>
    phone
    <input name="user_phone" type="tel" value="<?php echo $user->phone ?>" onclick="clear_error()" data-validate="int" data-min="10000000 "data-max="99999999">
    </div>
    <button type="submit">Update profile</button>
    </form>
    <?php
  }catch(PDOException $ex){
    echo $ex;
  }
  
  require_once($_SERVER['DOCUMENT_ROOT'].'/views/view_bottom.php');
  ?>