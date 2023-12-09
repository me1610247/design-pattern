<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .create{
            text-decoration: none;
            color: #fff;
        }

        .close-btn {
            float: right;
            cursor: pointer;
        }

        .close-btn:hover {
            color: #000;
        }
        /* Removed form width, using Bootstrap classes for width */
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                
                <form method="POST" action="loginUser.php" class="shadow p-4"> <!-- Added shadow and padding utility classes -->
                <h2 class="text-center">Login Page</h2>
                <?php
                    if(isset($_SESSION['exist'])){
                    ?>
                <div class="alert alert-danger">
                        <?= $_SESSION['exist'] ;?>
                        <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
                    </div>
                    <?php
                    }
                    unset($_SESSION['exist']);;
                    ?>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>
                    <button  name="login" type="submit" class="btn btn-primary">Login</button>
                    <button  class="btn btn-success">
                        <a class="create" href="register.php">Create An Account</a>
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
