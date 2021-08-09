<?php
// ----------------------------------------------------------
// Backend Update validation
// Validate name - min 2 max 20
if (strlen($_POST['user_name']) < 2) {
    $error_message = 'Name must be at least 2 characters';
    http_response_code(400);
    echo $error_message;
    exit();
}
if (strlen($_POST['user_name']) > 20) {
    $error_message = 'Name must be maximum 20 characters';
    http_response_code(400);
    echo $error_message;
    exit();
}

// Validate last name - min 2 max 20
if (strlen($_POST['user_last_name']) < 2) {
    $error_message = 'Last name must be at least 2 characters';
    http_response_code(400);
    echo $error_message;
    exit();
}
if (strlen($_POST['user_last_name']) > 20) {
    $error_message = 'Last name must be maximum 20 characters';
    http_response_code(400);
    echo $error_message;
    exit();
}

// Validate phone - 8 digits cannot start with 0
if (!preg_match('/^[1-9]\d{7}$/', $_POST['user_phone'])) {
    $error_message = 'Phone number must have 8 digits and not start with 0';
    http_response_code(400);
    echo $error_message;
    exit();
}

// Validate email - must be a valid email
if (!preg_match('/^[a-z0-9]+[\._]?[a-z0-9]+[\._]?[a-z0-9]+[@]\w+[.]\w{2,3}$/', $_POST['user_email'])) {
    $error_message = 'Invalid email';
    http_response_code(400);
    echo $error_message;
    exit();
}
// ----------------------------------------------------------
// Connect to the db and update values
require_once(__DIR__ . '/../db/db.php');
require_once(__DIR__ . '/../send_emails/send_welcome_email.php');

try {
    $name = $_POST['user_name'];
    $last_name = $_POST['user_last_name'];
    $phone = $_POST['user_phone'];
    $email = $_POST['user_email'];
    session_start();
    $q = $db->prepare('UPDATE users SET name=:name, last_name=:last_name, email=:email, phone=:phone WHERE uuid=:uuid');
    $q->bindValue(':uuid', $_SESSION['uuid']);
    $q->bindValue(':name', $name);
    $q->bindValue(':last_name', $last_name);
    $q->bindValue(':email', $email);
    $q->bindValue(':phone', $phone);
    $q->execute();
    if (!$q->rowCount()) {
        header('Location: /update');
        exit();
    }
    http_response_code(200);
    exit();
} catch (PDOException $ex) {
    echo $ex->getMessage();
}
