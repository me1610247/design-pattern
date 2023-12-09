<?php
session_start();
include('Database.php'); // Include the Database class
include('ItemRepository.php'); // Include the ItemRepository class

// Create a database instance
$db = Database::getInstance('localhost', 'root', "", 'shopping_system');
// Create an instance of the ItemRepository
$ItemRepository = new ItemRepository($db);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the conditions to check if the email and password exist
    $conditions = [
        'email' => $email,
        'password' => $password // Note: Avoid storing plain passwords in databases, use hashing
    ];

    // Check if the email and password combination exists
    $existingUsers = $ItemRepository->read('users', $conditions);

    if (empty($existingUsers)) {
        $_SESSION['exist']="Inavlid Username or Password";
        header('location:login.php');
    } else {
        // Retrieve user details and store them in the session
        $userDetails = $existingUsers[0]; // Assuming there's only one user with unique credentials

        $_SESSION['auth'] = [
            'name' => $userDetails['name'],
            'email' => $userDetails['email'],
            'phone' => $userDetails['phone'],
            'id' => $userDetails['id'],
            // Include other user details if needed
        ];

        header("location:userCategories.php");
        exit();
    }
}
