
<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['auth'])) {
    // Redirect the user to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Include necessary files and create database and ItemRepository objects
include('Database.php');
include('ItemRepository.php');

// Create a database instance
$db = Database::getInstance('localhost', 'root', "", 'shopping_system'); // Replace with your actual database name

// Create an instance of the ItemRepository
$ItemRepository = new ItemRepository($db);

// Get the user's details from the session
$userDetails = $_SESSION['auth'];
$user_id = $_SESSION['auth']['id'];

// Fetch items from the cart for the logged-in user
$itemsForCheckout = $ItemRepository->getCartItemsByUser($user_id); // Replace with your method to get cart items by user's email

// Calculate total price for checkout
$totalPrice = 0; // Initialize total price
foreach ($itemsForCheckout as $item) {
    $totalPrice += $item['price_Sale']; // Add each item's price to the total
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <style>
         <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f8f8;
        }

        h1 {
            margin-bottom: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .user-details {
            margin-bottom: 30px;
            margin-top: 20px;
        }

        .user-details h2 {
            margin-bottom: 10px;
        }

        .user-details p {
            margin: 5px 0;
        }

        .items-for-checkout {
            margin-bottom: 30px;
        }

        .items-for-checkout h2 {
            margin-bottom: 10px;
        }

        .items-for-checkout ul {
            list-style: none;
            padding: 0;
        }

        .items-for-checkout li {
            margin-bottom: 5px;
        }

        .total-price {
            font-weight: bold;
            margin-top: 10px;
        }

        .order-form {
            margin-top: 20px;
        }
        
        .order-form input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .editProfile{
            padding: 10px;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .order-form input[type="submit"]:hover {
            background-color: #45a049;
        }
        .payment-form {
            margin-top: 20px;
        }

        .payment-form label {
            display: block;
            margin-bottom: 5px;
        }

        .payment-form input[type="text"], .payment-form select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
    </style>
    <!-- Your CSS stylesheets and other head content -->
</head>
<body>

    <h1>Checkout</h1>

    
    <div class="container">
    <div class="user-details">
        <h2>User Details</h2>
        <p>Name: <?php echo $userDetails['name']; ?></p>
        <p>Email: <?php echo $userDetails['email']; ?></p>
        <p>Phone: <?php echo $userDetails['phone']; ?></p>
        <!-- Add more user details as needed -->
    </div>
    <a class="editProfile" href="profile.php">Edit</a>

    </div>
    <br><br>
    <div class="container">
    <div class="items">
        <h2>Items for Checkout</h2>
        <?php if (!empty($itemsForCheckout)) : ?>
            <!-- Display items from the cart -->
            <span>Details</span>
               <?php foreach ($itemsForCheckout as $item) : ?>
                    <div class="card">
                    <br>
                <h3>Mobille Name :<?php echo ucwords($item['name']); ?></h3>
                <p>Price :$<?php echo $item['price_Sale']; ?></p>
                <p>Color :<?php echo $item['color']; ?></p>
                <p>Size :<?php echo $item['size']; ?>GB</p>
                <img src="<?php echo 'uploads/' . $item['images']; ?>" alt="Item Image">
                <?php endforeach; ?>
                <br>
                <hr>
                <p class="total-price">Total Price: $<?php echo $totalPrice; ?></p>

            <form class="order-form" action="placeOrder.php" method="post">
            <div class="payment-form">
    <h2>Payment Method</h2>
    <label for="paymentMethod">Payment Method</label>
    <select id="paymentMethod" name="paymentMethod" onchange="togglePaymentForm()">
        <option value="creditCard">Credit Card</option>
        <option value="fawry">Fawry Pay</option>
    </select>

    <!-- Credit Card Payment Form -->
    <div id="creditCardForm">
        <label for="cardType">Card Type</label>
        <img src="download(1).png" id="visaImage" width="100px" alt="Visa" style="display: none;">
        <select id="cardType" name="cardType">
            <option value="visa">Visa</option>
            <option value="mastercard">Mastercard</option>
            <option value="amex">American Express</option>
        </select>

        <label for="cardNumber">Card Number</label>
        <input  type="text" id="cardNumber" name="cardNumber" placeholder="Enter card number">

        <label for="expiryDate">Expiry Date</label>
        <input  type="text" id="expiryDate" name="expiryDate" placeholder="MM/YYYY">

        <label for="cvv">CVV</label>
        <input  type="text" id="cvv" name="cvv" placeholder="Enter CVV">
    </div>

    <!-- Fawry Pay Form (Initially Hidden) -->
    <div id="fawryForm" style="display: none;">
    <img src="download.png"  width="100px" id="fawryImage" alt="Fawry" style="display: none;">
    <label for="fawryCode">Fawry Code</label>
    <input  type="text" id="fawryCode" name="fawryCode" readonly>
    </div>
        </div>
                <input type="submit" name="placeOrder" value="Place Order">
            </form>
        <?php elseif (isset($_POST['mobileType']) && isset($_POST['mobileColor']) && isset($_POST['mobileSize'])) : ?>
            <!-- Display selected mobile details -->
            <p>Mobile Type: <?php echo $_POST['mobileType']; ?></p>
            <p>Mobile Color: <?php echo $_POST['mobileColor']; ?></p>
            <p>Mobile Size: <?php echo $_POST['mobileSize']; ?></p>
            <form class="order-form" action="placeDiffOrder.php" method="post">
                <!-- Add form fields for payment and shipping details -->
                <div class="payment-form">
                <h2>Payment Method</h2>
                <label for="cardType">Card Type</label>
                <select id="cardType" name="cardType">
                    <option value="visa">Visa</option>
                    <option value="mastercard">Mastercard</option>
                    <option value="amex">American Express</option>
                </select>

                <label for="cardNumber">Card Number</label>
                <input type="text" id="cardNumber" name="cardNumber" placeholder="Enter card number">

                <label for="expiryDate">Expiry Date</label>
                <input type="text" id="expiryDate" name="expiryDate" placeholder="MM/YYYY">

                <label for="cvv">CVV</label>
                <input type="text" id="cvv"  name="cvv" placeholder="Enter CVV">
            </div>
                <input type="submit" name="placeOrder" value="Place Order">
            </form>
        <?php else : ?>
            <p>No items</p>
        <?php endif; ?>
    </div>
    </div>
    </div>
    <script>
    function togglePaymentForm() {
        var paymentMethod = document.getElementById("paymentMethod").value;
        var creditCardForm = document.getElementById("creditCardForm");
        var fawryForm = document.getElementById("fawryForm");
        var visaImage = document.getElementById("visaImage");
        var fawryImage = document.getElementById("fawryImage");

        if (paymentMethod === "creditCard") {
            creditCardForm.style.display = "block";
            fawryForm.style.display = "none";
            visaImage.style.display = "block"; // Show Visa image
            fawryImage.style.display = "none"; // Hide Fawry image
        } else if (paymentMethod === "fawry") {
            creditCardForm.style.display = "none";
            fawryForm.style.display = "block";
            visaImage.style.display = "none"; // Hide Visa image
            fawryImage.style.display = "block"; // Show Fawry image
            // Generate a random code and display it in the Fawry Code input field
            var randomCode = generateRandomCode();
            document.getElementById("fawryCode").value = "929"+randomCode;
        }
    }

    function toggleCardType() {
        var cardType = document.getElementById("cardType").value;
        var visaFields = document.getElementsByClassName("visa-fields");

        if (cardType === "visa") {
            for (var i = 0; i < visaFields.length; i++) {
                visaFields[i].style.display = "block";
            }
        } else {
            for (var i = 0; i < visaFields.length; i++) {
                visaFields[i].style.display = "none";
            }
        }
    }

    // Function to generate a random code (example)
    function generateRandomCode() {
        var characters = "0123456789";
        var code = "";
        var codeLength = 13; // Adjust the code length as needed

        for (var i = 0; i < codeLength; i++) {
            var randomIndex = Math.floor(Math.random() * characters.length);
            code += characters.charAt(randomIndex);
        }

        return code;
    }
</script>
</body>
</html>
