<html lang="en">
    <head>
        <title>Drop Parkamon DB</title>
    </head>
    <body>
        <?php
        if (file_exists('config.php')) {
            require_once "config.php";
            try {
                $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
                $query = 'DROP TABLE IF EXISTS users, communities, shop, membership, purchased';
                $dbh->exec($query);
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