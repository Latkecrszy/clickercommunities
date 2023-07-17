<html lang="en">
    <head>
        <title>Install Clicker Communities DB</title>
    </head>
    <body>
        <?php
        if (file_exists('config.php')) {
            require_once "config.php";
            try {
                $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
                $query = file_get_contents('initialize.sql');
                $dbh->exec($query);
                echo "<p>Successfully installed databases</p>";
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