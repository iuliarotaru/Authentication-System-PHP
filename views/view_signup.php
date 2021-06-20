<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_top.php');
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

<form id="signup_form" enctype="multipart/form-data">
    <h1>SIGNUP</h1>
    <!-- action="/signup" method="POST" onsubmit="return validate();" -->
    <div>
        <div>Upload an image</div>
        <img src="../image_placeholder.jpeg" alt="" id="image_placeholder" onclick="triggerClick()">
        <input type="file" name="my_profile_image" id="my_profile_image" onchange="showFile()" accept="image/*" data-validate="img" class="hidden">
    </div>
    <div>
        <div>Name <span class="soft">Minimum 2 maximum 20 characters</span></div>
        <input name="user_name" type="text" placeholder="name" onclick="clear_error()" maxlength="20" data-validate="str" data-min="2" data-max="20">
    </div>
    <div>
        <div>Last name <span class="soft">Minimum 2 maximum 20 characters</span></div>
        <input name="user_last_name" type="text" placeholder="last name" onclick="clear_error()" maxlength="20" data-validate="str" data-min="2" data-max="20">
    </div>
    <div>
        <div>Email <span class="soft">enter a valid email</span></div>
        <input name="user_email" type="email" placeholder="email" onclick="clear_error()" data-validate="email">
    </div>
    <div>
        <div>Phone <span class="soft">8 digits</span></div>
        <input name="user_phone" type="tel" placeholder="phone number" onclick="clear_error()" data-validate="int" data-min="10000000 " data-max="99999999">
    </div>
    <div>
        <div>Password <span class="soft">Minimum 8 maximum 50</span></div>
        <input id="password1" name="user_password" type="password" placeholder="password" onclick="clear_error()" data-validate="str" data-min="8" data-max="50">
    </div>
    <div>
        <div>Confirm password <span class="soft">enter password again</span></div>
        <input id="password2" name="user_confirm_password" type="password" placeholder="confirm password" onclick="clear_error()" data-validate="confirm-p">
    </div>
    <button type="submit">Sign up</button>
</form>

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_bottom.php');
?>