<?php
// ----------------------------------------------------------
// Backend Update validation
// Validation image
if ($_FILES['my_profile_image']['error']) {
    http_response_code(400);
    echo 'you have to upload a picture';
    exit();
}
$valid_extensions = ['png', 'jpg', 'jpeg', 'gif'];
$image_type = mime_content_type($_FILES['my_profile_image']['tmp_name']); // image/png
$extension = strrchr( $image_type , '/'); // /png ... /tmp ... /jpg
$extension = ltrim($extension, '/'); // png ... jpg ... plain
if( ! in_array($extension, $valid_extensions) ){
    $error_message = "Upload a valid image";
    http_response_code(400);
    echo $error_message;
    exit();
}

// Validate name - min 2 max 20
if (strlen($_POST['user_name']) < 2 ) {
    $error_message = 'Name must be at least 2 characters';
    http_response_code(400);
    echo $error_message;
    exit();
}
if (strlen($_POST['user_name']) > 20 ) {
    $error_message = 'Name must be maximum 20 characters';
    http_response_code(400);
    echo $error_message;
    // header("Location: /signup/error/$error_message");
    exit();
}

// Validate last name - min 2 max 20
if (strlen($_POST['user_last_name']) < 2 ) {
    $error_message = 'Last name must be at least 2 characters';
    http_response_code(400);
    echo $error_message;
    // header("Location: /signup/error/$error_message");
    exit();
}
if (strlen($_POST['user_last_name']) > 20 ) {
    $error_message = 'Last name must be maximum 20 characters';
    http_response_code(400);
    echo $error_message;
    // header("Location: /signup/error/$error_message");
    exit();
}

// Validate phone - 8 digits cannot start with 0
if ( ! preg_match('/^[1-9]\d{7}$/', $_POST['user_phone'] )) {
    $error_message = 'Phone number must have 8 digits and not start with 0';
    http_response_code(400);
    echo $error_message;
    // header("Location: /signup/error/$error_message");
    exit();
}

// Validate email - must be a valid email
if ( ! preg_match('/^[a-z0-9]+[\._]?[a-z0-9]+[\._]?[a-z0-9]+[@]\w+[.]\w{2,3}$/', $_POST['user_email'])) {
    $error_message = 'Invalid email';
    http_response_code(400);
    echo $error_message;
    // header("Location: /signup/error/$error_message");
    exit();
}
// ----------------------------------------------------------
// Connect to the db and update values
require_once(__DIR__.'/../db/db.php');
require_once(__DIR__.'/../views/view_email.php');

try {
$name = $_POST['user_name'];
$last_name = $_POST['user_last_name'];
$phone = $_POST['user_phone'];
$email = $_POST['user_email'];

// Image upload
$random_image_name = bin2hex(random_bytes(16)).".$extension";
move_uploaded_file($_FILES['my_profile_image']['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/images/".$random_image_name);
session_start();
// http_response_code(400);
// echo $_SESSION['uuid'];
// exit();
$q = $db->prepare('UPDATE users SET image_path=:image_path, name=:name, last_name=:last_name, email=:email, phone=:phone WHERE uuid=:uuid');
$q->bindValue(':uuid', $_SESSION['uuid']);
$q->bindValue(':image_path', $random_image_name);
$q->bindValue(':name', $name);
$q->bindValue(':last_name', $last_name);
$q->bindValue(':email', $email);
$q->bindValue(':phone', $phone);
$q->execute();
if (! $q->rowCount()) {
    header('Location: /update');
    exit();
}
http_response_code(200);
exit();

}catch(PDOException $ex) {
echo $ex->getMessage();
}

