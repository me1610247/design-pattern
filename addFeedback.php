<?php
include('Database.php');
include('ItemRepository.php');

// Create a database instance
$db = Database::getInstance('localhost', 'root', "", 'shopping_system');
$ItemRepository = new ItemRepository($db);

// Check if the item ID is provided via GET or POST
$itemId = isset($_GET['addFeedback']) ? $_GET['addFeedback'] : (isset($_POST['addFeedback']) ? $_POST['addFeedback'] : null);

if ($itemId) {
    $item = $ItemRepository->getById('cart',$itemId);

    if ($item) {
        // Display the item details in an edit form
?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Feedback</title>
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

        input[type="text"]
         {
            width: 250px;
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
        .feedback{
            width: 500px;
            height: 100px;
        }
    </style>
        </head>
        <body>
            <h2>Add Feedback To Item</h2>
            <form action="saveFeedback.php" method="post">
                <input type="hidden" name="itemId" value="<?php echo $item['id']; ?>">
                <label for="itemName">Name:</label><br>
                <input type="text" readonly id="itemName" name="itemName" value="<?php echo $item['name']; ?>"><br><br>
                <label for="itemName">Price:</label><br>
                <input type="number" readonly id="itemName" name="itemPrice" value="<?php echo $item['price']; ?>"><br><br>
                <label for="itemImages">Images:</label><br><?php
                echo '<img src="uploads/' . $item['images'] . '" width="150px" alt="Item Image">';
                ?>
                <br>
                <textarea class="feedback" name="feedback" rows="5" cols="20" placeholder="Write your feedback here"></textarea><br><br>
                <input type="submit" value="Submit Feedback">
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
