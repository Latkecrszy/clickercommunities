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

    if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && isset($_POST['password'])) {
        $sth = $dbh->prepare('SELECT password, id FROM users WHERE email=:email');
        $sth->bindValue(':email', strtolower($_POST['email']));
        $sth->execute();
        $password = $sth->fetch()['password'];
        $id = $sth->fetch()['id'];
        if (password_verify($_POST['password'], $password)) {
            $_SESSION['email'] = strtolower($_POST['email']);
            $session_id = uniqid();
            $_SESSION['session_id'] = $session_id;
            $_SESSION['admin_id'] = $id;
            $sth = $dbh->prepare("INSERT INTO sessions (session_id, email) VALUES (:session_id, :email)");
            $sth->bindValue(':session_id', $session_id);
            $sth->bindValue(':email', strtolower($_POST['email']));
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