<?php
session_start();
include('Database.php');
include('ItemRepository.php');

// Check if the user is logged in


$db = Database::getInstance('localhost', 'root', '', 'shopping_system');
$ItemRepository = new ItemRepository($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the order ID from the form submission
    $userId = $_POST['userId'];

    // Delete the order from the database using the order ID
    $ItemRepository->delete('users',$userId); // Replace this with your method to delete the order

    // Redirect the user back to the user orders page after deletion
    header("Location: users.php");
    exit();
}
?>