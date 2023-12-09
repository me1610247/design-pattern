<?php
include('Database.php');
include('ItemRepository.php');

// Create a database instance
$db = Database::getInstance('localhost', 'root', "", 'shopping_system');
$ItemRepository = new ItemRepository($db);

// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $itemId = $_POST['itemId'];
    $name = $_POST['itemName'];
    $details = $_POST['itemDetails'];
    $price = $_POST['itemPrice'];
    $updateData = [
        'name' => $_POST['itemName'],
        'details' => $_POST['itemDetails'],
        'price' => $_POST['itemPrice'],
        // Add other columns as needed
    ];
    

    // Update the item using the ItemRepository
    $updateResult = $ItemRepository->update('items', $itemId, $updateData);

    // Display success or error message
    if ($updateResult === true) {
        echo "Item updated successfully!";
    } else {
        echo $updateResult; // Display error message if any
    }
}
?>
