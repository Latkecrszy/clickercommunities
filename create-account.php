<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Signing in...</title>
        <link href="globals.css" rel="stylesheet">
        <link href="loading.css" rel="stylesheet">
    </head>
    <body>
    <?php
        // Start session and require config file
        session_start();
        require_once "config.php";
        // Validate inputs
        if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && isset($_POST['password'])
            && isset($_POST['username']) && strlen($_POST['username']) <= 25) {
            // Create and execute SQL query to check if user's email is already in use
            $email = strtolower($_POST['email']);
            $sth = DBH->prepare('SELECT email FROM users WHERE email=:email');
            $sth->bindValue(':email', $email);
            $sth->execute();
            if (!$sth->fetch()) {
                // Create and execute SQL query to insert record into users table
                $sth = DBH->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');
                $sth->bindValue(':username', $_POST['username']);
                $sth->bindValue(':email', $email);
                $sth->bindValue(':password', password_hash($_POST['password'], PASSWORD_DEFAULT));
                if ($sth->execute()) {
                    // Create and execute SQL query to get user's id
                    $sth3 = DBH->prepare('SELECT id FROM users WHERE email=:email');
                    $sth3->bindValue(':email', $email);
                    $sth3->execute();

                    // Set session variables
                    $admin_id = $sth3->fetch()['id'];
                    $_SESSION['email'] = $email;
                    $session_id = uniqid();
                    $_SESSION['session_id'] = $session_id;
                    $_SESSION['admin_id'] = $admin_id;

                    // Create and execute SQL query to add session to session DB
                    $sth = DBH->prepare("INSERT INTO sessions (session_id, email) VALUES (:session_id, :email)");
                    $sth->bindValue(':session_id', $session_id);
                    $sth->bindValue(':email', $email);

                    // Create and execute SQL query to create user's personal community
                    $sth2 = DBH->prepare("INSERT INTO communities (name, type, admin_id, coconuts) VALUES (:name, 'personal', :admin_id, 0)");
                    $sth2->bindValue(':name', $_POST['username']);
                    $sth2->bindValue(':admin_id', $admin_id);
                    $sth2->execute();
                    // Redirect to dashboard.php if success
                    if ($sth->execute()) {
                        header('Location: dashboard.php');
                    } else {
                        echo "<p style='color: red'>Error: nuh uh</p>";
                    }
                }

            } else {
                echo "<p style='color: red'>Error: email in use</p>";
            }
        } else {
            echo "<p style='color: red'>Error: nuh uh</p>";
        }
        ?>
    <p>Creating account...</p>
    </body>
</html>