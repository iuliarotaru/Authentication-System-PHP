<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/views/view_top.php');

if (isset($display_message)) {
    ?>
    <div>
    ERROR <?= urldecode($display_message) ?>
    </div>
    <?php
}
//checks if the token isset 
if ( ! isset($token)) {
$display_error = "Please check your email again";
header("Location: /login/error/$display_error");
exit();
}

//connect to db
//check if the token is in the db
require_once(__DIR__.'/../db/db.php');

try {
    $q = $db->prepare('SELECT * FROM password_recovery WHERE token = :token');
    $q->bindValue(':token', $token);
    $q->execute();
    $user = $q->fetch();

   //if it doesn't exist in database, error message
   if ( ! $user) {
    $display_error = 'Your token is invalid or expired';
    header("Location: /login/error/$display_error");
    exit();
   }
   
   //if it exists but the token is expired, then error message
   if ($user->expire < date("U")) {
       $display_error = 'Your token has expired';
       header("Location:/login/error/$display_error");
       exit();
   }

   ?>
     
    <form action="/recover-password" method="POST" onsubmit="return validate()">
    <input name="user_new_password" type="password" placeholder="New password" data-validate="str" data-min="8" data-max="50">
    <input name="user_confirm_password" type="password" placeholder="Confirm password" data-validate="str" data-min="8" data-max="50">
    <input name="token" type="hidden" value=<?= $token ?> >
    <button type="submit">Reset password</button>
    </form>

   <?php


}catch(PDOException $ex) {
    echo $ex;}

    require_once($_SERVER['DOCUMENT_ROOT'].'/views/view_bottom.php');

?>


<!-- //redirect to view with password, confirm password, hidden input with the token

//on submit redirect to a bridge that checks if the passwords match,
//if they are verified, then update the table in users that has the same uuid
//with the new password -->