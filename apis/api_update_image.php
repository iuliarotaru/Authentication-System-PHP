<?php
// ----------------------------------------------------------
// Backend Update validation
// Validation image
if ($_FILES['my_updated_image']['error']) {
    http_response_code(400);
    echo 'you have to upload a picture';
    exit();
}
$valid_extensions = ['png', 'jpg', 'jpeg', 'gif'];
$image_size = $_FILES['my_updated_image']['size'];
$image_type = mime_content_type($_FILES['my_updated_image']['tmp_name']); // image/png
$extension = strrchr($image_type, '/'); // /png ... /tmp ... /jpg
$extension = ltrim($extension, '/'); // png ... jpg ... plain
if (!in_array($extension, $valid_extensions)) {
    $error_message = "Upload a valid image";
    http_response_code(400);
    echo $error_message;
    exit();
}
if ($image_size > 2000000) {
    $error_message = "Image size exceeds 2 MB";
    http_response_code(400); //header
    echo $error_message;
    exit();
}
// ----------------------------------------------------------
// Connect to the db and update image
require_once(__DIR__ . '/../db/db.php');

try {
    // Image upload
    $random_image_name = bin2hex(random_bytes(16)) . ".$extension";
    move_uploaded_file($_FILES['my_updated_image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . "/images/" . $random_image_name);
    session_start();
    $q = $db->prepare('UPDATE users SET image_path=:image_path WHERE uuid=:uuid');
    $q->bindValue(':uuid', $_SESSION['uuid']);
    $q->bindValue(':image_path', $random_image_name);
    $q->execute();
    if (!$q->rowCount()) {
        $error_message = 'Image could not be updated';
        http_response_code(400);
        echo $error_message;
        exit();
    }
    http_response_code(200);
    exit();
} catch (PDOException $ex) {
    echo $ex->getMessage();
}
