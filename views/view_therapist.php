<?php
//Check if the therapist is logged in
session_start();
if (!isset($_SESSION['uuid'])) {
    header('Location: /login');
    exit();
}
if ($_SESSION['role'] != 2) {
    header('Location: /admin');
    exit();
}
require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_top.php');
require_once(__DIR__ . '/../db/db.php');

try {
    // $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $q = $db->prepare('SELECT * FROM users WHERE user_role = 1 ORDER BY active DESC');
    $q->execute();
    $users = $q->fetchAll();

?>
    <div class="therapist_main">
        <form onsubmit="return false" id="form_search_for">
            <input type="text" name="search_for" oninput="search()" placeholder="Search">
        </form>
        <?php
        echo '<div id="users">';
        foreach ($users as $user) {
            unset($user->password);
        ?>
            <div class="user" data-id="<?= $user->uuid ?>">

                <div>
                    <img src="/images/<?= $user->image_path ?>" class="user-img" />
                </div>
                <div class="full_name">
                    <span> <?= $user->name ?> <?= $user->last_name ?></span>
                </div>
                <div class="user_card_email"> <b> Email:</b> <?= $user->email ?></div>
                <div class="user_card_phone"> <b> Phone: </b> <?= $user->phone ?></div>
                <?php
                if ($user->active) {
                ?>
                    <button class="active" onclick="block_user('<?= $user->uuid ?>')">Block user</button>
                <?php
                } else {
                ?>
                    <button disabled>Blocked</button>
                <?php
                }
                ?>

            </div>

        <?php
        }
        echo '</div>';
        ?>
        <!-- <a href="/logout">Log out</a> -->
    </div>
<?php
} catch (PDOException $ex) {
    echo $ex;
}



require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_bottom.php');
?>