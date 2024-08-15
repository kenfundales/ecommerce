<?php
    include_once("connection.php");

    if(isset($_POST['login'])){
        $uname = $_POST['usern'];
        $pword = $_POST['passw'];

        session_start();

        $statement = $conn->prepare("SELECT customerId FROM customer_tbl WHERE username = :una AND password = :ikalawa");
        $statement->bindParam(":una", $uname);
        $statement->bindParam(":ikalawa", $pword);
        $statement->execute();

        $count = $statement->rowCount();

        if($count > 0){
            while($row = $statement->fetch()){
                $id = $row['customerId'];

                $_SESSION['cid'] = $id;
                header("Location:home.php");
            }
        } else {
            echo "<script>alert('Sorry, wrong Username or Password')</script>";
            echo "<script>window.open('login.php','_self')</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <title>Login</title>
    <style>
        body {
            font-family: 'Poppins',sans-serif;
            background-color: #303030;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            display: flex;
            width: 600px;
        }
        .background-container {
            background-image: url('pictures/bg.jpeg');
            background-size: cover;
            width: 50%;
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }
        input, button{
            font-family: 'Poppins',sans-serif;
        }
        .login-container {
            /* background-color: rgba(255,255,255,0.13);*/
            background-color: white;
            padding: 20px;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-container input {
            width: auto;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .login-container button:hover {
            background-color: #0056b3;
        }
        a {
            color: blue;
            font-size: 10px;
            padding-top: 10px;
        }
        .link-container {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <form action="" method="POST">
    <div class="container">
        <div class="background-container"></div>
        <div class="login-container">
            <h2>Login</h2>
            <input type="text" placeholder="Username" name="usern"required>
            <input type="password" placeholder="Password" name="passw" required>
            <button type="submit" name="login">Login</button>
            <div class="link-container">
                <a href="signup.php">Don't have an account?</a>
            </div>
        </div>
    </div>
    </form>
</body>
</html>
