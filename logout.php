<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Logging out...</title>
    </head>
    <body>
        <?php
        // Start the PHP session and include the config file
        session_start();
        require_once "config.php";
        // Delete the user's session from DB
        if (logged_in()) {
            $sth = DBH->prepare('DELETE FROM sessions WHERE email=:email');
            $sth->bindValue(':email', $_SESSION['email']);
            $sth->execute();
        }
        // Destroy session
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