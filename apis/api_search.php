<?php
//Validate
if (!isset($_POST['search_for'])) {
    $error_message = 'Could not display results';
    http_response_code(400);
    echo $error_message;
    exit();
}
if (strlen($_POST['search_for']) < 2) {
    $error_message = 'Type at least 2 characters';
    http_response_code(400);
    echo $error_message;
    exit();
}
if (strlen($_POST['search_for']) > 20) {
    $error_message = 'You cannot type more than 20 characters';
    http_response_code(400);
    echo $error_message;
    exit();
}

// require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_top.php');
require_once(__DIR__ . '/../db/db.php');
try {
    $q = $db->prepare('SELECT uuid, name, last_name, email, phone, active, image_path FROM users WHERE name LIKE :name LIMIT 20');
    $q->bindValue(':name', '%' . trim($_POST['search_for']) . '%'); //find the string that matches the letters written
    $q->execute();
    $users = $q->fetchAll();

    header("Content-Type: application/json");
    echo json_encode($users);
    exit();
} catch (PDOException $ex) {
    http_response_code(400);
    echo $ex->getMessage();
    exit();
}
