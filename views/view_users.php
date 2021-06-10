<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/views/view_top.php');

// ----------------------------------------------------------
// Connect to db and fetch users
require_once(__DIR__.'/../db/db.php');

try {
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$q = $db->prepare('SELECT * FROM users ORDER by phone');
$q->execute();
$users = $q->fetchAll();
echo '<div id="users">';

foreach($users as $user) {
    unset($user['password']);
?>

<div class="user">
<div> NAME: <?= $user['name']?></div>
<div> LAST NAME: <?= $user['last_name'] ?></div>
<div> EMAIL: <?= $user['email'] ?></div>
<div> PHONE: <?= $user['phone'] ?></div>
</div>

<?php
}
echo '</div>'; 
}catch(PDOException $ex) {
echo $ex;
}



require_once($_SERVER['DOCUMENT_ROOT'].'/views/view_bottom.php');
?>