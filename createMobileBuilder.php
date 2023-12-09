<?php
class Mobile {
    private $mobileType;
    private $mobileColor;
    private $mobileSize;
    private $price;
    
    public function __construct($mobileType, $mobileColor, $mobileSize, $price) {
        $this->mobileType = $mobileType;
        $this->mobileColor = $mobileColor;
        $this->mobileSize = $mobileSize;
        $this->price = $price;
    }
    
    public function getMobileType() {
        return $this->mobileType;
    }
    
    public function getMobileColor() {
        return $this->mobileColor;
    }
    
    public function getMobileSize() {
        return $this->mobileSize;
    }
    
    public function getPrice(){
        return $this->price;
    }
}

class MobileBuilder {
    private $mobileType;
    private $mobileColor;
    private $mobileSize;
    private $price;
  
    public function setMobileType($mobileType) {
        $this->mobileType = $mobileType;
        return $this;
    }
  
    public function setMobileColor($mobileColor) {
        $this->mobileColor = $mobileColor;
        return $this;
    }
  
    public function setMobileSize($mobileSize) {
        $this->mobileSize = $mobileSize;
        return $this;
    }
  
    public function build() {
        // In this version, the price is not set directly but fetched dynamically.
        // You can add further logic here to fetch the price from the database.
        $fetchedPrice = $this->fetchPriceFromDatabase(); // Function to retrieve the price based on selected mobile details

        return new Mobile(
            $this->mobileType,
            $this->mobileColor,
            $this->mobileSize,
            $fetchedPrice, // Use the fetched price
        );
    }

    private function fetchPriceFromDatabase() {
        // Assuming you're using PDO for database operations
        $servername = 'localhost';
        $username = 'root';
        $password = ''; // Replace with your actual database password
        $dbname = 'shopping_system';
    
        try {
            // Create connection
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // Set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Fetch the price from the database based on selected mobile details
            $stmt = $conn->prepare("SELECT price FROM items WHERE name = :mobileType AND color = :mobileColor AND size = :mobileSize");
            $stmt->bindParam(':mobileType', $this->mobileType);
            $stmt->bindParam(':mobileColor', $this->mobileColor);
            $stmt->bindParam(':mobileSize', $this->mobileSize);
            $stmt->execute();
    
            // Fetch the result
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($result && isset($result['price'])) {
                return $result['price'];
            } else {
                return "No Price Available For This Item"; // No price found for the selected mobile configuration
            }
        } catch (PDOException $e) {
            // Handle database connection error
            return null;
        }
    }
    
    
}

// Retrieve form inputs
$mobileType = $_POST['mobileType'];
$mobileColor = $_POST['mobileColor'];
$mobileSize = $_POST['mobileSize'];

// Create and build the mobile object
$mobile = (new MobileBuilder())
    ->setMobileType($mobileType)
    ->setMobileColor($mobileColor)
    ->setMobileSize($mobileSize)
    ->build();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Configuration Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h2,p {
            text-align: center;
        }

        .mobile-details {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .mobile-details p {
            margin-bottom: 10px;
        }

        .order-form {
            text-align: center;
        }

        .order-form input[type="submit"] {
            padding: 10px 20px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .order-form input[type="submit"]:hover {
            background-color: #45a049;
        }
        .khawas{
            font-weight: bold;
        }
    </style>
    
</head>
<body>
  <h2>Mobile Configuration Result</h2>
  <p><span class="khawas">Mobile Type </span>: <?php echo $mobile->getMobileType(); ?></p>
  <p>M<span class="khawas">Mobile Color </span>: <?php echo $mobile->getMobileColor(); ?></p>
  <p><span class="khawas">Mobile Size</span>: <?php echo $mobile->getMobileSize(); ?></p>
  <p class="khawas">Price: <?php echo $mobile->getPrice(); ?></p>
  <?php if ($mobile->getPrice() !== "No Price Available For This Item"): ?>
    <form class="order-form" action="order_diff.php" method="post">
    <!-- Add form fields for payment and shipping details -->
    <input type="hidden" name="mobileType" value="<?php echo $mobile->getMobileType(); ?>">
    <input type="hidden" name="mobileColor" value="<?php echo $mobile->getMobileColor(); ?>">
    <input type="hidden" name="mobileSize" value="<?php echo $mobile->getMobileSize(); ?>">
    <input type="hidden" name="price" value="<?php echo $mobile->getPrice(); ?>">
    <input type="submit" name="placeOrder" value="Place Order">
</form>
    <?php endif; ?>
</body>
</html>
