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

// Include Database.php and ItemRepository.php here
// Include necessary files and create database and ItemRepository objects

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $db = Database::getInstance('localhost', 'root', "", 'shopping_system');
    $ItemRepository = new ItemRepository($db);
    // Retrieve the submitted form data
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    // Sanitize and validate input if needed

    // Get the user's email from the session
    $email = $_SESSION['auth']['email'];

    // Update the user's information in the database
    $updateData = [
        'name' => $name,
        'phone' => $phone
        // Add more fields to update as needed
    ];

    // Update the user's information using the ItemRepository method
    // For example, assuming there's an update method in ItemRepository
    $conditions = ['email' => $email];
    $result = $ItemRepository->update('users', $updateData, $conditions);

    if ($result) {
        // Update successful, update the session data
        $_SESSION['auth']['name'] = $name;
        $_SESSION['auth']['phone'] = $phone;

        $_SESSION['success'] = "Profile updated successfully";
        header("Location: profile.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to update profile";
        header("Location: profile.php");
        exit();
    }
}
?>
