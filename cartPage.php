<?php
session_start();
include('connection.php');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Item List</title>
  <style>
    body{
      background-color: #f2f2f2;
    }
    .item-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center; /* To center the items horizontally */
      padding: 20px;
      background-color: #f2f2f2;
      margin-top: 20px;
    }

    .item-card {
      width: 300px;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      background-color: #fff;
      margin-bottom: 20px;
    }

    .item-card h3 {
      font-size: 20px;
      margin-bottom: 10px;
    }

    .item-card p {
      margin-bottom: 5px;
    }

    .item-card img {
      width: 100px;
      height: auto;
      margin-bottom: 10px;
    }

    .action-btns {
      display: flex;
      gap: 10px;
      margin-top: 10px;
    }

    .edit-btn, .delete-btn,.browse-btn {
      padding: 6px 12px;
      border-radius: 4px;
      cursor: pointer;
      text-align: center;
    }

    .edit-btn {
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 5px;
    }

    .delete-btn {
      background-color: #f44336;
      color: white;
      border: none;
      border-radius: 5px;
    }
    .browse-btn {
      background-color: #3498db;
      color: white;
      border: none;
      border-radius: 5px;
      text-decoration: none;
    }

    .edit-btn:hover, .delete-btn:hover {
      opacity: 0.8;
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

   /* ... existing CSS ... */

  

    .order-btn {
  position: fixed;
  top: 95%;
  left: 50%;
  transform: translate(-50%, -50%);
  padding: 10px 20px; /* Adjust padding as needed */
  background-color: #3498db;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  font-size: 18px; /* Adjust font size as needed */
  transition: background-color 0.3s ease;
}

.order-btn:hover {
  background-color: #2980b9;
}
    .checkout-btn {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.cart-title {
            text-align: center;
            margin-bottom: 10px;
            transform: translateX(120%);
            transform: translateY(-5%);
        }

        .item-cart {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
            background-color: #f2f2f2;
            transform: translateY(10%);
        }

        .checkout-btn {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            transform: translateX(-40%);
        }

        .checkout-btn a {
            padding: 10px 20px;
            background-color: #2ecc71;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease;
            display: inline-block;
        }

        .checkout-btn a:hover {
            background-color: #27ae60;
        }
  </style>
</head>
<body>
<?php
// Check if the user is logged in
if (!isset($_SESSION['auth'])) {
    // Redirect the user to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Display feedback message if available
echo '<h2 class="cart-title">Your Cart</h2>';
if (isset($_SESSION['feedback'])) {
    echo '<div class="alert alert-success">' . $_SESSION['feedback'] . '<span class="close-btn" onclick="this.parentElement.style.display=\'none\';">&times;</span></div>';
    unset($_SESSION['feedback']);
}


?>
<div class="item-container">
    <div class="item-cart">
        <?php
        include('Database.php');
        include('ItemRepository.php');
        
        $db = Database::getInstance('localhost', 'root', "", 'shopping_system');
        $ItemRepository = new ItemRepository($db);
        
        // Get the user ID from the session
        $user_id = $_SESSION['auth']['id'];
        
        // Fetch items from the cart for the logged-in user
        $items = $ItemRepository->getCartItemsByUser($user_id);
        // Check if items are present before attempting to display them
        if (!empty($items)) {
            foreach ($items as $item) {
                echo '<div class="item-card">';
                echo '<h3>' . $item['name'] . '</h3>';
                echo '<p>Price: ' . $item['price_Sale'] . '</p>';
                echo '<p>Color: ' . $item['color'] . '</p>';
                echo '<p>Size: ' . $item['size'] . '</p>';
                echo '<p>Details: ' . $item['details'] . '</p>';
                echo '<img src="uploads/' . $item['images'] . '" alt="Item Image">';
                echo '<div class="action-btns">';
                echo '<form action="addFeedback.php" method="post" class="action-btns">';
                echo '<input type="hidden" name="addFeedback" value="' . $item['id'] . '">';
                echo '<button class="edit-btn">Add Feedback</button>';
                echo '</form>';
                echo '<form action="deleteCart.php" method="post" class="action-btns">';
                echo '<input type="hidden" name="deleteItemId" value="' . $item['id'] . '">';
                echo '<button class="delete-btn" type="submit">Delete</button>';
                echo '</form>';
                echo '<form action="userCategories.php" class="action-btns">';
                echo '<input type="hidden" name="deleteItemId" value="' . $item['id'] . '">';
                echo '<button class="browse-btn" type="submit">Browse Items</button>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>Your cart is empty.</p>';
        }
        ?>
    </div>
    <a href="checkout.php" class="order-btn">Order Now</a>
</div>
</body>

</html>
