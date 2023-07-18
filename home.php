<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Clicker Communities</title>
        <link href="globals.css" rel="stylesheet">
        <link href="home.css" rel="stylesheet">
    </head>
    <body>
        <?php
            require_once "config.php";

            $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
            ?>
        <header>
            <a href="dashboard.php" class="header-link">Dashboard</a>
            <a href="login.php" class="header-link">Log in</a>
            <a href="signup.php" class="header-button">Sign up</a>
        </header>

    </body>
</html>