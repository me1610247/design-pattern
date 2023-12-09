<?php
include('Database.php');
include('ItemRepository.php');
$db = Database::getInstance('localhost', 'root', "", 'shopping_system');

$ItemRepository = new ItemRepository($db);
$items = $ItemRepository->get('items');

$selectedPrice = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedType = $_POST['mobileType'];
    $selectedColor = $_POST['mobileColor'];
    $selectedSize = $_POST['mobileSize'];

    // Retrieve the price based on the selected mobile type
    foreach ($items as $item) {
        if ($item['name'] === $selectedType && $item['color'] === $selectedColor && $item['size'] === $selectedSize) {
            $selectedPrice = $item['price']; // Assuming 'price' is the field containing the price information
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Configuration</title>
     <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h2 {
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        select,
        input[type="hidden"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }
        </style>
</head>
<body>
    <h2>Mobile Configuration</h2>
    <form action="createMobileBuilder.php" method="post">
        <label for="mobileType">Mobile Type:</label>
        <select id="mobileType" name="mobileType">
            <?php
            foreach ($items as $item) {
                echo "<option value='" . htmlspecialchars($item['name']) . "'>" . htmlspecialchars($item['name']) . "</option>";
            }
            ?>
        </select>
        <br>
        <label for="mobileColor">Mobile Color:</label>
        <select id="mobileColor" name="mobileColor">
            <?php
            foreach ($items as $item) {
                echo "<option value='" . htmlspecialchars($item['color']) . "'>" . htmlspecialchars($item['color']) . "</option>";
            }
            ?>
        </select>
        <br>
        <label for="mobileSize">Mobile Size:</label>
        <select id="mobileSize" name="mobileSize">
            <?php
            foreach ($items as $item) {
                echo "<option value='" . htmlspecialchars($item['size']) . "'>" . htmlspecialchars($item['size']) . "</option>";
            }
            ?>
        </select>
        <br>
        <!-- Input field to hold the selected price -->
        <input type="hidden" name="priceSelected" value="<?= $selectedPrice ?>">
        <button type="submit">Order Mobile</button>
    </form>
</body>
</html>
