<?php
// ----------------------------------------------------------
// Backend Login validation

//Validate email
if (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
    $error_message = 'Invalid email';
    header("Location: /login?error=$error_message");
    exit();
}
//Validate password - at least 8 characters and max 50 characters
if (strlen($_POST['user_password']) < 8) {
    $error_message = 'Password must be at least 2 characters';
    header("Location: /login?error=$error_message");
    exit();
}
if (strlen($_POST['user_password']) > 50) {
    $error_message = 'Password must be at maximum 5 characters';
    header("Location: /login?error=$error_message");
    exit();
}

// ----------------------------------------------------------
// Connect to db, check if the user exists, start session
require_once(__DIR__ . '/../db/db.php');

try {
    $q = $db->prepare('SELECT * FROM users WHERE email = :email');
    $q->bindValue(':email', $_POST['user_email']);
    $q->execute();
    $user = $q->fetch();

    //If the user is not found in the database
    if (!$user) {
        $error_message = 'Your email or password are not correct. Try again';
        header("Location: /login?error=$error_message");
        exit();
    }

    //If the user is found in the database

    //If user is not active
    if ($user->active == 0) {
        $error_message = 'Your account has been deactivated';
        header("Location: /login?error=$error_message");
        exit();
    }
    //If user is not verified
    if ($user->verified == 0) {
        $error_message = 'You have to verify your account first';
        header("Location: /login?error=$error_message");
        exit();
    }

    //If password is incorrect
    if (!password_verify($_POST['user_password'], $user->password)) {
        $error_message = 'Your email or password are not correct';
        header("Location: /login?error=$error_message");
        exit();
    }

    //Logged in successfully
    session_start();
    $_SESSION['uuid'] = $user->uuid;
    $_SESSION['role'] = $user->user_role;
    if ($user->user_role == 1) {
        header('Location: /customer');
        exit();
    } else if ($user->user_role == 2) {
        header('Location: /therapist');
        exit();
    }
} catch (PDOException $ex) {
    echo $ex;
}
