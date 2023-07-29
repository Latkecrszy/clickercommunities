<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Clicker Communities</title>
        <link href="globals.css" rel="stylesheet">
        <link href="home.css" rel="stylesheet">
    </head>
    <body>
        <?php
            // Start the PHP session and include the config file
            session_start();
            require_once "config.php";

            // If user is logged in, redirect to the dashboard
            if (logged_in()) {
                header('Location: dashboard.php');
            }
            ?>
        <header>
            <a href="https://www.google.com/imgres?imgurl=https%3A%2F%2Fi.guim.co.uk%2Fimg%2Fmedia%2Fc6556300eea53c5095cda4d86d16787d863da70e%2F71_188_3711_2228%2Fmaster%2F3711.jpg%3Fwidth%3D700%26quality%3D85%26auto%3Dformat%26fit%3Dmax%26s%3D40a1251a8214d34a908a1d33a11dc57e&tbnid=Rx7BX4--vQq19M&vet=12ahUKEwjWraHk26-AAxWjPEQIHWfyCW4QMygQegUIARCXAg..i&imgrefurl=https%3A%2F%2Fwww.theguardian.com%2Flifeandstyle%2F2017%2Fjul%2F12%2Fhigh-fat-oil-and-low-paid-farmers-the-cost-of-our-coconut-craze&docid=ZpDXy2X-tn1j2M&w=700&h=420&q=coconut%20image&ved=2ahUKEwjWraHk26-AAxWjPEQIHWfyCW4QMygQegUIARCXAg" class="header-link underline">Image credit</a>
            <a href="dashboard.php" class="header-link underline">Dashboard</a>
            <a href="login.php" class="header-link underline">Log in</a>
            <a href="signup.php" class="header-button">Sign up</a>
        </header>

    </body>
</html>