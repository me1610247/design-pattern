<?php
session_start(); // Ensure the session is started before using $_SESSION
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['placeOrder'])) {
    $servername = 'localhost';
    $username = 'root';
    $password = ''; // Replace with your actual database password
    $dbname = 'shopping_system';

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $user_id = $_SESSION['auth']['id'];
        // Prepare the SQL statement for insertion
        $stmt = $conn->prepare("INSERT INTO diff_order (user_id, type, color, size, price) VALUES (:user_id, :mobileType, :mobileColor, :mobileSize, :price)");

        // Bind parameters and execute the query
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':mobileType', $_POST['mobileType']);
        $stmt->bindParam(':mobileColor', $_POST['mobileColor']);
        $stmt->bindParam(':mobileSize', $_POST['mobileSize']);
        $stmt->bindParam(':price', $_POST['price']);

        // Execute the query
        $stmt->execute();

        // Redirect to a thank you page or wherever needed after successful insertion
        header('Location: userCategories.php');
        exit();
    } catch (PDOException $e) {
        // Handle database connection error or insertion failure
        echo "Error: " . $e->getMessage();
    }
}
?>
