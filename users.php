<?php
session_start();
include('Database.php');
include('ItemRepository.php');

// Check if the user is logged in

$db = Database::getInstance('localhost', 'root', "", 'shopping_system');
$ItemRepository = new ItemRepository($db);

// Get the user ID from the session

// Fetch orders for the logged-in user
$users = $ItemRepository->get('users'); // Replace this with your method to fetch orders by user ID

?>
<!DOCTYPE html>
<html>
<head>
    <title>Users List</title>
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
<h2>Users List</h2>

<table>
    <tr>
        <th>User ID</th>
        <th>User Name</th>
        <th>User Phone</th>
        <th>User Email</th>
        <th>Action</th>
        <!-- Add more table headers as needed -->
    </tr>
    <?php foreach ($users as $user) : ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['name']; ?></td>
            <td><?php echo $user['phone']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td>
                <!-- Add a form with a delete button for each order -->
                <form action="deleteUser.php" method="post">
                    <input type="hidden" name="userId" value="<?php echo $user['id']; ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
            <!-- Display more order details as needed -->
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>