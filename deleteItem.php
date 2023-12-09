<?php
include('Database.php'); // Include the Database class
include('ItemRepository.php'); // Include the ItemRepository class

// Check if form is submitted and the 'deleteItemId' is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteItemId'])) {
    // Retrieve item ID from the form
    $deleteItemId = $_POST['deleteItemId'];

    // Create a database instance
    $db = Database::getInstance('localhost', 'root', "", 'shopping_system');

    // Create an instance of the ItemRepository
    $ItemRepository = new ItemRepository($db);

    // Delete item
    $deleteResult = $ItemRepository->delete('items',$deleteItemId); // Pass the ID of the item to delete
    if ($deleteResult === true) {
        echo "Item deleted successfully!";
    } else {
        echo $deleteResult; // Display error message if any
    }
} else {
    echo "Invalid request or item ID not provided.";
}
