<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Clicker Communities</title>
        <link href="globals.css" rel="stylesheet">
        <link href="login.css" rel="stylesheet">
    </head>
    <body>
        <header>
            <a href="signup.php" class="header-button">Sign up</a>
        </header>
        <form action="sign_in.php" method="POST">
            <input type="email" name="email" placeholder="Email address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Log in</button>
        </form>
    </body>
</html>