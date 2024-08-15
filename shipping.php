<?php
session_start();
include_once("session.php");
include_once("cartcounter.php");
include_once("connection.php");
    $uid = $_SESSION['cid'];
    $select = $conn->prepare("SELECT * FROM customer_tbl WHERE customerId=:uid");
    $select->bindParam(":uid", $uid);
    $select->execute();

    while($row = $select->fetch()){
        $address = $row['address'];
        $city = $row['city'];
        $phone = $row['phone'];
        $posta = $row['postal'];
        $country = $row['country'];
    }
    if(isset($_POST['next'])){
        $tirahan = $_POST['addre'];
        $siyudad = $_POST['city'];
        $telepono = $_POST['phone'];
        $postal = $_POST['postal'];
        $bansa = $_POST['country'];

        $query = $conn->prepare("UPDATE customer_tbl SET address = :una, city=:ikalawa, phone=:ikatlo, postal=:ikaapat, country =:ikalima WHERE customerId=:customerid");
        $query->bindParam(":customerid", $uid);
        $query->bindParam(":una", $tirahan);
        $query->bindParam(":ikalawa", $siyudad);
        $query->bindParam(":ikatlo", $telepono);
        $query->bindParam(":ikaapat", $postal);
        $query->bindParam(":ikalima",$bansa);
        $query->execute();

        echo "<script>window.open('confirm.php','_self')</script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <title>Shipping</title>
    <style>
        /* --- start of nav bar css --- */
        body {
            font-family: 'Poppins',sans-serif;
            background-color: #f6f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .navbar {
            width: 100%;
            background-color: black;
           /* overflow: auto;*/
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between;
        }
        .navbar a {
            text-align: center;
            padding: 5px;
            color: white;
            text-decoration: none;
            font-size: 16px;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
            border-radius: 20px;
        }
        #noHover:hover {
            background-color: inherit;
        }
        .navbar .search-container {
            position: relative;
            display: inline-block;
            margin-right: 10px;
        }
        .navbar input[type=search] {
            padding: 6px;
            font-size: 14px;
            border: none;
            border-radius: 3px;
            background-color: #303030;
            width: 200px; 
            color: white;
        }
        .navbar button {
            font-family: 'Poppins',sans-serif;
            position: absolute;
            right: 0;
            top: 0;
            padding: 4px;
            font-size: 14px;
            border: none;
            border-top-right-radius: 3px;
            border-bottom-right-radius: 3px;
            background-color: #303030;
            cursor: pointer;
            display: flex; 
            justify-content: center; 
            align-items: center;
        }
        .navbar .basic {
            display: flex;
            align-items: center;
        }
        .navbar .icon{
            display: flex;
            align-items: center;
        }
        /*.navbar .icon a {
            margin-left: 10px;
        } */
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 9999;
            overflow:visible;
        }
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }
        .dropdown-content a:hover {
            background-color: #ddd;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
        .dropdown-content2 {
            display: none;
            position: absolute;
            right: 0; /* Add this line */
            min-width: 200px;
            background-color: #f9f9f9;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            overflow:visible;
        }
        .dropdown-content2 a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }
        .dropdown-content2 a:hover {
            background-color: #ddd;
        }
        .dropdown:hover .dropdown-content2 {
            display: block;
        }
        .dropbtn {
            display: flex; /* new */
            justify-content: center; /* new */
            align-items: center;
        }
        #userImg  {
            border-radius: 50px;
        }
        #logo {
            display: flex; /* to center */
            justify-content: center; /* new */
            align-items: center;
            margin-left: 10px;
            margin-right: 10px;
        }
        .cart {
            position: relative;
            display: flex; /* new */
            justify-content: center; /* new */
            align-items: center; /* new */
            margin-right: 10px;
        }
        #cartindicator {
            position: absolute;
            top: 0;
            right: -10px;
            background-color: red;
            border-radius: 10px;
            color: white;
            font-size: 12px;
            padding: 3px;
        }
        input {
            font-family: 'Poppins',sans-serif;
        }
        @media only screen and (max-width: 600px) {
        /* Mobile styles */

            .navbar {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }

            .navbar a {
                display: block;
                width: 100%;
                box-sizing: border-box;
            }

            .navbar input[type=search] {
                margin-right: 5px;
                width: 100px;
            }
            .navbar button {
                margin-right: 5px;
            }
            .navbar #home {
                display:none;
            }
            .navbar #logo,
            .navbar .search-container,
            .navbar #userImg,
            .navbar .cart{
                display: flex;
            }
        }
            /* --- end of nav bar css --- */
        .container {
            margin:30px;
            width:500px;
        }
        .flowcontainer {
            display: flex;
            align-items: center;
            justify-content: space-around;
        }
        .flowcontainer span{
            text-align: center;
            border: 1px solid black;
            border-radius: 30px;
            margin: 10px;
            padding: 10px;
        }
        #editedtext {
            background-color: black;
            color: white;
        }
        #unedited {
            background-color: #ddd;
            color: #303030;
            border: none;
        }
        .checkoutcontainer {
            margin-top: 20px;
            border: 1px solid black;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .checkoutcontainer h2, hr {
            margin:15px;
            text-align: center;
        }
        input {
            font-size: 15px;
        }
        .address {
            display: block;
            margin: 15px;
        }
        .address span {
            margin-bottom: 10px;
            display: block;
            font-size: 18px;
        }
        .address input {
            width: 100%;
            box-sizing: border-box;
            border: none;
            border-bottom: 1px solid #ddd;
            background-color: inherit;
        }
        .bottomcontainer {
            display: flex;
        }
        .address label,
        .otherinfoaddress label,
        .otherinfoaddress2 label {
            font-size: 10px;
            color: #303030;    
        }
        .otherinfoaddress,
        .otherinfoaddress2 {
            width: 50%;
            margin-left: 15px;
            margin-right: 15px;
        }
        .otherinfoaddress input,
        .otherinfoaddress2 input {
            border: none;
            border-bottom: 1px solid #ddd;
            box-sizing: border-box;
            display: block;
            width: 100%;
            background-color: inherit;
        }
        .nextbtn {
            display:flex;
            justify-content: flex-end;
            margin: 15px;
        }
        .nextbtn #next{
            color: white;
            background-color: black;
            border: none;
            border-radius: 5px;
            padding: 5px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            cursor: pointer;
        }
        #next:hover{
            background-color: #ddd;
        }
        </style>
</head>
<body>
    <script>
        let previousScrollPosition = window.pageYOffset;
        window.onscroll = function() {
            let currentScrollPosition = window.pageYOffset;
            if (previousScrollPosition > currentScrollPosition) {
                document.querySelector(".navbar").style.top = "0";
            } else {
                document.querySelector(".navbar").style.top = "-60px"; // Adjust based on the height of your navbar
            }
            previousScrollPosition = currentScrollPosition;
        }
    </script>
    <div class="navbar">
        <div class="basic">
            <a href="home.php" id="noHover"><img src="pictures/sitelogo.png" width="25px" height="25px" id="logo"></a>
            <a id="home" href="home.php">Home</a>
            <div class="dropdown">
                <a class="dropbtn" id="products" href="product.php">Products</a>
                <div class="dropdown-content">
                    <a href="product.php?category=Men's Shoes">Men's Shoes</a>
                    <a href="product.php?category=Women's Shoes">Women's Shoes</a>
                    <a href="product.php?category=Kids' Shoes">Kids' Shoes</a>
                </div>
            </div>
        </div>
        <div class="icon">
            <form action="product.php" method="GET">
                <div class="search-container">
                    <input type="search" id="myInput" name="myInput" placeholder="Search..." onclick="changeColor()">
                    <script>
                    var input = document.getElementById("myInput");

                    input.addEventListener("focus", function() {
                    input.style.backgroundColor = "#ddd";
                    input.style.color = "black";
                    });

                    input.addEventListener("blur", function() {
                    input.style.backgroundColor = "";
                    });
                    </script>
                    <button type="submit"><img src="pictures/search.png" width="25px"></button>
                </div>
            </form>
            <div class="dropdown">
                <div class="dropbtn" id="noHover"><img src="userimg/<?php echo $retrato;?>" id="userImg" alt="" width="40px" height="40px" onerror="this.onerror=null; this.src='pictures/user.png'" ></div>
                <div class="dropdown-content2">
                    <a id="noHover">Hi, <?php echo $unangpangalan. " " .$apelyido;?></a>
                    <a href="myaccount.php">My Account</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
            <?php 
                $customerId = $_SESSION['cid'];
                $select = $conn->prepare("SELECT COUNT(*) AS productCount FROM cart_tbl WHERE customerId = ?");
                $select->bindParam(1, $customerId); 
                $select->execute();

                $row = $select->fetch();
                $productCount = $row['productCount'];
            ?>

            <a href="cart.php" class="cart" id="noHover"><img src="pictures/cart.png" width ="25px">
            <?php if ($productCount > 0) { ?>
                <label for="cart" id="cartindicator"><?php echo $productCount;?></label>
            <?php } ?>
            </a>
        </div>
    </div>
    <!-- /////////////END OF NAV BAR DIV///////////-->
    <div class="container">
        
        <div class="flowcontainer">
            <span id="editedtext">Shipping</span>
            <span id="unedited">Confirm Order</span>
            <span id="unedited">Payment</span>
        </div>
        <div class="checkoutcontainer">
            <form action="" method="POST">
            <h2>Checkout</h2>
            <hr>
            <div class="address">
                <span>Shipping Address</span>
                <label>Address</label>
                <input type="text" name="addre" placeholder="Address" value="<?php echo $address;?>" required>
            </div>
            <div class="bottomcontainer">
                <div class="otherinfoaddress">
                    <label>City</label>
                    <input type="text" name="city" placeholder="City" value="<?php echo $city;?>" required>
                    <label>Phone</label>
                    <input type="number" name="phone" id="end" placeholder="Phone" value="<?php echo $phone;?>" required>
                </div>
                <div class="otherinfoaddress2">
                    <label>Postal Code</label>
                    <input type="text" name="postal" placeholder="Postal Code" value="<?php echo $posta;?>" required>
                    <label>Country</label>
                    <input type="text" name="country" placeholder="Country" value="<?php echo $country;?>" required>
                </div>
            </div>
            <div class="nextbtn">
                <input type="submit" id="next" name="next" value="NEXT >">
            </div>
            </form>
        </div>
    </div>
</body>
</html>