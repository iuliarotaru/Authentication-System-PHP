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

    <form action="/forgot-password" method="POST" onsubmit="return validate()">
    <input name="user_email" type="text" placeholder="email" data-validate="email">
    <button type="submit">Send email</button>
    </form>


<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/views/view_bottom.php');
?>