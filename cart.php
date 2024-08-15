<?php
    session_start();
    include_once("session.php");
    include_once("connection.php");
    $customerid = $_SESSION['cid'];

    if(isset($_POST['update'])){
        $select1 = $conn->prepare("SELECT cart_tbl.productId, cart_tbl.shoesize1, product_tbl.price FROM cart_tbl INNER JOIN product_tbl ON cart_tbl.productId = product_tbl.productId WHERE cart_tbl.customerId = :customerId");
        $select1->bindParam(":customerId", $customerid);
        $select1->execute();

        while($row1 = $select1->fetch()){
            $pid = $row1['productId'];
            $shoesize1 = $row1['shoesize1'];
            $presyo = str_replace(',', '', $row1['price']); 
            $presyo = floatval($presyo);

            if(isset($_POST['quantity'][$pid][$shoesize1])){
                $qty = $_POST['quantity'][$pid][$shoesize1];
                $totalprice = $presyo * $qty;

                $updateQuery1 = $conn->prepare("UPDATE cart_tbl SET qty1 = :qty1, totalPrice1 = :totalPrice1 WHERE customerId = :customerId AND productId = :productId AND shoesize1 = :shoesize1");
                $updateQuery1->bindParam(":qty1", $qty);
                $updateQuery1->bindParam(":totalPrice1", $totalprice);
                $updateQuery1->bindParam(":customerId", $customerid);
                $updateQuery1->bindParam(":productId", $pid);
                $updateQuery1->bindParam(":shoesize1", $shoesize1);
                $updateQuery1->execute();
            }
        }
    }

    if(isset($_POST['checkout'])){
        // Step 1: Insert data into order_tbl from cart_tbl
        $insertQuery = $conn->prepare("INSERT INTO order_tbl (customerId, productId, shoesize, qty, totalPrice, actionn)
        SELECT customerId, productId, shoesize1, qty1, totalPrice1, 'Processing' FROM cart_tbl WHERE customerId = :customerId");
        $insertQuery->bindParam(":customerId", $customerid);
        $insertQuery->execute();
    
        /*Step 2: Delete data from cart_tbl
        $deleteQuery = $conn->prepare("DELETE FROM cart_tbl WHERE customerId = :customerId");
        $deleteQuery->bindParam(":customerId", $customerid);
        $deleteQuery->execute(); */
    
        echo "<script>window.open('shipping.php','_self')</script>";
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
        .item {
            display: flex;
            align-items: center; 
            margin-bottom: 10px;
            border: 1px solid black;
            border-radius: 5px;
        }
        .item img {
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }
        .itemdescription {
            width: 250px;
            margin-left: 10px;
        }
        .itemdescription span {
            font-size: 10px;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis; 
            display: block;
            width: 100%;
        }
        .itemdescription h4,
        .itemdescription span {
            margin: 0;
        }
        .quantity_buttons_added {
            width: 100px;
            margin-left:50px;
        }
        .quantity_buttons_added .inputqty {
            width:25px;
            font-size: 14px;
        }
        .quantity_buttons_added .minus, .quantity_buttons_added .plus {
            background-color: black;
            color: white;
            border: none;
            cursor: pointer;
        }
        .pricecontainer {
            margin-left:20px;
            min-width:100px;
        }
        .deletebutt a{
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 40px;
        }
        .summarycontainer {
            border: 1px solid black;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
        }
        .summarycontainer h4 {
            margin: 10px;
        }
        .summarydescription {
            display: flex;
            flex-direction: column;
            margin: 10px;
            width:50%;
        }
        .summarydata {
            display: flex;
            flex-direction: column;
            text-align: right;
            margin: 10px;
            width: 50%;
        }
        .checkoutbutt {
            display: flex;
            margin-top: 10px;
            justify-content: flex-end;
        }
        #chkbtn {
            color: white;
            background-color: black;
            border: none;
            border-radius: 20px;
            padding: 8px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            text-decoration: none;
        }
        #chkbtn:hover{
            background-color: #ddd;
            cursor: pointer;
        }
        #updatebtn {
            background-color: white;
            border: 1px solid black;
            border-radius: 20px;
            padding: 8px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-right: 10px;
        }
        #updatebtn:hover{
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
            <a href="index.php" id="noHover"><img src="pictures/sitelogo.png" width="25px" height="25px" id="logo"></a>
            <a id="home" href="index.php">Home</a>
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
    <form action="" method="POST">
    <div class="container">
        <h2>Shopping Cart</h2>
        <div class="cartcontainer">
            <?php 
                $customerId = $_SESSION['cid'];

                $select1 = $conn->prepare("SELECT product_tbl.*, cart_tbl.* FROM cart_tbl 
                INNER JOIN customer_tbl ON cart_tbl.customerId = customer_tbl.customerId 
                INNER JOIN product_tbl ON cart_tbl.productId = product_tbl.productId 
                WHERE cart_tbl.customerId = ?");
                $select1->bindParam(1, $customerId); 
                $select1->execute();
            
                $totalBilang = 0;
                $totalPresyo = 0;
            
                while($row1 = $select1->fetch()){
                    if(is_array($row1)){
                        $id1 = $row1['cartId'];
                        $pid = $row1['productId'];
                        $productname = $row1['productName'];
                        $productimage = $row1['picture'];
                        $productcategory = $row1['category'];
                        $productprice = $row1['price'];
                        $productcolor = $row1['color'];
                        $productsize = $row1['shoesize1'];
                        $bilang = $row1['qty1'];
                        $presyo = $row1['totalPrice1'];
            
                        $totalBilang += $bilang;
                        $totalPresyo += $presyo;
                
            ?>
            <div class="item">
                
                <img src="shoes/<?php echo $productimage;?>" width="100px">
                <div class="itemdescription">
                    <h4><?php echo $productname;?></h4>
                    <span><?php echo $productcategory;?></span>
                    <span><?php echo $productcolor;?></span>
                    <span>Size: <?php echo $productsize;?></span>
                </div>
                <div class="quantity_buttons_added">
                    <input type="button" class="minus" value="-">
                   <input name="quantity[<?php echo $pid; ?>][<?php echo $productsize; ?>]" type="number" size="4" class="inputqty" title="Qty" value="<?php echo $bilang;?>" min="0" step="1">
                    <input type="button" class="plus" value="+">
                </div>

                <script>
                    var inputs = document.querySelectorAll('.inputqty');
                    var minuses = document.querySelectorAll('.minus');
                    var pluses = document.querySelectorAll('.plus');

                    for (let i = 0; i < inputs.length; i++) {
                        pluses[i].onclick = function(){
                            inputs[i].value = parseInt(inputs[i].value, 10) + 1;
                        }
                        minuses[i].onclick = function(){
                            if(parseInt(inputs[i].value, 10) > 0){
                                inputs[i].value = parseInt(inputs[i].value, 10) - 1;
                            }
                        }
                    }
                </script>

                <div class="pricecontainer">
                    <span>₱ <?php echo $presyo;?></span>
                </div>
                <div class="deletebutt">
                <a href="deleteitem.php?cartId=<?php echo $id1;?>" onclick="return confirm('Are you sure?')"><img src="pictures/delete.png" width="20px"></a>
                </div>
            </div>  
            <?php }
            }?>
        </div>
        <div class="summarycontainer">
            <h4>Order Summary</h4>
            <hr>
            <div class="summarydescription">
                <label>Subtotal</label>
                <label>Estimated Total</label>
            </div>
            <div class="summarydata">
                <label><?php echo $totalBilang;?>(Item/s)</label>
                <label>₱<?php echo $totalPresyo;?></label>
            </div>
        </div>
        <?php if ($productCount > 0): ?>
        <div class="checkoutbutt">
            <input type="submit" id="updatebtn" name="update" value="Update">
            <button type="submit" id="chkbtn" name="checkout"><img src="pictures/checkout.png" width="20px"> CHECKOUT</button>  
        </div>
        <?php endif; ?>
    </div>
    </form>
</body>
</html>