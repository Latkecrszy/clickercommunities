<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Clicker Community Dashboard</title>
        <link href="globals.css" rel="stylesheet">
    </head>
    <body>
        <?php
        session_start();
        require_once "config.php";
        $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
        $email = $_SESSION['email'];
        if (!logged_in($dbh, $email, $_SESSION['id'])) {
            header('Location: login.php');
        }
        echo "<p>$email</p>";
        ?>
        <header>
            <a href="home.php" class="header-logo"></a>
            <a href="logout.php" class="header-link">Log out</a>
        </header>
    </body>
</html>