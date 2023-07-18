<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Clicker Communities</title>
        <link href="globals.css" rel="stylesheet">
        <link href="login.css" rel="stylesheet">
    </head>
    <body>
        <?php
        require_once "config.php";

        $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
        ?>
        <header>
            <a href="dashboard.php" class="header-logo">Home</a>
            <a href="login.php" class="header-link">Log in</a>
        </header>
        <form action="create_account.php" method="POST">
            <input type="text" name="username" placeholder="Username" maxlength="25" required>
            <input type="email" name="email" placeholder="Email address" required>
            <input type="password" name="password" placeholder="Password" maxlength="50" required>
            <button type="submit">Sign up</button>
        </form>

    </body>
</html>