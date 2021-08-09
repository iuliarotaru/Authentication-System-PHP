<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_top.php');

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
//checks if the token isset 
if (!isset($token)) {
    $display_error = "Please check your email again";
    header("Location: /login?error=$display_error");
    exit();
}
//connect to db
//check if the token is in the db
require_once(__DIR__ . '/../db/db.php');

try {
    $q = $db->prepare('SELECT * FROM password_recovery WHERE token = :token');
    $q->bindValue(':token', $token);
    $q->execute();
    $user = $q->fetch();

    //if it doesn't exist in database, error message
    if (!$user) {
        $display_error = 'Your token is invalid or expired';
        header("Location: /login?error=$display_error");
        exit();
    }

    //if it exists but the token is expired, then error message
    if ($user->expire < date("U")) {
        $display_error = 'Your token has expired';
        header("Location:/login?error=$display_error");
        exit();
    }

?>
    <div class="recover_password_main">
        <h1 class="recover_password_title"> Recover password</h1>
        <form action="/recover-password" id="recover_password_form" method="POST" onsubmit="return validate()">
            <div class="form_element">
                <label for="user_new_password">New password</label>
                <input name="user_new_password" id="user_new_password" type="password" placeholder="New password" data-validate="str" data-min="8" data-max="50">
            </div>
            <div class="form_element">
                <label for="user_confirm_password">Confirm password</label>
                <input name="user_confirm_password" id="user_confirm_password" type="password" placeholder="Confirm password" data-validate="str" data-min="8" data-max="50">
            </div>
            <input name="token" type="hidden" value=<?= $token ?>>
            <button type="submit" class="recover_password_button">Reset password</button>
        </form>
    </div>

<?php


} catch (PDOException $ex) {
    echo $ex;
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_bottom.php');

?>