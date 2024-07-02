<?php
$db = new mysqli('localhost', 'root', '', 'bienesraices_crud');

if ($db->connect_error) {
    die('Connection failed: ' . $db->connect_error);
}

function conexionDB() {
    global $db;
    return $db;
}
?>
