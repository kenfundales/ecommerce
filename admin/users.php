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
            <h2>Users</h2>
            <table>
                <tr>
                    <td>Name of the Customer</td>
                    <td>Username</td>
                    <td>Email</td>
                    <td>Phone</td>
                    <td>Address</td>
                </tr>
                <?php 
                $select = $conn->prepare("SELECT * FROM customer_tbl");
                $select->execute();

                while($row = $select->fetch()){
                    $id = $row['customerId'];
                    $fname = $row['firstname'];
                    $mname = $row['middlename'];
                    $lname = $row['lastname'];
                    $email = $row['email'];
                    $uname = $row['username'];
                    $tirahan = $row['address'];
                    $siyudad = $row['city'];
                    $telepono = $row['phone'];
                    $postal = $row['postal'];
                    $bansa = $row['country'];
            ?>
                <tr>
                    <td><?php echo $fname." ". $mname." ". $lname;?></td>
                    <td><?php echo $uname;?></td>
                    <td><?php echo $email;?></td>
                    <td><?php echo $telepono;?></td>
                    <td><?php echo $tirahan.", ". $siyudad.", ". $postal.", ".$bansa;?></td>
                </tr>
                <?php 
                    
                    }
                ?>
            </table>
    </div>
</body>
</html>