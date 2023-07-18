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
        if (isset($_SESSION['email']) && isset($email))
        $sth = $dbh->prepare('SELECT id FROM sessions WHERE email=:email AND session_id=:id');
        $sth->bindValue(':email', $email);
        $sth->bindValue(':id', $_SESSION['id']);
        $sth->execute();
        if (!$sth->fetch()) {
            header('Location: login.php');
        }
        echo "<p>$email</p>";
        ?>

    </body>
</html>