<?php
    include_once("connection.php");
    session_start();
    include_once("session.php");

    $uid = $_GET['uid'];
    $select = $conn->prepare("SELECT * FROM product_tbl WHERE productId=:uid");
    $select->bindParam(":uid", $uid);
    $select->execute();

    $row = $select->fetch();
    if(is_array($row)){
        $pangalan = $row['productName'];
        $detalye = $row['description'];
        $imahe = $row['picture'];
        $imahe2 = $row['picture1'];
        $imahe3 = $row['picture2'];
        $kategorya = $row['category'];
        $presyo = str_replace(',', '', $row['price']); // Remove the comma
        $presyo = floatval($presyo);
        $kulay = $row['color'];
    }

    if(isset($_POST['addtocart'])){
        $shoesize = $_POST['shoeSize'];
        $qty = $_POST['quantity'];
        $totalprice = $presyo * $qty;
        $customerid = $_SESSION['cid'];
    
        // First, check if the product is already in the cart
        $checkQuery1 = $conn->prepare("SELECT * FROM cart_tbl WHERE customerId = :customerId AND productId = :productId AND shoesize1 = :shoesize1");
        $checkQuery1->bindParam(":customerId", $customerid);
        $checkQuery1->bindParam(":productId", $uid);
        $checkQuery1->bindParam(":shoesize1", $shoesize);
        $checkQuery1->execute();
        $row1 = $checkQuery1->fetch();
    
        if (is_array($row1)) {
            // If the product is already in the cart, update the quantity and total price
            $newQty = $row1['qty1'] + $qty;
            $newTotalPrice = $row1['totalPrice1'] + $totalprice;
            $updateQuery1 = $conn->prepare("UPDATE cart_tbl SET qty1 = :qty1, totalPrice1 = :totalPrice1 WHERE customerId = :customerId AND productId = :productId AND shoesize1 = :shoesize1");
            $updateQuery1->bindParam(":qty1", $newQty);
            $updateQuery1->bindParam(":totalPrice1", $newTotalPrice);
            $updateQuery1->bindParam(":customerId", $customerid);
            $updateQuery1->bindParam(":productId", $uid);
            $updateQuery1->bindParam(":shoesize1", $shoesize);
            $updateQuery1->execute();
        } else {
            // If the product is not in the cart, insert a new row
            $insertQuery1 = $conn->prepare("INSERT INTO cart_tbl(customerId, productId, shoesize1, qty1, totalPrice1) VALUES (:customerId, :productId, :shoesize1, :qty1, :totalPrice1)");
            $insertQuery1->bindParam(":customerId", $customerid);
            $insertQuery1->bindParam(":productId", $uid);
            $insertQuery1->bindParam(":shoesize1", $shoesize);
            $insertQuery1->bindParam(":qty1", $qty);
            $insertQuery1->bindParam(":totalPrice1", $totalprice);
            $insertQuery1->execute();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <title>D'Nike</title>
    <style>
        /* --- start of nav bar css --- */
        body {
            font-family: 'Poppins',sans-serif;
            background-color: white;
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
        .product-container{
            margin: 50px;
            width: 100%;
            max-width: 1000px; 
            display: flex;
            flex-wrap: wrap; /* Allow the items to wrap onto the next line */
        }
        .productpicture {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .productdescription {
            padding:20px;
        }
        .productpicture, .productdescription {
            flex: 0 100%; /* By default, take up the full width */
            box-sizing: border-box; 
        }
        @media (min-width: 768px) { 
            .productpicture, .productdescription {
                flex: 1; /* Take up equal width */
            }
            .productdescription {
                margin: 10px;
            }
        }
        .productpicture {
            width: 100%;
            height: 500px;
            margin-top: 15px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .slide {
            display: none;
            position: absolute;
            width: 100%;
            height: 100%;
        }
        .slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .active {
            display: block;
        }
        .panel-container {
            position: absolute;
            bottom: 10px;
            width: 100%;
            text-align: center;
        }
        .panel {
            display: inline-block;
            width: 20px;
            height: 5px;
            border-radius: 2px;
            background-color: #ddd;
            margin: 0 1px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .panel.active {
            background-color: #555;
        }
        .selectdrpdown {
            font-family: 'Poppins',sans-serif;
        }
        .quantity_buttons_added #theInput {
            width:50px;
        }
        .quantity_buttons_added .minus, .quantity_buttons_added .plus {
            background-color: black;
            color: white;
            border: none;
        }
        #addbtn {
            color: white;
            background-color: black;
            border: none;
            border-radius: 20px;
            padding: 8px;
        }
        #addbtn:hover{
            background-color: #ddd;
            cursor: pointer;
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
    <div class="product-container">
        <div class="productpicture">
            <div class="slide active"><img src="shoes/<?php echo $imahe;?>" width="400px"></div>
            <div class="slide"><img src="shoes/<?php echo $imahe2;?>" width="400px"></div>
            <div class="slide"><img src="shoes/<?php echo $imahe3;?>" width="400px"></div>
        <!-- Add more slides as needed -->

            <div class="panel-container">
            <span class="panel" onclick="currentSlide(1)"></span>
            <span class="panel" onclick="currentSlide(2)"></span>
            <span class="panel" onclick="currentSlide(3)"></span>
            <!-- Add more panels as needed -->
            </div>
        </div>
        <div class="productdescription">
            <form action="" method="POST">
            <h1 name="productname"><?php echo $pangalan;?></h1>
            <span name="productcategory"><?php echo $kategorya;?></span><br>
            <span name="productprice">₱<?php echo $presyo?></span><br><br>
            <span name="productcolor"><?php echo $kulay;?></span><hr>
            <p name="productdetail"><?php echo $detalye;?></p>
            <label for="shoeSize">Size: </label>
            <select name="shoeSize" class="selectdrpdown" required>
                <option value="" disabled selected>Select shoe size</option>
                <option name="shoeSize" value="5">5</option>
                <option name="shoeSize" value="6">6</option>
                <option name="shoeSize" value="7">7</option>
                <option name="shoeSize" value="8">8</option>
                <option name="shoeSize" value="9">9</option>
                <option name="shoeSize" value="10">10</option>
                <option name="shoeSize" value="11">11</option>
                <option name="shoeSize" value="12">12</option>
            </select>
            <div class="quantity_buttons_added">
                <label>Quantity: </label>
                <input id="minus" type="button" class="minus" value="-">
                <input id="theInput" name="quantity" type="number" size="4" class="input-text qty text" title="Qty" value="1" min="0" step="1">
                <input id="plus" type="button" class="plus" value="+">
            </div>
            <input type="submit" id="addbtn" name="addtocart" value="Add to Cart">
            
            <script>
                var input = document.getElementById('theInput');
                document.getElementById('plus').onclick = function(){
                    input.value = parseInt(input.value, 10) +1
                }
                document.getElementById('minus').onclick = function(){
                    if(parseInt(input.value, 10) > 1){
                        input.value = parseInt(input.value, 10) -1
                    }
                }
            </script>
            
            </form>
        </div>
    </div>
    <script>
        var slideIndex = 0;
        showSlides();
    
        function showSlides() {
            var i;
            var slides = document.getElementsByClassName("slide");
            var panels = document.getElementsByClassName("panel");
    
            for (i = 0; i < slides.length; i++) {
                slides[i].classList.remove("active");
                panels[i].classList.remove("active");
            }
    
            slideIndex++;
            if (slideIndex > slides.length) { slideIndex = 1; }
    
            slides[slideIndex - 1].classList.add("active");
            panels[slideIndex - 1].classList.add("active");
        }
        function currentSlide(n) {
            showSlides(slideIndex = n - 1); // Adjusted index to match array index
        }
    </script>
</body>
</html>