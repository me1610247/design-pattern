<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['auth'])) {
    // Redirect the user to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Include necessary files and create database and ItemRepository objects
include('Database.php');
include('ItemRepository.php');

// Create a database instance
$db = Database::getInstance('localhost', 'root', '', 'shopping_system');

// Create an instance of the ItemRepository
$ItemRepository = new ItemRepository($db);

// Get the user's details from the session
$userDetails = $_SESSION['auth'];

// Fetch items from the cart for the logged-in user
$itemsForCheckout = $ItemRepository->get('cart'); // Replace with your method to get cart items by user's email
if (isset($_POST['placeOrder'])) {
    // Process the order here

    // Retrieve the payment method chosen by the user
    $paymentMethod = $_POST['paymentMethod'];

    // Handle the different payment methods
    if ($paymentMethod === 'creditCard') {
        // Retrieve the credit card details
        $cardType = $_POST['cardType'];
        $cardNumber = $_POST['cardNumber'];
        $expiryDate = $_POST['expiryDate'];
        $cvv = $_POST['cvv'];

        $totalPrice = 0; // Initialize total price
foreach ($itemsForCheckout as $item) {
    $price= $item['price_Sale']; // Adcheed each item's price to the total
    $name=$item['name'];
}

// Insert order details into the "orders" table
$orderData = array(
    'user_id' => $userDetails['id'],
    'item_name'=>$name,
    'user_name' => $userDetails['name'],
    'user_email' => $userDetails['email'],
    'user_phone' => $userDetails['phone'],
    'total_price' => $price
);

$result = $ItemRepository->create('orders', $orderData); // Replace with your method to insert data into the "orders" table

if ($result === true) {
    // Order placed successfully
    // Clear the cart or perform other necessary actions
    $ItemRepository->deleteCart('cart', 'user_id', $userDetails['id']); // Replace with your method to delete cart items by user's email

    // Redirect to a success page or display a success message
    header("Location: userCategories.php");
    $_SESSION['orderSuccess']="Order Placed Successfully";
    exit();
} else {
    // Error placing the order
    // Handle the error by displaying an error message or redirecting to an error page
    echo "Error placing the order: " . $result;
    exit();
}
        // ...
    } elseif ($paymentMethod === 'fawry') {
        // Retrieve the Fawry code
        $fawryCode = $_POST['fawryCode'];

        $price = 0; // Initialize total price
foreach ($itemsForCheckout as $item) {
    $price += $item['price_Sale']; // Adcheed each item's price to the total
    $name=$item['name'];
}

// Insert order details into the "orders" table
$orderData = array(
    'user_id' => $userDetails['id'],
    'item_name'=>$name,
    'user_name' => $userDetails['name'],
    'user_email' => $userDetails['email'],
    'user_phone' => $userDetails['phone'],
    'total_price' => $price,
    'payment' => $fawryCode
);

$result = $ItemRepository->create('orders', $orderData); // Replace with your method to insert data into the "orders" table

if ($result === true) {
    // Order placed successfully
    // Clear the cart or perform other necessary actions
    $ItemRepository->deleteCart('cart', 'user_id', $userDetails['id']); // Replace with your method to delete cart items by user's email

    // Redirect to a success page or display a success message
    header("Location: userCategories.php");
    $_SESSION['orderSuccess']="Order Placed Successfully";
    exit();
} else {
    // Error placing the order
    // Handle the error by displaying an error message or redirecting to an error page
    echo "Error placing the order: " . $result;
    exit();
}
        // ...
    }

    // Redirect the user to a confirmation page or display a success message
    header("Location: orderConfirmation.php");
    exit();

// Calculate total price for checkout
}