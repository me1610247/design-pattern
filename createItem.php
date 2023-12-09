<?php
session_start();
include('Database.php');
include('ItemRepository.php');

// Create a database instance
$db = Database::getInstance('localhost', 'root', '', 'shopping_system');

// Create an instance of the ItemRepository
$ItemRepository = new ItemRepository($db);

$name = $_POST['name'];
$color = $_POST['color'];
$size = $_POST['size'];
$category = $_POST['category'];
$details = $_POST['details'];
$image_name = $_FILES['images']['name'];
$image_tmp = $_FILES['images']['tmp_name'];
$image_path = "uploads/" . $image_name;

move_uploaded_file($image_tmp, $image_path);
$price=$_POST['price'];
$sale = $_POST['sale'];
$salePrice = $price * (1 - ($sale / 100)); // Adjust for percentage
// Move the uploaded file to the desired directory
    // File uploaded successfully, proceed to create item

    $createData = [
        'name' => $name,
        'color' => $color,
        'size' => $size,
        'item_category'=>$category,
        'details' => $details,
        'images' => $image_name, // Save the file path in the database
        'price' => $price,
        'price_sale' => $salePrice,
        // Add other columns as needed
    ];

    $result = $ItemRepository->create('items', $createData);
    if ($result === true) {
        header("location:addPage.php");
        $_SESSION['success'] = "Item Created Successfully";
    } else {
        echo $result; // Display error message if any
    }
 
