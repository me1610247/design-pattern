<!DOCTYPE html>
<html>
<head>
    <title>Item List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e5e5e5;
        }

        .action-btns {
            display: flex;
            gap: 10px;
        }

        .edit-btn, .delete-btn {
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
        }

        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
        }

        .edit-btn:hover, .delete-btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
        
<?php
include('Database.php');
include('ItemRepository.php');

$db = Database::getInstance('localhost', 'root', "", 'shopping_system');
$ItemRepository = new ItemRepository($db);
$items = $ItemRepository->get('items');

echo '<table>';
echo '<tr><th>ID</th><th>Name</th><th>Category</th><th>Color</th><th>Size</th><th>Price</th><th>Details</th><th>Images</th><th>Action</th><th>Action</th></tr>';
foreach ($items as $item) {
    echo '<tr>';
    echo '<td>' . $item['id'] . '</td>';
    echo '<td>' . $item['name'] . '</td>';
    echo '<td>' . $item['item_category'] . '</td>';
    echo '<td>' . $item['color'] .  '</td>';
    echo '<td>' . $item['size'] . "GB".'</td>';
    echo '<td>' . $item['price'] . '</td>';
    echo '<td>' . $item['details'] . '</td>';
    echo '<td>
    <img src="uploads/' . $item['images'] . '" alt="Item Image" style="width:100px;height:auto;">
    </td>'; // Display image using <img> tag

    // Edit button
    echo '<td>';
    echo '<form action="editItem.php" method="post" class="action-btns">';
    echo '<input type="hidden" name="editItemId" value="' . $item['id'] . '">';
    echo '<button class="edit-btn" type="submit">Edit</button>';
    echo '</form>';
    echo '</td>';

    // Delete button
    echo '<td>';
    echo '<form action="deleteItem.php" method="post" class="action-btns">';
    echo '<input type="hidden" name="deleteItemId" value="' . $item['id'] . '">';
    echo '<button class="delete-btn" type="submit">Delete</button>';
    echo '</form>';
    echo '</td>';

    echo '</tr>';
}
echo '</table>';
?>

</body>
</html>
