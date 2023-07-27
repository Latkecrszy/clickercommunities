<!DOCTYPE html>
<?php
// Start session and require config file
session_start();
require_once "config.php";

// Validate inputs
if (logged_in() && isset($_GET['coconuts']) && filter_var($_GET['coconuts'], FILTER_VALIDATE_INT) &&
    isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    // Create and execute SQL to update coconuts
    $sth = DBH->prepare('UPDATE communities SET coconuts=coconuts+:coconuts WHERE id=:community_id');
    $sth->bindValue(':community_id', $_GET['id']);
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

