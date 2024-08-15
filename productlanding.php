<?php
include_once("connection.php");
session_start();

if(isset($_SESSION['cid'])){
    // If a session is already started, redirect to home.php
    header("Location:home.php");
    die();
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
        .container {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin: 30px;
        }
        .leftside {
            width: 20%;
            margin:10px;
        }
        .leftside label {
            display: block;
            text-decoration: none;
            color: black;
        }
        .rightside {
            width: 80%;
            border-radius: 10px;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .new-div{
            margin: 15px;
        }
        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            width: 100%;
        }
        .product {
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 200px; /* Adjust this value as needed */
            margin: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            background-color: white;
            text-align: left;
        }
        .description{
            padding: 10px;
        }
        .product h2 {
            color: #333;
            font-size: 16px;
        }
        .product p {
            color: #666;
            font-size: 14px;
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
        .product-container img{
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
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
                <a class="dropbtn" id="products" href="productlanding.php">Products</a>
                <div class="dropdown-content">
                    <a href="productlanding.php?category=Men's Shoes">Men's Shoes</a>
                    <a href="productlanding.php?category=Women's Shoes">Women's Shoes</a>
                    <a href="productlanding.php?category=Kids' Shoes">Kids' Shoes</a>
                </div>
            </div>
        </div>
        <div class="icon">
            <form action="productlanding.php" method="GET">
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
                <div class="dropbtn" id="noHover"><img src="" id="userImg" alt="" width="40px" height="40px" onerror="this.onerror=null; this.src='pictures/user.png'" ></div>
                <div class="dropdown-content2">
                    <a href="login.php">Login</a>
                    <a href="signup.php">Sign up</a>
                </div>
            </div>

            <a href="cart.php" class="cart" id="noHover"><img src="pictures/cart.png" width ="25px">
            </a>
        </div>
    </div>
    <!-- /////////////END OF NAV BAR DIV///////////-->
    <div class="container">
        <?php 
            $search_query = isset($_GET['myInput']) ? $_GET['myInput'] : null;
            $categories = isset($_GET['category']) ? $_GET['category'] : [];
        ?>
        <div class="leftside">
            <h3>Filter By Section</h3>
            <form id="filterForm" method="get" action="productlanding.php">
                <label><input type="checkbox" name="category[]" value="Men's Shoes" <?php if(isset($_GET['category']) && is_array($_GET['category']) && in_array("Men's Shoes", $_GET['category'])) echo 'checked'; ?>> Men's Shoes</label>
                <label><input type="checkbox" name="category[]" value="Women's Shoes" <?php if(isset($_GET['category']) && is_array($_GET['category']) && in_array("Women's Shoes", $_GET['category'])) echo 'checked'; ?>> Women's Shoes</label>
                <label><input type="checkbox" name="category[]" value="Kids' Shoes" <?php if(isset($_GET['category']) && is_array($_GET['category']) && in_array("Kids' Shoes", $_GET['category'])) echo 'checked'; ?>> Kids' Shoes</label>
            </form>
            <br>
            <hr>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
                $('#filterForm input[type="checkbox"]').change(function(){
                    $('#filterForm').submit();
                });
            });
        </script>

        <div class="rightside">
            <div class="new-div">
                <h2>
                    <?php 
                        if (isset($_GET['category'])) {
                            echo is_array($_GET['category']) ? implode(', ', $_GET['category']) : $_GET['category'];
                        } else {
                            echo "All Products";
                        }
                        if (isset($search_query)) {
                            echo " - Search results for '" . str_replace('%', '', $search_query) . "'";
                        }
                    ?>
                </h2>
            </div>

            <div class="product-container">
                <?php 
                    // Get the categories from the URL parameters
                    $categories = isset($_GET['category']) ? $_GET['category'] : [];

                    // If categories is not an array, make it an array
                    if (!is_array($categories)) {
                        $categories = [$categories];
                    }

                    // Prepare the SQL query
                    $sql = "SELECT * FROM product_tbl";
                    if ($search_query || !empty($categories)) {
                        $sql .= " WHERE";
                        if ($search_query) {
                            $sql .= " (productName LIKE :search_query OR color LIKE :search_query OR description LIKE :search_query)";
                            if (!empty($categories)) {
                                $sql .= " AND";
                            }
                        }
                        if (!empty($categories)) {
                            $sql .= " category IN (" . str_repeat('?,', count($categories) - 1) . "?)";
                        }
                    }

                    $select = $conn->prepare($sql);

                    // Bind the parameters
                    if ($search_query) {
                        $search_query = "%$search_query%";
                        $select->bindParam(":search_query", $search_query);
                    }
                    if (!empty($categories)) {
                        foreach ($categories as $index => $category) {
                            $select->bindValue($index + 1, $category);
                        }
                    }

                    // Execute the query
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
                <?php }?>
            </div>
        </div>
    </div>


</body>
</html>