<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <style>
       body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }

        .buttons-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        button {
            padding: 10px 20px;
            margin: 10px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            color: #fff;
        }

        #adminBtn {
            background-color: #007bff;
        }

        #userBtn {
            background-color: #28a745;
        }

        .adminBtn {
            text-decoration: none;
            color: #fff;
        }

        .userBtn {
            text-decoration: none;
            color: #fff;
        }
    </style>
</head>
<body>
    <h2>Welcome In Design pattern Project</h2>
    <button id="adminBtn">
        <a class="adminBtn" href="addPage.php">Admin Dashboard</a>
    </button>
    <button id="userBtn">
        <a class="userBtn" href="login.php">User Page</a>
    </button>
</body>
</html>
