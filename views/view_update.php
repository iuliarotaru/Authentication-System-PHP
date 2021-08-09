<?php
//Check if the user is logged in
session_start();
if (!$_SESSION['uuid']) {
  header('Location: /login');
  exit();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_top.php');
require_once(__DIR__ . '/../db/db.php');
try {
  $q = $db->prepare('SELECT name, last_name, email, phone, image_path FROM users WHERE uuid = :user_uuid');
  $q->bindValue(':user_uuid', $_SESSION['uuid']);
  $q->execute();
  $user = $q->fetch();
  if (!$user) {
    header('Location: /login');
    exit();
  }

?>
  <div class="update_main">
    <div id="update_image">
      <img src="/images/<?php echo $user->image_path ?>" id="image_placeholder" />
      <input type="file" name="my_profile_image" id="my_profile_image" onchange="updatePicture()" accept="image/*" data-validate="img" class="hidden">
      <button onclick="triggerClick()">Update picture</button>
    </div>
    <form id="update_form">
      <div class="form_element">
        <label for="user_name">Name</label>
        <input name="user_name" id="user_name" type="text" value="<?php echo $user->name ?>" onclick="clearError()" maxlength="20" data-validate="str" data-min="2" data-max="20">
      </div>
      <div class="form_element">
        <label for="user_last_name">Last name</label>
        <input name="user_last_name" id="user_last_name" type="text" value="<?php echo $user->last_name ?>" onclick="clearError()" maxlength="20" data-validate="str" data-min="2" data-max="20">
      </div>
      <div class="form_element">
        <label for="user_email">Email</label>
        <input name="user_email" id="user_email" type="email" value="<?php echo $user->email ?>" onclick="clearError()" data-validate="email">
      </div>
      <div class="form_element">
        <label for="user_phone">Phone</label>
        <input name="user_phone" id="user_phone" type="tel" value="<?php echo $user->phone ?>" onclick="clearError()" data-validate="int" data-min="10000000 " data-max="99999999">
      </div>
      <button type="submit" class="submit_button">Update profile</button>
    </form>
  </div>
<?php
} catch (PDOException $ex) {
  echo $ex;
}
?>
<script src="../javascript/general.js"></script>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_bottom.php');
?>