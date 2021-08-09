<?php
//Check if the therapist is logged in
session_start();
if (!isset($_SESSION['uuid'])) {
    $error_message = 'Unauthorized';
    http_response_code(400);
    echo $error_message;
    exit();
}
if ($_SESSION['role'] != 2) {
    $error_message = 'Unauthorized';
    http_response_code(400);
    echo $error_message;
    exit();
}
require_once(__DIR__ . '/../db/db.php');
// ----------------------------------------------------------
// Connect to the db and delete user
require_once(__DIR__ . '/../send_emails/send_block_email.php');

try {
    $q = $db->prepare('SELECT * FROM users WHERE uuid=:user_uuid');
    $q->bindValue(':user_uuid', $user_id);
    $q->execute();
    $user = $q->fetch();
    if (!$user) {
        $error_message = 'User does not exist';
        http_response_code(400);
        echo $error_message;
        exit();
    }

    $email = $user->email;

    $q = $db->prepare('UPDATE users
    SET active=:user_active
    WHERE uuid=:user_uuid');
    $q->bindValue(':user_active', 0);
    $q->bindValue(':user_uuid', $user_id);
    $q->execute();

    if (!$q->rowCount()) {
        $error_message = 'User could not be blocked';
        http_response_code(400);
        echo $error_message;
        exit();
    }
    send_email($email);
} catch (PDOException $ex) {
    echo $ex->getMessage();
}
