<?php
// Create function to check if a user is logged in
function logged_in(): bool {
    // Check if all session variables are set
    if (isset($_SESSION['email']) && isset($_SESSION['session_id']) && isset($_SESSION['admin_id'])) {
        // Create and execute request to determine if user's session is active and valid
        $sth = DBH->prepare('SELECT id FROM sessions WHERE email=:email AND session_id=:id');
        $sth->bindValue(':email', $_SESSION['email']);
        $sth->bindValue(':id', $_SESSION['session_id']);
        return $sth->execute();
    } else {
        return false;
    }
}

// Create function to turn array of objects into object of objects using a given identifier
function convert_array($array, $identifier='id'): array {
    $dict = [];
    foreach($array as $object) {
        $dict[$object[$identifier]] = $object;
    }
    return $dict;
}