<?php
session_start();
if(! isset( $_SESSION['uuid'])){
header('Location: /login');
exit();
}
session_destroy();
$error_message = 'You have been logged out';
header("Location: /login/error/$error_message");
exit();