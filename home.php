<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Clicker Communities</title>
        <link href="globals.css" rel="stylesheet">
        <link href="home.css" rel="stylesheet">
    </head>
    <body>
        <?php
            // Start the PHP session and include the config file
            session_start();
            require_once "config.php";

            // If user is logged in, redirect to the dashboard
            if (logged_in()) {
                header('Location: dashboard.php');
            }
            ?>
        <header>
            <a href="dashboard.php" class="header-link underline">Dashboard</a>
            <a href="login.php" class="header-link underline">Log in</a>
            <a href="signup.php" class="header-button">Sign up</a>
        </header>

    </body>
</html>