<?php
include('Database.php');
include('ItemRepository.php');

// Create a database instance
$db = Database::getInstance('localhost', 'root', "", 'shopping_system');
$ItemRepository = new ItemRepository($db);

// Check if the item ID is provided via GET or POST
$itemId = isset($_GET['editItemId']) ? $_GET['editItemId'] : (isset($_POST['editItemId']) ? $_POST['editItemId'] : null);

if ($itemId) {
    $item = $ItemRepository->getById('items',$itemId);

    if ($item) {
        // Display the item details in an edit form
?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Edit Item</title>
            <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
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
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
        </head>
        <body>
            <h2>Edit Item</h2>
            <form action="updateItem.php" method="post">
                <input type="hidden" name="itemId" value="<?php echo $item['id']; ?>">
                <label for="itemName">Name:</label><br>
                <input type="text" id="itemName" name="itemName" value="<?php echo $item['name']; ?>"><br><br>
                <label for="itemPrice">Price:</label><br>
                <input type="text" id="itemPrice" name="itemPrice" value="<?php echo $item['price']; ?>"><br><br>
                <label for="itemPrice">Sale:</label><br>
                <input type="text" id="itemSale" name="itemSale" value="<?php echo $item['price']; ?>"><br><br>
                <label for="itemDetails">Details:</label><br>
                <textarea id="itemDetails" name="itemDetails"><?php echo $item['details']; ?></textarea><br><br>
                <label for="itemImages">Images:</label><br>
                <input type="text" id="itemImages" name="itemImages" value="<?php echo $item['images']; ?>"><br><br>
                <input type="submit" value="Update Item">
            </form>
        </body>
        </html>
<?php
    } else {
        echo "Item not found!";
    }
} else {
    echo "Item ID not provided!";
}
?>
