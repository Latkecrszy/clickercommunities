<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Signing in...</title>
        <link href="globals.css" rel="stylesheet">
        <link href="loading.css" rel="stylesheet">
    </head>
    <body>
    <?php
    // Start the PHP session and include the config file
    session_start();
    require_once "config.php";
    // Validate inputs
    if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && isset($_POST['password'])) {
        // Create and execute SQL query to get user's password and id
        $sth = DBH->prepare('SELECT password, id FROM users WHERE email=:email');
        $sth->bindValue(':email', strtolower($_POST['email']));
        $sth->execute();
        $db = $sth->fetch();
        $password = $db['password'];
        $id = $db['id'];

        // Verify is password user entered is correct
        if (password_verify($_POST['password'], $password)) {
            // Create session variables
            $_SESSION['email'] = strtolower($_POST['email']);
            $session_id = uniqid();
            $_SESSION['session_id'] = $session_id;
            $_SESSION['admin_id'] = $id;

            // Create and execute SQL query to add session to session DB
            $sth = DBH->prepare("INSERT INTO sessions (session_id, email) VALUES (:session_id, :email)");
            $sth->bindValue(':session_id', $session_id);
            $sth->bindValue(':email', strtolower($_POST['email']));

            // If successful, redirect to dashboard
            if ($sth->execute()) {
                header('Location: dashboard.php');
            }
        }
        else {
            echo "<p style='color: red'>Error: invalid credentials</p>";
        }
    } else {
        echo "<p style='color: red'>Error: nuh uh</p>";
    }
    ?>
    <p>Logging in...</p>
    </body>
</html>