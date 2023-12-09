<?php
session_start();
include('Database.php');
include('ItemRepository.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['itemId'])) {
    $itemId = $_POST['itemId'];

    // Create a database instance
    $db = Database::getInstance('localhost', 'root', "", 'shopping_system');
    $ItemRepository = new ItemRepository($db);

    // Get item details based on the received item ID
    $item = $ItemRepository->getById('cart', $itemId);
    $feedback=$_POST['feedback'];
    $itemName=$_POST['itemName'];
    $itemPrice=$_POST['itemPrice'];
    $feedbackData = [
        'id' => $item,
        'name'=>$itemName,
        'price'=>$itemPrice,
        'message' => $feedback
        // You might want to add more details here such as user ID, timestamp, etc.
    ];
    if ($feedbackData) {
        // Assuming 'cart' is the table name where cart items are stored
        $result = $ItemRepository->create('feedback', $feedbackData);

        if ($result === true) {
            header("location:cartPage.php"); // Redirect to cart page after adding to cart
            $_SESSION['feedback'] = "Thank you For Your Submiting a feedback!";
            exit();
        } else {
            $_SESSION['error'] = "Error adding item to cart: " . $result;
            header("location: addFeedback.php"); // Redirect back to item list page on error
            exit();
        }
    } else {
        $_SESSION['error'] = "Item not found!";
        header("location: addFeedback.php"); // Redirect back to item list page if item is not found
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid request!";
    header("location: userItems.php"); // Redirect back to item list page for invalid requests
    exit();
}
?>
