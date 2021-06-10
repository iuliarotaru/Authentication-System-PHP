<?php
//Check if there is a session already
session_start();
if($_SESSION['uuid']) {
header('Location: /admin');
exit(); }
?> 

<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/views/view_top.php');
?>
    <?php
    if (isset($display_message)) {
    ?>
    <div>
    ERROR <?= urldecode($display_message) ?>
    </div>
    <?php
    }
    ?>

    <form action="/login" method="POST" onsubmit="return validate()">
    <input name="user_email" type="text" placeholder="email" data-validate="email">
    <input name="user_password" type="password" placeholder="password" data-validate="str" data-min="8" data-max="50">
    <button type="submit">login</button>
    <a href="/forgot-password">Forgot password?</a>
    </form>


<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/views/view_bottom.php');
?>