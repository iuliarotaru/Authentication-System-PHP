<?php

if (!isset($token)) {
    $display_error = 'Invalid token';
    header("Location: /login?error=$display_error");
    exit();
}

//verify if the token is in the database
//if exists, check if user is verified or not. If yes, send to login
//with message "your account is already verified". If not, change
//verified from 0 to 1

require_once(__DIR__ . '/../db/db.php');

try {
    $q = $db->prepare('SELECT * FROM users WHERE token = :token');
    $q->bindValue(':token', $token);
    $q->execute();
    $user = $q->fetch();


    //if it doesn't exist in database, error message
    if (!$user) {
        $display_error = 'Invalid token';
        header("Location: /login?error=$display_error");
        exit();
    }

    //if exists, check if user is verified or not. If yes, send to login
    //with message "your account is already verified"  
    if ($user->verified == 1) {
        $display_notification = 'Your account is already verified';
        header("Location: /login?notification=$display_notification");
        exit();
    }

    //If not, change verified from 0 to 1
    $q = $db->prepare('UPDATE users
   SET verified=:user_verify
   WHERE token=:token');
    $q->bindValue(':user_verify', 1);
    $q->bindValue(':token', $token);
    $q->execute();

    $display_notification = 'Your account has been verified';
    header("Location: /login?notification=$display_notification");
    exit();
} catch (PDOException $ex) {
    echo $ex;
}
