<html lang="en">
    <head>
        <title>Drop Parkamon DB</title>
    </head>
    <body>
        <?php
        if (file_exists('config.php')) {
            require_once "config.php";
            try {
                // Drop all tables
                $query = 'DROP TABLE IF EXISTS users, communities, shop, membership, purchased';
                DBH->exec($query);
                echo "<p>Successfully dropped databases</p>";
            }
            catch (PDOException $e) {
                echo "<p style='color: red'>Error: {$e->getMessage()}</p>";
            }
        } else {
            echo "<p style='color: red'>No perms</p>";
        }
        ?>
    </body>
</html>