<?php
session_start();
include('Database.php');
include('ItemRepository.php');

$db = Database::getInstance('localhost', 'root', "", 'shopping_system');
$ItemRepository = new ItemRepository($db);
$categories = $ItemRepository->get('categories');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Item Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],input[type="number"],
        textarea {
            width: calc(100% - 12px);
            padding: 6px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-success {
            color: #3c763d;
            background-color: #dff0d8;
            border-color: #d6e9c6;
        }

        .close-btn {
            float: right;
            cursor: pointer;
        }

        .close-btn:hover {
            color: #000;
        }
    </style>
</head>
<body>
    <form action="createCategory.php" method="post" enctype="multipart/form-data" >
    <h2>Create New Category</h2>
    <?php
    if(isset($_SESSION['success2'])){
    ?>
   <div class="alert alert-success">
        <?= $_SESSION['success2'] ;?>
        <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
    </div>
    <?php
    }
    unset($_SESSION['success2']);
    ?>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" placeholder="Enter The Category Name">
        <label for="images">Image:</label>
        <input type="file" id="images" name="images" placeholder="Enter Category Image">
        <br><br>
        <input type="submit" value="Create Category">
    </form>
    <br><br>
    <form action="createItem.php" method="post" enctype="multipart/form-data" >
    <h2>Create New Item</h2>
    <?php
    if(isset($_SESSION['success'])){
    ?>
   <div class="alert alert-success">
        <?= $_SESSION['success'] ;?>
        <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
    </div>
    <?php
    }
    unset($_SESSION['success']);;
    ?>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" placeholder="Enter The Item Name">
        <label for="color">Color:</label>
        <input type="text" id="color" name="color" placeholder="Enter The Item Color">
        <label for="size">Size:</label>
        <input type="number" id="size" name="size" placeholder="Enter The Item Size">
        <label for="name">Price:</label>
        <input type="number" id="price" name="price" placeholder="Enter Item Price">
        <label for="name">Sale:</label>
        <input type="number" id="sale" name="sale" placeholder="Add The Precent of The Discount">
        <label for="details">Details:</label>
        <input type="text" id="details" name="details" placeholder="Enter Item Details">
        <label for="images">Image:</label>
        <input type="file" id="images" name="images" placeholder="Enter Item Image">
        <br><br>
        <label for="itemCategory">Category:</label>
        <select id="itemCategory" name="category">
            <?php
            // Populate dropdown options with fetched categories
            foreach ($categories as $category) {
                echo '<option value="' . htmlspecialchars($category['name']) . '">' . htmlspecialchars($category['name']) . '</option>';
            }
            ?>
        </select>
        <br><br>
        <input type="submit" value="Create Item">
    </form>
    <br><br>
    <form action="viewItems.php" method="post">
    <h2>View Items</h2>
        <input type="submit" value="View Items">
    </form>
    <br><br>
    <form action="viewCategories.php" method="post">
    <h2>View Categories</h2>
        <input type="submit" value="View Category">
    </form>
    <br><br>
    <form action="AdminOrders.php" method="post">
    <h2>Show Orders</h2>
        <input type="submit" value="View Order">
    </form>
    <br><br>
    <form action="users.php" method="post">
    <h2>Show Users</h2>
        <input type="submit" value="View Users">
    </form>
</body>
</html>
