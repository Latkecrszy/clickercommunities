<html lang="en">
    <head>
        <title>Install Clicker Communities DB</title>
    </head>
    <body>
        <?php
        // Check if config.php exists
        if (file_exists('config.php')) {
            require_once "config.php";
            try {
                // Execute SQL setup code from initialize.sql
                $query = file_get_contents('initialize.sql');
                DBH->exec($query);
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