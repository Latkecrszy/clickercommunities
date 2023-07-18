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
            $email = strtolower($_POST['email']);
            $sth = $dbh->prepare('SELECT email FROM users WHERE email=:email');
            $sth->bindValue(':email', $email);
            $sth->execute();
            if (!$sth->fetch()) {
                $sth = $dbh->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');
                $sth->bindValue(':username', $_POST['username']);
                $sth->bindValue(':email', $email);
                $sth->bindValue(':password', password_hash($_POST['password'], PASSWORD_DEFAULT));
                if ($sth->execute()) {
                    $_SESSION['email'] = $email;
                    $session_id = uniqid();
                    $_SESSION['id'] = $session_id;
                    $sth = $dbh->prepare("INSERT INTO sessions (session_id, email) VALUES (:session_id, :email)");
                    $sth->bindValue(':session_id', $session_id);
                    $sth->bindValue(':email', $email);
                    if ($sth->execute()) {
                        header('Location: dashboard.php');
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