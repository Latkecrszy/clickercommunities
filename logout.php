<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Logging out...</title>
    </head>
    <body>
        <?php
        session_start();
        require_once "config.php";
        $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
        if (logged_in($dbh, $_SESSION['email'], $_SESSION['id'])) {
            $sth = $dbh->prepare('DELETE FROM sessions WHERE email=:email');
            $sth->bindValue(':email', $_SESSION['email']);
            $sth->execute();
        }
        session_destroy();
        header('Location: login.php');
        ?>
    <p>Logging out...</p>
    </body>
</html>