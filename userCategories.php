<?php
include("connection.php");
session_start();
$sql = "SELECT * FROM categories";
$sql_run = mysqli_query($conn, $sql);
$user_id = $_SESSION['auth']['id'];
$sql = "SELECT * FROM orders WHERE user_id = '$user_id'"; // Replace 'id' with the actual column name in your users table
$result = mysqli_query($conn, $sql);

?>
   <?php
    if (isset($_SESSION['addSuccess'])) {
        ?>
        <div class="add message">
            <?= $_SESSION['addSuccess'] ?>;
        </div>
        <?php
    }
    unset($_SESSION['addSuccess']);
    ?>
   <?php
    if (isset($_SESSION['order'])) {
        ?>
        <div class="order done">
            <?= $_SESSION['order'] ?>;
        </div>
        <?php
    }
    unset($_SESSION['order']);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Categories</title>
    </head>
    <body>
        <h2 class="title">Categories</h2>
            <!-- Display "View Order" button if orders exist -->
    <?php if (mysqli_num_rows($result) > 0) : ?>
        <div class="view-order-btn">
            <a class="order-view" href="viewOrders.php">View Order</a>
        </div>
    <?php endif; ?>

    </body>
    </html>
<div class="container">
    <?php
    if (mysqli_num_rows($sql_run) > 0) {
        foreach ($sql_run as $category) {
            $category_id = $category['id']; // Get the category ID
            ?>
            <div class="card">
            <p class="name"><?= ucwords($category['name']) ?></p>
                <div class="image-container">
                    <img width="200px" height="150px" src="uploads2/<?= $category['image'] ?>" alt="<?= $category['name'] ?>">
                </div>
                <div class="buttons">
                    <a href="products.php?category=<?= $category_id ?>"><button class="view-products-btn">View Products</button></a> <!-- Add a new button to view products for the category -->
                </div>
            </div>
    <?php
        }
    }
    ?>
</div>
<div class="viewCart">
<a class="cart" href="cartPage.php">View Cart</a>
</div>
<div class="order_diffbtn">
<a class="order_diff" href="createMobile.php">Order Specific Item</a>
</div>

<style>
    .title{
        text-align: center;
    }
    .cart{
        text-decoration: none;
        color: wheat;
    }
    .order_diff{
        text-decoration: none;
        color: wheat;
    }
    .viewCart{
        position: fixed;
    bottom: 20px; /* Adjust this value to position the button vertically */
    right: 20px; /* Adjust this value to position the button horizontally */
    padding: 10px 20px;
    background-color: #3498db;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-align: center;
    font-size: 16px;
    transition: background-color 0.3s ease;
    }
    .order_diffbtn{
        bottom: 20px; /* Adjust this value to position the button vertically */
    right: 20px; /* Adjust this value to position the button horizontally */
    padding: 10px 20px;
    background-color: #3498db;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-align: center;
    font-size: 16px;
    transition: background-color 0.3s ease;
    width: 200px;
    transform: translateX(220%);
    }
    .container {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
    }
    .view-products-btn {
        padding: 8px 16px;
        background-color: #007bff;
        color: #fff;
        border: none;
        text-decoration: none;
        cursor: pointer;
        border-radius: 4px;
        margin-left: 15px;
        transform: translate(65%);
    }


    .view-products-btn:hover {
        background-color: #0056b3;
    }
    /* Add this CSS to style the "View Order" button */
.order-view-btn {
    text-align: center;
    margin-top: 20px;
}

.order-view {
    padding: 10px 20px;
    background-color: #3498db;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-align: center;
    font-size: 16px;
    transition: background-color 0.3s ease;
    text-decoration: none;
}

.order-view:hover {
    background-color: #2980b9;
}

    .card {
        width: 300px;
        border-radius: 8px;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        padding: 16px;
        opacity: 0;
        animation: fade-in 0.5s ease-in-out forwards;
        margin: 16px;
        background-color: #fff;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        border: 1px solid silver;
    }

    .image-container {
        width: 100%;
        text-align: center;
        margin-bottom: 8px;
    }

    .image-container img {
        max-width: 60%;
        height: auto;
        border-radius: 4px;
    }

    .delete {
        width: 300px;
        background-color: #f8d7da;
        color: #721c24;
        padding: 15px;
        border-radius: 10px;
        margin: 20px auto;
        text-align: center;
    }

    .delete.message {
        background-color: #f8d7da;
        color: #721c24;
    }

    .name {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 8px;
        text-align: center;
    }
    .add {
        width: 300px;
        background-color: #4CAF50;
        color: #fff;
        padding: 15px;
        border-radius: 10px;
        margin: 20px auto;
        text-align: center;
    }

    .add.message {
        background-color: #4CAF50;
        color: #fff;
    }
    .order {
        width: 300px;
        background-color: #4CAF50;
        color: #fff;
        padding: 15px;
        border-radius: 10px;
        margin: 20px auto;
        text-align: center;
    }
    .order.done {
        background-color: #4CAF50;
        color: #fff;
    }


    .buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 16px;
    }
    @keyframes fade-in {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .edit-btn,
    .delete-btn {
        padding: 8px 16px;
        background-color: #4CAF50;
        color: #fff;
        border: none;
        text-decoration: none;
        cursor: pointer;
        border-radius: 4px;
    }

    .delete-btn {
        background-color: #f44336;
    }

    .edit-btn:hover {
        background-color: #45a049;
    }
</style>