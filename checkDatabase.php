<?php
include('database.php');

// Get the singleton instance
$db = Database::getInstance('localhost', 'root', '', 'shopping_system');
$connection = $db->getConnection(); // Access the connection from the singleton instance

if ($connection) {
    echo "Connected successfully to the database!";
} else {
    echo "Connection failed.";
}
