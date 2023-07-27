<!DOCTYPE html>
<?php
// Start session and require config file
session_start();
require_once "config.php";

// Validate inputs
if (logged_in() && isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    // Create and execute SQL to delete community
    $sth = DBH->prepare('DELETE FROM communities WHERE id=:id');
    $sth->bindValue(':id', $_GET['id']);
    $sth->execute();

    // Redirect back to dashboard
    header('Location: dashboard.php');
}
?>
<html lang="en">
<head>
    <title>Deleting community...</title>
</head>
<body>

</body>
</html>

