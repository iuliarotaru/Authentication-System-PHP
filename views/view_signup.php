<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_top.php');
?>

<div class="signup_main">
    <div class="signup_title">
        <h1>SIGNUP</h1>
    </div>

    <form id="signup_form" enctype="multipart/form-data">
        <div class="form_element">
            <div>Upload an image</div>
            <div class="upload_image">
                <img src="../assets/image_placeholder.jpeg" alt="upload image placeholder" id="image_placeholder" onclick="triggerClick()">
                <input type="file" name="my_profile_image" id="my_profile_image" onchange="showFile()" accept="image/*" data-validate="img" class="hidden">
            </div>
        </div>
        <div class="form_element">
            <label for="user_name">Name <span class="soft">Minimum 2 maximum 20 characters</span></label>
            <input name="user_name" id="user_name" type="text" placeholder="name" onclick="clearError()" maxlength="20" data-validate="str" data-min="2" data-max="20">
        </div>
        <div class="form_element">
            <label for="user_last_name">Last name <span class="soft">Minimum 2 maximum 20 characters</span></label>
            <input name="user_last_name" id="user_last_name" type="text" placeholder="last name" onclick="clearError()" maxlength="20" data-validate="str" data-min="2" data-max="20">
        </div>
        <div class="form_element">
            <label for="user_email">Email <span class="soft">enter a valid email</span></label>
            <input name="user_email" id="user_email" type="email" placeholder="email" onclick="clearError()" data-validate="email">
        </div>
        <div class="form_element">
            <label for="user_phone">Phone <span class="soft">8 digits</span></label>
            <input name="user_phone" id="user_phone" type="tel" placeholder="phone number" onclick="clearError()" data-validate="int" data-min="10000000 " data-max="99999999">
        </div>
        <div class="form_element">
            <label for="password1">Password <span class="soft">Minimum 8 maximum 50</span></label>
            <input id="password1" name="user_password" type="password" placeholder="password" onclick="clearError()" data-validate="str" data-min="8" data-max="50">
        </div>
        <div class="form_element">
            <label for="password2">Confirm password <span class="soft">enter password again</span></label>
            <input id="password2" name="user_confirm_password" type="password" placeholder="confirm password" onclick="clearError()" data-validate="confirm-p">
        </div>
        <button type="submit" class="signup_button">Sign up</button>
    </form>
</div>

<script src="../javascript/general.js"></script>

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_bottom.php');
?>