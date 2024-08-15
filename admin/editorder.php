<?php
    include_once("../connection.php");
    session_start();
    include_once("session.php");

    $uid = $_GET['uid'];
    $select = $conn->prepare("SELECT * FROM order_tbl WHERE orderId=:uid");
    $select->bindParam(":uid", $uid);
    $select->execute();

    while($row = $select->fetch()){
        $pangalan = $row['shoesize'];
    }
    if(isset($_POST['update'])){
        $name1 = $_POST['progress'];

        $query = $conn->prepare("UPDATE order_tbl SET actionn=:una WHERE orderId=:uid");
        $query->bindParam(":una", $name1);
        $query->bindParam(":uid", $uid);
        $query->execute();
        
        echo "<script>alert('Successfully edited a product!')</script>";
        echo "<script>window.open('orders.php','_self')</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <title>Edit Order</title>
    <style>
        /*---start of nav bar css---*/
        body {
            font-family: 'Poppins',sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .container{
            width: 100%;
            display: flex;
        }
        .navbar-container {
            width: 15%;
            background-color:burlywood;
        }
        .navbar-container a {
            padding: 15px;
            color: black;
            font-size: 15px;
            text-decoration: none;
            display: block;
        }
        .navbar-container a:hover{
            background-color: #ddd;
        }
        /*---end of nav bar css---*/
        .contents {
            width: 80%;
            padding: 10px;
        }
        .contents input{
            display: block;
            font-family: 'Poppins',sans-serif;
            width: 700px;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .contents textarea{
            display: block;
            font-family: 'Poppins',sans-serif;
            min-width: 700px;
            min-height: 150px;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        label {
            font-size: 11px;
            color:gray;
        }
        #upbutt {
            background-color: red;
            font-family: 'Poppins',sans-serif;
            color:white;
            border-radius: 5px;
            border: none;
        }
        #upbutt:hover{
            background-color: green;
            cursor: pointer;
        }
        #psinfo {
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="navbar-container">
            <a href="index.php">Home</a>
            <a href="addproduct.php">Products</a>
            <a href="orders.php">Orders</a>
            <a href="users.php">Users</a>
            <a href="logout.php">Logout</a>
        </div>
        <div class="contents">
        <form action="" method="POST" enctype="multipart/form-data">
        <h2>Edit Progress of Order</h2>
            <span>Progress: </span>
            <select name="progress" class="selectdrpdown" required>
                <option value="" disabled selected>Select progress</option>
                <option name="progress" value="Processing">Processing</option>
                <option name="progress" value="On delivery">On delivery</option>
                <option name="progress" value="Delivered">Delivered</option>
            </select>
            <button type="submit" name="update" id="upbutt">Update Order</button>
        </div>
    </form>
    </div>
</body>
</html>