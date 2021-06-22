<?php
//Check if there is a session already
session_start();
if ($_SESSION['uuid']) {
    header('Location: /admin');
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
<div class="login_main">
    <div class="login_title">
        <h1>LOGIN</h1>
    </div>
    <form action="/login" id="login_form" method="POST">
        <!-- onsubmit="return validate()" -->
        <div class="form_element">
            <label for="user_email">Email</label>
            <input name="user_email" id="user_email" type="text" placeholder="email" data-validate="email" onclick="clear_error()">
        </div>
        <div class="form_element">
            <label for="user_password">Password</label>
            <input name="user_password" id="user_password" type="password" placeholder="password" data-validate="str" data-min="8" data-max="50" onclick="clear_error()">
        </div>
        <div class="forgot_password">
            <a href="/forgot-password">Forgot password?</a>
        </div>
        <button type="submit" id="login_button">Login</button>
    </form>
</div>


<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_bottom.php');
?>