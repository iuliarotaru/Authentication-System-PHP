<?php
// ----------------------------------------------------------
// Backend Login validation

//Validate email
if (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
    $error_message = 'Invalid email';
    header("Location: /forgot-password?error=$error_message");
    exit();
}
// ----------------------------------------------------------
// Connect to db, check if the user exists
require_once(__DIR__ . '/../db/db.php');
require_once(__DIR__ . '/../send_emails/send_recovery_email.php');

try {
    $q = $db->prepare('SELECT * FROM users WHERE email = :email');
    $q->bindValue(':email', $_POST['user_email']);
    $q->execute();
    $user = $q->fetch();

    //If the user is not found in the database
    if (!$user) {
        $error_message = 'Your email is incorrect. Try again';
        header("Location: /forgot-password?error=$error_message");
        exit();
    }

    //if it's found, grab the email and the id
    $email = $user->email;
    $uuid = $user->uuid;


    $q = $db->prepare('DELETE FROM password_recovery WHERE uuid = :uuid');
    $q->bindValue(':uuid', $uuid);
    $q->execute();
    $user = $q->fetch();

    $expire = date("U") + 1800;
    echo $expire;
    $token = bin2hex(random_bytes(16));

    $q = $db->prepare('INSERT INTO password_recovery VALUES(DEFAULT, :email, :token, :expire, :uuid)');
    // insert also uuid - foreign key
    $q->bindValue(':email', $email);
    $q->bindValue(':token', $token);
    $q->bindValue(':expire', $expire);
    $q->bindValue(':uuid', $uuid);
    $q->execute();

    if (!$q->rowCount()) {
        header('Location: /forgot-password');
        exit();
    }

    $url = 'http://' . $_SERVER['HTTP_HOST'] . "/verify-recover/$token";
    // $url = gethostname()."/verify/$token";
    send_recovery_email($email, $url);
    header("Location: /login");
    exit();
} catch (PDOException $ex) {
    echo $ex;
}
