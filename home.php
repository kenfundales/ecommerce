<?php
session_start();
include_once("session.php");
include_once("connection.php");
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
        .welcome-text {
            width: 100%;
            height: 500px;
            margin-top: 15px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
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

        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .product {
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 300px;
            margin: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
            background-color: white;
            text-align: left;
        }
        .description{
            padding: 10px;
        }
        .product h2 {
            color: #333;
            font-size: 20px;
        }
        .product p {
            color: #666;
            font-size: 16px;
        }
        .product #button {
            background-color: white;
            color: darkblue;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            text-transform: uppercase;
            cursor: pointer;
            text-decoration: none;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
        }
        .product #button:hover {
            background-color: rgb(197, 184, 184);
        }
        .punchline {
            margin: 30px;
            height: 150px;
            width: 100%;
            text-align: center;
        }
        .product-container img{
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }
        .audiencesection {
            display: block;
            flex-wrap: wrap;
        }
        .audiencesection h1 {
            margin-top:50px;
            margin-left: 10px;
        }
        .model {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }
        .model .product-link {
            position: relative;
            height: 430px;
            width: auto;
            margin: 5px;
        }
        .model img {
            height: 430px;
        }
        .model button {
            position: absolute;
            top: 70%;
            left: 30%;
            transform: translate(-50%, -50%);
            background-color: black;
            border: none;
            border-radius: 10px;
            color: white;
            cursor: pointer;
            font-family: 'Poppins',sans-serif;
            font-size: 16px;
        }
        .model button:hover {
            background-color: #303030;
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
    <div class="navbar" style="position: fixed;width: 100%; z-index:10; transition: 0.3s;">
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
    <div class="welcome-text" style="padding-top:50px;">
        <div class="slide active"><img src="pictures/logo9.jpg"></div>
        <div class="slide"><img src="pictures/logo6.jpg"></div>
        <div class="slide"><img src="pictures/logo11.jpg"></div>
        <!-- Add more slides as needed -->

        <div class="panel-container">
            <span class="panel" onclick="currentSlide(1)"></span>
            <span class="panel" onclick="currentSlide(2)"></span>
            <span class="panel" onclick="currentSlide(3)"></span>
            <!-- Add more panels as needed -->
        </div>
    </div>
    <div class="punchline">
        <h1>GIFTS THAT MOVE YOU.</h1>
        <p>Step into D’Nike! Discover our wide selection of Nike shoes. <br>Designed for both style and comfort, they’re perfect for everyday wear.</p>
    </div>
    <?php 
        $select = $conn->prepare("SELECT * FROM product_tbl LIMIT 3");
        $select->execute();

        while($row = $select->fetch()){
            $id = $row['productId'];
            $pangalan = $row['productName'];
            $detalye = $row['description'];
            $imahe = $row['picture'];
            $kategorya = $row['category'];
            $presyo = $row['price'];
            $kulay = $row['color'];
            ?>
    <div class="product-container">
        <div class="product">
            <div class="product-picture">
                <img src="shoes/<?php echo $imahe;?>">
            </div>
            <div class="description">
                <h2><?php echo $pangalan;?></h2>
                <p><?php echo $kategorya;?><br>
                ₱<?php echo $presyo;?></p>
                <a href="details.php?uid=<?php echo $id;?>" id ="button" name="checkdetails">Check Details</a>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="audiencesection">
        <h1>This Season’s Fresh Shoes.</h1>
        <div class="model">
            <a href="product.php?category=Men's Shoes" class="product-link">
                <img src='pictures/men.png'>
                <button>Shop Men's</button>
            </a>
            <a href="product.php?category=Women's Shoes" class="product-link">
                <img src="pictures/women.png">
                <button>Shop Women's</button>
            </a>
            <a href="product.php?category=Kids' Shoes" class="product-link">
                <img src="pictures/kids.png">
                <button>Shop Kids'</button>
            </a>
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
    
            setTimeout(showSlides, 5000); // Change slide every 2 seconds
        }
    
        function currentSlide(n) {
            showSlides(slideIndex = n - 1); // Adjusted index to match array index
        }
    </script>
</body>
</html>
