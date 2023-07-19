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
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();
        header('Location: login.php');
        ?>
    <p>Logging out...</p>
    </body>
</html>