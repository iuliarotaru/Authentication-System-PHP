<?php
//Check if user session is set
session_start();
if (isset($_SESSION['uuid'])) {
    header('Location: /customer');
    exit();
}
?>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_top.php');
?>
<!-- Display messages if exist -->
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
<!-- Login form -->
<div class="login_main">
    <div class="login_title">
        <h1>LOGIN</h1>
    </div>
    <form action="/login" id="login_form" method="POST" onsubmit="return validate()">
        <div class="form_element">
            <label for="user_email">Email</label>
            <input name="user_email" id="user_email" type="text" placeholder="email" data-validate="email" onclick="clearError()">
        </div>
        <div class="form_element">
            <label for="user_password">Password</label>
            <input name="user_password" id="user_password" type="password" placeholder="password" data-validate="str" data-min="8" data-max="50" onclick="clearError()">
        </div>
        <div class="forgot_password">
            <a href="/forgot-password">Forgot password?</a>
        </div>
        <button type="submit" id="login_button">Login</button>
    </form>
</div>
<script src="../javascript/general.js"></script>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_bottom.php');
?>