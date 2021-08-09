<?php
session_start();
if (!isset($_SESSION['uuid'])) {
    header('Location: /login');
    exit();
}

require_once(__DIR__ . '/../db/db.php');
try {
    $q = $db->prepare('UPDATE users
SET active=:user_active
WHERE uuid=:user_uuid');
    $q->bindValue(':user_active', 0);
    $q->bindValue(':user_uuid', $_SESSION['uuid']);
    $q->execute();
    if (!$q->rowCount()) {
        header('Location: /customer');
        exit();
    }
    session_destroy();
    header('Location: /login');
    exit();
} catch (PDOException $ex) {
    echo $ex;
}
