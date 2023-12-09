<?php
session_start();
include('Database.php');
include('ItemRepository.php');

// Check if the user is logged in
if (!isset($_SESSION['auth'])) {
    // Redirect the user to the login page if not logged in
    header("Location: login.php");
    exit();
}

$db = Database::getInstance('localhost', 'root', '', 'shopping_system');
$ItemRepository = new ItemRepository($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the order ID from the form submission
    $orderID = $_POST['orderID'];

    // Delete the order from the database using the order ID
    $ItemRepository->delete('orders',$orderID); // Replace this with your method to delete the order

    // Redirect the user back to the user orders page after deletion
    header("Location: userItems.php");
    exit();
}
?>