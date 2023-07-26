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
        if (!logged_in()) {
            header('Location: login.php');
        }
        $sth = $dbh->prepare("SELECT * FROM communities WHERE admin_id=:admin_id AND type='personal'");
        $sth->bindValue(':admin_id', $_SESSION['admin_id']);
        $sth->execute();
        $community = $sth->fetch();
        $sth3 = $dbh->prepare('SELECT * FROM purchased WHERE community_id=:community_id');
        $sth3->bindValue(':community_id', $community['id']);
        $sth3->execute();
        $purchased = convert_array($sth3->fetchAll(), 'item_name');

        $sth2 = $dbh->prepare('SELECT * FROM shop');
        $sth2->execute();
        $shop = convert_array($sth2->fetchAll(), 'name');

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
                <img draggable="false" src="coconut.png" onclick="addCoconuts(1); animateCoconut()" id="coconut" alt="coconut">
            </div>
            <div id="upgrades">
                <?php
                foreach($shop as $item) {
                    $name = $item['name'];
                    $cost = $item['cost'];
                    $description = $item['description'];
                    $id = $item['id'];
                    $community_id = $community['id'];
                    echo "<div class='upgrade' data-cost='$cost' data-community_id='$community_id' data-id='$id' data-name='$name' id='$name' onclick='buyUpgrade(this)'>";
                    if (array_key_exists($name, $purchased)) {
                        $count = $purchased[$item['name']]['count'];
                        echo "<h2 class='upgrade-count'>$count</h2>";
                    } else {
                        echo "<h2 class='upgrade-count'>0</h2>";
                    }
                    echo "<h2 class='upgrade-name'>$name</h2>";
                    echo "<p class='upgrade-cost'>$cost</p>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>

        <div id="community">
            <div id="join">
                <h1 class="community-header">Join Community</h1>
                <input type="text" class="community-input" id="join-input" placeholder="Search for communities">
            </div>

            <div id="create">
                <h1 class="community-header">Create Community</h1>
                <div id="create-inputs">
                    <input type="text" id="create-input-name" class="community-input" placeholder="Name">
                    <input type="text" id="create-input-description" class="community-input" placeholder="Description">
                    <button type="submit" onclick="createCommunity()">Create</button>
                </div>
            </div>
        </div>
    </body>
    <script>
        var coconuts = <?=json_encode($community['coconuts'], JSON_HEX_TAG);?>;
        let purchased = <?=json_encode($purchased, JSON_HEX_TAG);?>;
        let shop = <?=json_encode($shop, JSON_HEX_TAG);?>;
        console.log(shop)
        document.getElementById('coconut-counter').innerText = 'Coconuts: ' + coconuts
    </script>
</html>