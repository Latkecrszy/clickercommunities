<!DOCTYPE html>
<?php
// Start session and require config file
session_start();
require_once "config.php";

// Create and execute SQL query to check if user is in community
$sth = DBH->prepare("SELECT * FROM membership WHERE community_id=:community_id AND user_id=:user_id");
$sth->bindValue(':community_id', $_GET['id']);
$sth->bindValue(':user_id', $_SESSION['admin_id']);
$sth->execute();

// Redirect back to login page if user isn't logged in
if (!logged_in()) {
    header('Location: login.php');
}
// Redirect back to dashboard if inputs aren't valid or user isn't in community
else if (!(isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) || !$sth->fetch()) {
    header('Location: dashboard.php');
}

// Fetch community data for the given community ID
$sth2 = DBH->prepare("SELECT * FROM communities WHERE id=:id AND type='public'");
$sth2->bindValue(':id', $_GET['id']);
$sth2->execute();
$community = $sth2->fetch();
$community_id = $community['id'];
// Check if the logged-in user is the admin of the community
if ($community['admin_id'] == $_SESSION['admin_id']) {
    $admin = true;
} else {
    $admin = false;
}

// Fetch shop items and purchased items for the community
$sth3 = DBH->prepare('SELECT * FROM shop');
$sth3->execute();
$shop = convert_array($sth3->fetchAll(), 'name');
$sth4 = DBH->prepare('SELECT * FROM purchased WHERE community_id=:community_id');
$sth4->bindValue(':community_id', $community['id']);
$sth4->execute();
$purchased = convert_array($sth4->fetchAll(), 'item_name');
?>
<html lang="en">
<head>
    <title>Community</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue&family=Hind+Siliguri&family=Montserrat:wght@400;600&family=Raleway:wght@600&display=swap" rel="stylesheet">
    <link href="globals.css" rel="stylesheet">
    <link href="dashboard.css" rel="stylesheet">
    <link href="community.css" rel="stylesheet">
    <script src="dashboard.js"></script>
</head>
<body>
<!-- Header of site with community name and navigation links -->
<header>
    <h2><img id="coconut-small" draggable="false" src="coconut.png" onclick="addCoconuts(1); animateCoconut('coconut-small')" alt="coconut"> Coconut Clicker</h2>
    <h1><?=htmlspecialchars($community['name'])?></h1>
    <a href="home.php" class="header-logo"></a>
    <?php
    if ($admin) {
        echo "<a href='delete-community.php?id=$community_id' class='header-link underline'>Delete Community</a>";
    }
    ?>
    <a href="dashboard.php" class="header-link underline">Dashboard</a>
    <a href="logout.php" class="header-link underline">Log out</a>
</header>
<div id="content">
    <div id="click-area">
        <!-- Main Coconut + Count -->
        <h2 id="coconut-counter"></h2>
        <img draggable="false" src="coconut.png" onclick="addCoconuts(1); animateCoconut()" id="coconut" alt="coconut">
    </div>
    <?php
    // Display upgrades for the admin of the community
    if ($admin) {
        echo '<div id="upgrades">';
        foreach($shop as $item) {
            $name = $item['name'];
            $cost = $item['cost'];
            $description = $item['description'];
            $id = $item['id'];
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
        echo "</div>";
    }
    ?>
</div>
</body>
<script>
    // Define constants and create coconuts global
    var coconuts = <?=json_encode($community['coconuts'], JSON_HEX_TAG);?>;
    let purchased = <?=json_encode($purchased, JSON_HEX_TAG);?>;
    let shop = <?=json_encode($shop, JSON_HEX_TAG);?>;
    document.getElementById('coconut-counter').innerText = 'Coconuts: ' + coconuts
    let admin = <?=json_encode($admin, JSON_HEX_TAG);?>;
    const community_id = <?=json_encode($community_id, JSON_HEX_TAG);?>;
    // Add 'member' class to click-area if the user is not the admin to remove the ability to purchase upgrades
    if (!admin) {
        document.getElementById('click-area').classList.add('member')
    }
</script>
</html>