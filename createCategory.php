<?php
session_start();
include('Database.php');
include('ItemRepository.php');

// Create a database instance
$db = Database::getInstance('localhost', 'root', '', 'shopping_system');

// Create an instance of the ItemRepository
$ItemRepository = new ItemRepository($db);

$name = $_POST['name'];
$image_name = $_FILES['images']['name'];
$image_tmp = $_FILES['images']['tmp_name'];
$image_path = "uploads2/" . $image_name;

move_uploaded_file($image_tmp, $image_path);
// Move the uploaded file to the desired directory
    // File uploaded successfully, proceed to create item

    $createData = [
        'name' => $name,
        'image' => $image_name, // Save the file path in the database
        // Add other columns as needed
    ];

    $result = $ItemRepository->create('categories', $createData);
    if ($result === true) {
        header("location:addPage.php");
        $_SESSION['success2'] = "Category Created Successfully";
    } else {
        echo $result; // Display error message if any
    }
 
