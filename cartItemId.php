<?php
session_start();
include('Database.php');
include('ItemRepository.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cartItemId'])) {
    $itemId = $_POST['cartItemId'];

    // Create a database instance
    $db = Database::getInstance('localhost', 'root', "", 'shopping_system');
    $ItemRepository = new ItemRepository($db);
    $userId = $_SESSION['auth']['id'];


    // Get item details based on the received item ID
    $item = $ItemRepository->getById('items', $itemId);

    if ($item) {
        // Assuming 'cart' is the table name where cart items are stored
        $item['user_id'] = $userId;
        $result = $ItemRepository->create('cart', $item);

        if ($result === true) {
            $_SESSION['success'] = "Item added to cart successfully!";
            header("location: cartPage.php"); // Redirect to cart page after adding to cart
            exit();
        } else {
            $_SESSION['error'] = "Error adding item to cart: " . $result;
            header("location: userCategories.php"); // Redirect back to item list page on error
            exit();
        }
    } else {
        $_SESSION['error'] = "Item not found!";
        header("location: userCategories.php"); // Redirect back to item list page if item is not found
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid request!";
    header("location: userCategories.php"); // Redirect back to item list page for invalid requests
    exit();
}
?>
