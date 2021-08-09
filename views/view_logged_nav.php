<?php
require_once(__DIR__ . '/../db/db.php');
try {
    $q = $db->prepare('SELECT image_path FROM users WHERE uuid = :user_uuid');
    $q->bindValue(':user_uuid', $_SESSION['uuid']);
    $q->execute();
    $user = $q->fetch();
    if (!$user) {
        header('Location: /login');
        exit();
    }
?>
    <div class="header">
        <a href="/customer">
            <img src="/assets/logo.svg" alt="Logo" id="logo"></a>

        <nav id="logged_nav">
            <!-- navigation links -->
            <div id="nav_links" class="hide_nav_links">
                <a href="/update">Profile information</a>
                <a href="/logout">Log out</a>
                <a href="/delete">Delete account</a>
            </div>
            <!-- profile image -->
            <a onclick="toggleHamburger()">
                <img src="/images/<?= $user->image_path ?>" class="logged-user-img" id="logged_image_placeholder" /></a>
        </nav>
    </div>
<?php
} catch (PDOException $ex) {
    echo $ex;
}
?>
<!-- <script src="../javascript/general.js"></script> -->

<!-- // require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_bottom.php'); -->