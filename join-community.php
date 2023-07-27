<!DOCTYPE html>
<?php
// Start the PHP session and include the config file
session_start();
require_once "config.php";
// Validate inputs
if (logged_in() && isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    // Create and execute SQL query to check if user is already in community
    $sth = DBH -> prepare("SELECT * FROM membership WHERE user_id=:user_id AND community_id=:community_id");
    $sth -> bindValue(':user_id', $_SESSION['admin_id']);
    $sth -> bindValue(':community_id', $_GET['id']);
    $sth -> execute();

    // If user is already in community, redirect to community
    if ($sth->fetch()) {
        header("Location: community.php?id={$_GET['id']}");
    }

    // If not, create and execute SQL query to insert record into membership to add user to community
    $sth2 = DBH -> prepare("INSERT INTO membership (`user_id`, `community_id`) VALUES (:user_id, :community_id)");
    $sth2 -> bindValue(':user_id', $_SESSION['admin_id']);
    $sth2 -> bindValue(':community_id', $_GET['id']);

    // If successful, redirect to community
    if ($sth2->execute()) {
        header("Location: community.php?id={$_GET['id']}");
    }
    // If not, redirect back to dashboard
    else {
        header("Location: dashboard.php");
    }


}
?>
<html lang="en">
    <head>
        <title>Creating community...</title>
    </head>
    <body></body>
</html>

