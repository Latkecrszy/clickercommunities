<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Clicker Communities</title>
        <link href="globals.css" rel="stylesheet">
        <link href="home.css" rel="stylesheet">
    </head>
    <body>
        <?php
            session_start();
            require_once "config.php";
            $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

            if (isset($_SESSION['email']) && isset($_SESSION['id']) && logged_in($dbh, $_SESSION['email'], $_SESSION['id'])) {
                header('Location: dashboard.php');
            }
            ?>
        <header>
            <a href="dashboard.php" class="header-link">Dashboard</a>
            <a href="login.php" class="header-link">Log in</a>
            <a href="signup.php" class="header-button">Sign up</a>
        </header>

    </body>
</html>