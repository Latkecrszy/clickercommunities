<!DOCTYPE html>
<?php
session_start();
require_once "config.php";
$dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
if (logged_in() && isset($_GET['name']) && strlen($_GET['name']) <= 50 && isset($_GET['description']) && strlen($_GET['description']) <= 250) {
    $sth = DBH->prepare("INSERT INTO communities (`name`, `description`, `type`, `admin_id`, `coconuts`) VALUES (:name, :description, 'public', :admin_id, 0)");
    $sth->bindValue(':name', $_GET['name']);
    $sth->bindValue(':description', $_GET['description']);
    $sth->bindValue(':admin_id', $_SESSION['admin_id']);
    $sth->execute();
    $sth2 = DBH->prepare("SELECT id FROM communities ORDER BY id DESC");
    $sth2->execute();
    $id = $sth2->fetch()['id'];
    $sth3 = DBH->prepare("INSERT INTO membership (`community_id`, `user_id`) VALUES (:community_id, :user_id)");
    $sth3->bindValue(':community_id', $id);
    $sth3->bindValue(':user_id', $_SESSION['admin_id']);
    $sth3->execute();
} else {
    $id = 'error';
}
?>
<html lang="en">
    <head>
        <title>Creating community...</title>
    </head>
    <body><?="$id"?></body>
</html>

