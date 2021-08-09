<?php
session_start();
if (!isset($_SESSION['uuid'])) {
    $error_message = 'Unauthorized';
    http_response_code(400);
    echo $error_message;
    exit();
}
if (!isset($post_id)) {
    http_response_code(400);
    echo 'Invalid id';
    exit();
}
// if (!ctype_digit($post_id)) {
//     http_response_code(400);
//     echo 'Invalid id';
//     exit();
// }
if ($like_or_dislike != 0 && $like_or_dislike != 1) {
    http_response_code(400);
    echo 'Invalid like or dislike';
    exit();
}
require_once(__DIR__ . '/../db/db.php');
// ----------------------------------------------------------
// Connect to the db insert or delete a row
try {
    if ($like_or_dislike == 1) {
        $q = $db->prepare('INSERT INTO likes VALUES(DEFAULT, :user_id, :post_id)');
        $q->bindValue(':user_id', $_SESSION['uuid']);
        $q->bindValue(':post_id', $post_id);
        $q->execute();

        if (!$q->rowCount()) {
            http_response_code(400);
            echo 'Error liking the post';
            exit();
        }
        http_response_code(200);
        exit();
    } else if ($like_or_dislike == 0) {
        $q = $db->prepare('DELETE FROM likes WHERE user_id = :user_id AND post_id = :post_id');
        $q->bindValue(':user_id', $_SESSION['uuid']);
        $q->bindValue(':post_id', $post_id);
        $q->execute();
        if (!$q->rowCount()) {
            http_response_code(400);
            echo 'Error disliking the post';
            exit();
        }
        http_response_code(200);
        exit();
    }
} catch (PDOException $ex) {
    echo $ex->getMessage();
}
