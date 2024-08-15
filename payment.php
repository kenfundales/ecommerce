<?php
session_start();
include_once("session.php");
include_once("cartcounter.php");
include_once("connection.php");
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
        .paymentoption {
            display: block;
            margin: 15px;
        }
        .paymentoption span {
            display: flex;
            font-size: 18px;
        }
        .paymentoption label {
            font-size: 15px;
            margin-right: 100px;
        }
        .address input {
            width: 100%;
            box-sizing: border-box;
            border: none;
            border-bottom: 1px solid #ddd;
        }
        .otherinfoaddress,
        .otherinfoaddress2 {
            display: flex;
        }
        .otherinfoaddress input,
        .otherinfoaddress2 input {
            border: none;
            border-bottom: 1px solid #ddd;
            margin: 15px;
            width:100%;
            background-color: inherit;
        }
        .nextbtn {
            display:flex;
            justify-content: space-between;
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
            text-decoration: none;
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
            <span id="editedtext">Confirm Order</span>
            <span id="editedtext">Payment</span>
        </div>
        <div class="checkoutcontainer">
            <h2>Checkout</h2>
            <hr>
            <div class="paymentoption">
                <span>Payment Method</span>
                <form id="myForm">
                <input type="radio" id="method1" name="method" value="Cash" onclick="myFunction()">
                <label for="method1">Cash on Delivery</label><br>
                <input type="radio" id="method2" name="method" value="Card" onclick="myFunction()">
                <label for="method2">Card</label><br>
                <div id="cardDetails" style="display: none;">
                    <div class="otherinfoaddress">
                        <input type="text" id="cardnum" name="cardnum" placeholder="Card Number">
                        <input type="number" id="cardexpiry" name="cardexpiry" placeholder="Card Expiry">
                    </div>
                    <div class="otherinfoaddress2">
                        <input type="text" id="cvc" name="cvc" placeholder="Card CVC">
                    </div>
                </div>
            </form>
            </div>
            <div class="nextbtn">
            <?php 
                $customerId = $_SESSION['cid'];
                $select = $conn->prepare("SELECT product_tbl.*, cart_tbl.*, customer_tbl.* FROM cart_tbl 
                INNER JOIN customer_tbl ON cart_tbl.customerId = customer_tbl.customerId 
                INNER JOIN product_tbl ON cart_tbl.productId = product_tbl.productId 
                WHERE cart_tbl.customerId = ?");
                $select->bindParam(1, $customerId); 
                $select->execute();

                $totalBilang = 0;
                $totalPresyo = 0;

                while($row = $select->fetch()){
                    $id = $row['cartId'];
                    $pid = $row['productId'];
                    $productname = $row['productName'];
                    $productimage = $row['picture'];
                    $bilang = $row['qty1'];
                    $presyo = $row['totalPrice1'];
                    $customerfname = $row['firstname'];
                    $customerlname = $row['lastname'];

                    $totalBilang += $bilang;
                    $totalPresyo += $presyo;
                }
            ?>
                <span>Pay - ₱ <?php 
                    $alltotal = $totalPresyo + 150;
                    echo $alltotal;?></span>
                    <a href="#" id="next" name="next" onclick="checkRadio()">FINISH</a>
            </div>

            <script>
            function myFunction() {
                var method2 = document.getElementById('method2');
                var cardDetails = document.getElementById('cardDetails');
                if (method2.checked) {
                    cardDetails.style.display = "block";
                } else {
                    cardDetails.style.display = "none";
                }
            }

            function checkRadio() {
                var method1 = document.getElementById('method1');
                var method2 = document.getElementById('method2');
                var cardnum = document.getElementById('cardnum');
                var cardexpiry = document.getElementById('cardexpiry');
                var cvc = document.getElementById('cvc');
                if (method1.checked == false && method2.checked == false) {
                    alert('Please select a payment method before proceeding.');
                    return false;
                } else if (method2.checked && (cardnum.value == "" || cardexpiry.value == "" || cvc.value == "")) {
                    alert('Please fill in all card details before proceeding.');
                    return false;
                } else {
                    window.location.href = "success.php";
                }
            }
            </script>
        </div>
    </div>
</body>
</html>