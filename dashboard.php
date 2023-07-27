<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Page title and font stylesheets -->
    <title>Clicker Community Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue&family=Hind+Siliguri&family=Montserrat:wght@400;600&family=Raleway:wght@600&display=swap" rel="stylesheet">

    <!-- CSS stylesheets -->
    <link href="globals.css" rel="stylesheet">
    <link href="dashboard.css" rel="stylesheet">

    <!-- JavaScript file -->
    <script src="dashboard.js"></script>
</head>
<body>
    <?php
    // Start the PHP session and include the config file
    session_start();
    require_once "config.php";

    // Check if the user is logged in, if not, redirect to login page
    if (!(isset($_SESSION['email']) && isset($_SESSION['session_id']))) {
        header('Location: login.php');
    }

    // Get user email from the session
    $email = $_SESSION['email'];

    // Check if the user is logged in, if not, redirect to login page
    if (!logged_in()) {
        header('Location: login.php');
    }

    // Fetch the personal community of the logged-in user
    $sth = DBH->prepare("SELECT * FROM communities WHERE admin_id=:admin_id AND type='personal'");
    $sth->bindValue(':admin_id', $_SESSION['admin_id']);
    $sth->execute();
    $community = $sth->fetch();

    // Fetch the purchased items for the community
    $sth3 = DBH->prepare('SELECT * FROM purchased WHERE community_id=:community_id');
    $sth3->bindValue(':community_id', $community['id']);
    $sth3->execute();
    $purchased = convert_array($sth3->fetchAll(), 'item_name');

    // Store the community ID and fetch the shop items
    $community_id = $community['id'];
    $sth2 = DBH->prepare('SELECT * FROM shop');
    $sth2->execute();
    $shop = convert_array($sth2->fetchAll(), 'name');
    ?>

    <!-- Header of site -->
    <header>
        <h2><img id="coconut-small" draggable="false" src="coconut.png" onclick="addCoconuts(1); animateCoconut('coconut-small')" alt="coconut"> Coconut Clicker</h2>
        <a href="home.php" class="header-logo"></a>
        <a href="logout.php" class="header-link underline">Log out</a>
    </header>
    <!-- Personal Community section -->
    <div id="personal">
        <div id="click-area">
            <h2 id="coconut-counter"></h2>
            <img draggable="false" src="coconut.png" onclick="addCoconuts(1); animateCoconut()" id="coconut" alt="coconut">
        </div>
        <div id="upgrades">
            <?php
            // Show shop items as upgrades
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
            ?>
        </div>
    </div>
    <!-- Community Section -->
    <div id="community">
        <div id="join">
            <h1 class="community-header">Join Community</h1>
            <input type="text" class="community-input" id="join-input" placeholder="Community id">
            <button class="submit hover-arrow" type="submit" onclick="joinCommunity()">Join <img loading="lazy" src="arrow.svg" alt="right arrow"></button>
        </div>

        <div id="create">
            <h1 class="community-header">Create Community</h1>
            <div id="create-inputs">
                <input type="text" id="create-input-name" class="community-input" placeholder="Name">
                <input type="text" id="create-input-description" class="community-input" placeholder="Description">
                <button class="submit hover-arrow" type="submit" onclick="createCommunity()">Create <img loading="lazy" src="arrow.svg" alt="right arrow"></button>
            </div>
        </div>
    </div>
    </body>
    <script>
        // Initialize variables
        var coconuts = <?=json_encode($community['coconuts'], JSON_HEX_TAG);?>;
        let purchased = <?=json_encode($purchased, JSON_HEX_TAG);?>;
        let shop = <?=json_encode($shop, JSON_HEX_TAG);?>;
        const community_id = <?=json_encode($community_id, JSON_HEX_TAG);?>;
        console.log(shop)
        // Update coconut count on the page
        document.getElementById('coconut-counter').innerText = 'Coconuts: ' + coconuts
    </script>
</html>