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

$db = Database::getInstance('localhost', 'root', "", 'shopping_system');
$ItemRepository = new ItemRepository($db);

// Get the user ID from the session
$userID = $_SESSION['auth']['id'];

// Fetch orders for the logged-in user
$orders = $ItemRepository->getOrdersByUserID('orders', $userID); // Replace this with your method to fetch orders by user ID

?>
<!DOCTYPE html>
<html>
<head>
    <title>User Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
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
    /* Add this CSS to style the delete button */
    button[type="submit"] {
        padding: 8px 16px;
        background-color: #f44336;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
        background-color: #d32f2f;
    }
    </style>
</head>
<body>

<!-- Your existing HTML content -->
<h2>User Order</h2>

<table>
    <tr>
        <th>Order ID</th>
        <th>User ID</th>
        <th>User Name</th>
        <th>Total Receipt</th>
        <th>Order Code</th>
        <th>Action</th>
        <!-- Add more table headers as needed -->
    </tr>
    <?php foreach ($orders as $order) : ?>
        <tr>
            <td><?php echo $order['id']; ?></td>
            <td><?php echo $order['user_id']; ?></td>
            <td><?php echo $order['user_name']; ?></td>
            <td><?php echo $order['total_price']; ?></td>
            <td><?php echo $order['payment']; ?></td>
            <td>
                <!-- Add a form with a delete button for each order -->
                <form action="deleteOrder.php" method="post">
                    <input type="hidden" name="orderID" value="<?php echo $order['id']; ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
            <!-- Display more order details as needed -->
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>