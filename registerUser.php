<?php
session_start();
include('Database.php'); // Include the Database class
include('ItemRepository.php'); // Include the ItemRepository class

// Create a database instance
$db = Database::getInstance('localhost', 'root', "" , 'shopping_system');
// Create an instance of the ItemRepository
$ItemRepository = new ItemRepository($db);
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpassword'];

    if (empty($name) || empty($email) || empty($phone) || empty($password) || empty($confirmpassword)) {
        $_SESSION['error'] = "All fields must not be empty.";
        header("location: register.php");
        exit(); // Add an exit after redirection
    } elseif ($password !== $confirmpassword) {
        $_SESSION['error'] = "Passwords do not match.";
        header("location: register.php");
        exit(); // Add an exit after redirection
    } else {
        $createData = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone, // Save the file path in the database
            'password' => $password,
            'confirm' => $confirmpassword,
            // Add other columns as needed
        ];
        // Assuming 'createUser' method exists in ItemRepository to handle user creation
        $result = $ItemRepository->create('users', $createData);
        if ($result === true) {
            // this line uses to save the info of the user info
            $loggedInUser = $ItemRepository->getUserByEmail($email);
            if ($loggedInUser) {
                $_SESSION['auth'] = $loggedInUser; // Store user info in session
                header("location:userCategories.php");
                $_SESSION['success'] = "Account Created Successfully";
            } else {
                $_SESSION['error'] = "Error fetching user information";
                header("location: register.php");
                exit();
            }
        } else {
            echo $result; // Display error message if any
        }
    
    }
}

