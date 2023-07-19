<!DOCTYPE html>
<?php
session_start();
require_once "config.php";
$dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
if (isset($_GET['coconuts']) && filter_var($_GET['coconuts'], FILTER_VALIDATE_INT) && isset($_SESSION['admin_id']) &&
    filter_var($_SESSION['admin_id'], FILTER_VALIDATE_INT)) {
    $sth = $dbh->prepare('UPDATE communities SET coconuts=coconuts+:coconuts WHERE admin_id=:admin_id AND type="personal"');
    $sth->bindValue(':admin_id', $_SESSION['admin_id']);
    $sth->bindValue(':coconuts', $_GET['coconuts']);
    $sth->execute();
}
?>
<html lang="en">
    <head>
        <title>Adding coconuts...</title>
    </head>
    <body>

    </body>
</html>

