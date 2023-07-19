<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Clicker Community Dashboard</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Comic+Neue&family=Hind+Siliguri&family=Montserrat:wght@400;600&family=Raleway:wght@600&display=swap" rel="stylesheet">
        <link href="globals.css" rel="stylesheet">
        <link href="dashboard.css" rel="stylesheet">
        <script src="dashboard.js"></script>
    </head>
    <body>
        <?php
        session_start();
        require_once "config.php";
        $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
        if (!(isset($_SESSION['email']) && isset($_SESSION['id']))) {
            header('Location: login.php');
        }
        $email = $_SESSION['email'];
        if (!logged_in($dbh, $email, $_SESSION['id'])) {
            header('Location: login.php');
        }
        ?>
        <header>
            <h1>Clicker Communities</h1>
            <a href="home.php" class="header-logo"></a>
            <a href="logout.php" class="header-link underline">Log out</a>
        </header>
        <div id="personal">
            <div id="click-area">
                <img src="coconut.png" id="coconut" alt="coconut">
            </div>
            <div id="upgrades"></div>
        </div>

        <div id="community">
            <div id="join">

            </div>

            <div id="create">

            </div>
        </div>
    </body>
</html>