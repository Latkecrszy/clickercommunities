<!DOCTYPE html>
<?php
session_start();
require_once "config.php";
$dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
if (!logged_in()) {
    header('Location: login.php');
} else if (!(isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT))) {
    header('Location: dashboard.php');
}
$sth = DBH->prepare("SELECT * FROM communities WHERE id=:id AND type='public'");
$sth->bindValue(':id', $_GET['id']);
$sth->execute();
$community = $sth->fetch();
$sth2 = DBH->prepare("");
if ($community['admin_id'] == $_SESSION['admin_id']) {
    $admin = true;
} else {
    $admin = false;
}
?>
<html lang="en">
    <head>
        <title>Community</title>
        <script>
            let admin = <?=json_encode($admin, JSON_HEX_TAG);?>
            console.log(admin)
            console.log(typeof admin)
        </script>
        <link href="globals.css">
        <link href="community.css">
        <script src="community.js"></script>
    </head>
    <body>

    </body>
</html>