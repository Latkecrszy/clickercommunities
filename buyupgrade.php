<!DOCTYPE html>
<?php
session_start();
require_once "config.php";
$dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
if (logged_in() && isset($_GET['name']) && isset($_GET['community_id']) && isset($_GET['id'])) {
    $sth2 = DBH->prepare("SELECT * FROM purchased WHERE community_id=:community_id AND item_name=:item_name");
    $sth2->bindValue(':community_id', $_GET['community_id']);
    $sth2->bindValue(':item_name', $_GET['name']);
    $sth2->execute();
    if ($sth2->fetch()) {
        $sth = DBH->prepare("UPDATE purchased SET count=count+1 WHERE community_id=:community_id AND item_id=:item_id");
    } else {
        $sth = DBH->prepare("INSERT INTO purchased (`community_id`, `item_id`, `item_name`, `count`) VALUES (:community_id, :item_id, :item_name, 1)");
        $sth->bindValue(':item_name', $_GET['name']);
    }
    $sth->bindValue(':community_id', $_GET['community_id']);
    $sth->bindValue(':item_id', $_GET['id']);

    $sth->execute();
}
?>
<html lang="en">
    <head>
        <title>Buying upgrade...</title>
    </head>
    <body>

    </body>
</html>

