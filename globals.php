<?php
function logged_in(): bool {
    if (isset($_SESSION['email']) && isset($_SESSION['session_id']) && isset($_SESSION['admin_id'])) {
        $sth = DBH->prepare('SELECT id FROM sessions WHERE email=:email AND session_id=:id');
        $sth->bindValue(':email', $_SESSION['email']);
        $sth->bindValue(':id', $_SESSION['session_id']);
        return $sth->execute();
    } else {
        return false;
    }
}

function convert_array($array, $identifier='id'): array {
    $dict = [];
    foreach($array as $object) {
        $dict[$object[$identifier]] = $object;
    }
    return $dict;
}