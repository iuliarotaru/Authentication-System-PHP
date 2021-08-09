<?php
//Check if there is a session already
session_start();
if (isset($_SESSION['uuid'])) {
    header('Location: /customer');
    exit();
}
?>

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_top.php');
?>

<?php
if ($_GET['error']) {
?>
    <div class="display_error">
        <?= $_GET['error'] ?>
    </div>
<?php
}
if ($_GET['notification']) {
?>
    <div class="display_notification">
        <?= $_GET['notification'] ?>
    </div>
<?php
}
?>
<div class="forgot_password_main">
    <div class="forgot_password_title">
        <h1>Forgot Password</h1>
    </div>
    <form action="/forgot-password" id="forgot_password_form" method="POST" onsubmit="return validate()">
        <div class="form_element">
            <label for="user_email">Email</label>
            <input name="user_email" id="user_email" type="text" placeholder="email" data-validate="email">
        </div>
        <button type="submit" class="forgot_password_button">Send email</button>
    </form>
</div>

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_bottom.php');
?>