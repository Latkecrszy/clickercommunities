<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Signing in...</title>
        <link href="globals.css" rel="stylesheet">
        <link href="loading.css" rel="stylesheet">
    </head>
    <body>
    <?php
        session_start();
        require_once "config.php";
        $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

        if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && isset($_POST['password'])
            && isset($_POST['username'])) {
            $sth = $dbh->prepare('SELECT email FROM users WHERE email=:email');
            $sth->bindValue(':email', strtolower($_POST['username']));
            $sth->execute();
            if (!$sth->fetch()) {
                $sth = $dbh->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');
                $sth->bindValue(':username', $_POST['username']);
                $sth->bindValue(':email', strtolower($_POST['username']));
                $sth->bindValue(':password', password_hash($_POST['password'], PASSWORD_DEFAULT));
                if ($sth->execute()) {
                    header('Location: dashboard.php');
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