<?php
    include_once("../connection.php");
    session_start();
    include_once("session.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <title>Orders</title>
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
        table, td{
            border: 1px solid black;
            text-align: center;
            border-collapse: collapse;
        }
        table td a {
            text-decoration: none;
        }
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
        #addbutt {
            background-color: red;
            font-family: 'Poppins',sans-serif;
            color:white;
            border-radius: 5px;
            border: none;
        }
        #addbutt:hover{
            background-color: green;
            cursor: pointer;
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
            <h2>Orders</h2>
            <?php 
                $select = $conn->prepare("SELECT order_tbl.*, customer_tbl.*, product_tbl.* FROM order_tbl INNER JOIN customer_tbl ON order_tbl.customerId = customer_tbl.customerId INNER JOIN product_tbl ON order_tbl.productId = product_tbl.productId ORDER BY order_tbl.orderId DESC");
                $select->execute();
            ?>
            <table>
                <tr>
                    <td>Name of the Customer</td>
                    <td>Image</td>
                    <td>Product</td>
                    <td>Category</td>
                    <td>Price</td>
                    <td>Shoe Size</td>
                    <td>Qty</td>
                    <td>Total Price</td>
                    <td>Progress</td>
                    <td>Action</td>
                </tr>
                <?php 
                    while($row = $select->fetch()){
                        echo "<tr>";
                        echo "<td>{$row['firstname']} {$row['lastname']}</td>";
                        echo "<td><img src=\"../shoes/{$row['picture']}\" alt=\"Picture\" width=\"100\"></td>";
                        echo "<td>{$row['productName']}</td>";
                        echo "<td>{$row['category']}</td>";
                        echo "<td>{$row['price']}</td>";
                        echo "<td>{$row['shoesize']}</td>";
                        echo "<td>{$row['qty']}</td>";
                        echo "<td>{$row['totalPrice']}</td>";
                        echo "<td>{$row['actionn']}</td>";
                        echo "<td><a href=\"editorder.php?uid={$row['orderId']}\">Edit</a></td>";
                        echo "</tr>";
                    }
                ?>
            </table>
        </div>
    </div>
</body>
</html>