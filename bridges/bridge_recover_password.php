<?php
// ----------------------------------------------------------
// Backend Recover password validation

if (strlen($_POST['user_new_password']) < 8) {
    $display_message = "Your password should have minimum 8 characters";
    header("Location: /login?error=$display_message"); //change location
    exit();
}
if (strlen($_POST['user_new_password']) > 50) {
    $display_message = "Your password should have maximum 50 characters";
    header("Location: /login?error=$display_message"); //change location
    exit();
}
// ----------------------------------------------------------
// Validate if the passwords are the same
if ($_POST['user_confirm_password'] != $_POST['user_new_password']) {
    $display_message = "Your passwords should match";
    header("Location: /login?error=$display_message"); //change location
    exit();
}

// ----------------------------------------------------------
// Connect to the db and update password
require_once(__DIR__ . '/../db/db.php');


try {
    $token = $_POST['token'];

    $q = $db->prepare('SELECT * FROM password_recovery WHERE token = :token');
    $q->bindValue(':token', $token);
    $q->execute();
    $user = $q->fetch();

    //if it doesn't exist in database, error message
    if (!$user) {
        $display_error = 'Invalid token';
        header("Location: /login?error=$display_error");
        exit();
    }

    $user_uuid = $user->uuid;

    $q = $db->prepare('UPDATE users SET password=:password WHERE uuid=:uuid');
    $q->bindValue(':uuid', $user_uuid);
    $q->bindValue(':password', password_hash($_POST['user_new_password'], PASSWORD_DEFAULT));
    $q->execute();

    if (!$q->rowCount()) {
        header('Location: /signup');
        exit();
    }

    $q = $db->prepare('DELETE FROM password_recovery WHERE uuid = :uuid');
    $q->bindValue(':uuid', $user_uuid);
    $q->execute();
    $user = $q->fetch();

    $display_notification = "Your password has successfully been changed";
    header("Location:/login?notification=$display_notification");
    exit();
} catch (PDOException $ex) {
    echo $ex->getMessage();
}
