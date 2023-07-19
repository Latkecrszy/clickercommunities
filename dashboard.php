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
        if (!(isset($_SESSION['email']) && isset($_SESSION['session_id']))) {
            header('Location: login.php');
        }
        $email = $_SESSION['email'];
        if (!logged_in($dbh, $email, $_SESSION['session_id'])) {
            header('Location: login.php');
        }
        $sth = $dbh->prepare('SELECT * FROM communities WHERE admin_id=:admin_id AND type="personal"');
        $sth->bindValue(':admin_id', $_SESSION['admin_id']);
        $sth->execute();
        $community = $sth->fetch();
        $sth3 = $dbh->prepare('SELECT * FROM purchased WHERE community_id=:community_id');
        $sth3->bindValue(':community_id', $community['id']);
        $sth3->execute();
        $purchased = convert_array($sth3->fetchAll(), 'item_name');

        $sth2 = $dbh->prepare('SELECT * FROM shop');
        $sth2->execute();
        $shop = $sth2->fetchAll();
        /*var_dump($community);
        echo "<br><br>";
        var_dump($shop);
        echo "<br><br>";
        var_dump($purchased);
        echo "<br><br>";
        print_r($community);
        echo "<br><br>";
        print_r($shop);
        echo "<br><br>";
        print_r($purchased);
        echo "<br><br>";*/

        ?>
        <header>
            <h1>Coconut Clicker</h1>
            <a href="home.php" class="header-logo"></a>
            <a href="logout.php" class="header-link underline">Log out</a>
        </header>
        <div id="personal">
            <div id="click-area">
                <h2 id="coconut-counter"></h2>
                <img src="coconut.png" onclick="addCoconuts(1); animateCoconut()" id="coconut" alt="coconut">
            </div>
            <div id="upgrades">
                <?php
                foreach($shop as $item) {
                    echo "<div class='upgrade' id={$item['name']}>";
                    if (array_key_exists($item['name'], $purchased)) {
                        echo "<h2 class='upgrade-count'>{$purchased[$item['name']]['count']}</h2>";
                    } else {
                        echo "<h2 class='upgrade-count'>0</h2>";
                    }
                    echo "<h2 class='upgrade-name'>{$item['name']}</h2>";
                    echo "<p class='upgrade-description'>{$item['description']}</p>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>

        <div id="community">
            <div id="join">

            </div>

            <div id="create">

            </div>
        </div>
    </body>
    <script>
        var coconuts = <?=json_encode($community['coconuts'], JSON_HEX_TAG);?>;
        document.getElementById('coconut-counter').innerText = 'Coconuts: ' + coconuts
    </script>
</html>