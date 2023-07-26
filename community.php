<!DOCTYPE html>
<?php
session_start();
require_once "config.php";
$dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
$sth = DBH->prepare("SELECT * FROM membership WHERE community_id=:community_id AND user_id=:user_id");
$sth->bindValue(':community_id', $_GET['id']);
$sth->bindValue(':user_id', $_SESSION['admin_id']);
$sth->execute();
if (!logged_in()) {
    echo "something else";
    //header('Location: login.php');
} else if (!(isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) || !$sth->fetch()) {
    //echo "something";
    //header('Location: dashboard.php');
}

$sth2 = DBH->prepare("SELECT * FROM communities WHERE id=:id AND type='public'");
$sth2->bindValue(':id', $_GET['id']);
$sth2->execute();
$community = $sth2->fetch();
if ($community['admin_id'] == $_SESSION['admin_id']) {
    $admin = true;
} else {
    $admin = false;
}


$sth3 = $dbh->prepare('SELECT * FROM shop');
$sth3->execute();
$shop = convert_array($sth3->fetchAll(), 'name');
$sth4 = $dbh->prepare('SELECT * FROM purchased WHERE community_id=:community_id');
$sth4->bindValue(':community_id', $community['id']);
$sth4->execute();
$purchased = convert_array($sth4->fetchAll(), 'item_name');
?>
<html lang="en">
    <head>
        <script>
            let admin = <?=json_encode($admin, JSON_HEX_TAG);?>;
            console.log(admin)
        </script>
        <title>Community</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Comic+Neue&family=Hind+Siliguri&family=Montserrat:wght@400;600&family=Raleway:wght@600&display=swap" rel="stylesheet">
        <link href="globals.css" rel="stylesheet">
        <link href="dashboard.css" rel="stylesheet">
        <link href="community.css" rel="stylesheet">
        <script src="community.js"></script>
        <script src="dashboard.js"></script>
    </head>
    <body>
        <header>
            <h1>Coconut Clicker</h1>
            <a href="home.php" class="header-logo"></a>
            <a href="logout.php" class="header-link underline">Log out</a>
        </header>
        <div id="content">
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
                    if ($cost > $community['coconuts']) {
                        echo "<div class='upgrade blurred' data-cost='$cost' data-community_id='$community_id' data-id='$id' data-name='$name' id='$name' onclick='buyUpgrade(this)'>";
                    } else {
                        echo "<div class='upgrade' data-cost='$cost' data-community_id='$community_id' data-id='$id' data-name='$name' id='$name' onclick='buyUpgrade(this)'>";
                    }
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
    </body>
    <script>
        var coconuts = <?=json_encode($community['coconuts'], JSON_HEX_TAG);?>;
        let purchased = <?=json_encode($purchased, JSON_HEX_TAG);?>;
        let shop = <?=json_encode($shop, JSON_HEX_TAG);?>;
        console.log(shop)
        document.getElementById('coconut-counter').innerText = 'Coconuts: ' + coconuts
    </script>
</html>