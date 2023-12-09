<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            color: #333;
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

        input[type="text"],
        input[type="email"],
        input[type="submit"] {
            width: calc(100% - 10px);
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <h1>User Profile</h1>
        <?php
        $userEmail = $_SESSION['auth']['email']; // Fetch user's email from the session
        $userName = $_SESSION['auth']['name']; // Fetch user's email from the session
        $userPhone = $_SESSION['auth']['phone']; 
        ?>
    <form action="updateProfile.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?= $userName ?>"><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= $userEmail?>" readonly><br><br>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?= $userPhone ?>"><br><br>

        <!-- Add more fields as needed -->

        <input type="submit" name="update" value="Update">
    </form>

</body>
</html>
