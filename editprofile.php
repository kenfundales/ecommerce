<?php
session_start();
include_once("session.php");
include_once("connection.php");

$customerId = $_GET['cid'];

$picture = $retrato;

if(isset($_POST['save'])) {
    $firstn = $_POST['fname'];
    $middlen = $_POST['mname'];
    $lastn = $_POST['lname'];
    $usern = $_POST['uname'];
    
    $pictureFile = $_FILES['image']['name'];
    $picture_tmp_name = $_FILES['image']['tmp_name'];
    $pictureSize = $_FILES['image']['size'];

    $picture_folder = 'userimg/';
    
    $picExt = strtolower(pathinfo($pictureFile,PATHINFO_EXTENSION));

    $valid_ext = array('jpeg','jpg','gif','png');

    $newname = rand(1000, 10000000).".".$picExt;
    
    // Check if a new file has been uploaded
    if(!empty($pictureFile)){
        if(in_array($picExt, $valid_ext)){
            if($pictureSize < 5000000){
                move_uploaded_file($picture_tmp_name,$picture_folder.$newname);
                $picture = $newname; // Update the picture only if a new file has been uploaded
            } else {
                echo "<script>alert('Sorry, your file is too large.')</script>";
                echo "<script>window.open('myaccount.php','_self')</script>";
            }
        } else {
            echo "<script>alert('Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.')</script>";
            echo "<script>window.open('myaccount.php','_self')</script>";
        }
    }

    $duplicateUsername = $conn->prepare("SELECT customerId FROM customer_tbl WHERE username = :dupPass AND customerId != :uid");
    $duplicateUsername->bindParam(":dupPass", $usern);
    $duplicateUsername->bindParam(":uid", $customerId);
    $duplicateUsername->execute();

    if($duplicateUsername->rowCount() ==1){
        echo "<script>alert('Username has already taken.')</script>";
        echo "<script>window.open('myaccount.php','_self')</script>";
    } else {
        $query = $conn->prepare("UPDATE customer_tbl SET firstname =:una, middlename = :ikalawa, lastname=:ikatlo, username =:ikaapat, customerpic=:ikalima WHERE customerId = :uid");
        $query->bindParam(":una", $firstn);
        $query->bindParam(":ikalawa", $middlen);
        $query->bindParam(":ikatlo", $lastn);
        $query->bindParam(":ikaapat", $usern);
        $query->bindParam(":ikalima", $picture);
        $query->bindParam(":uid",$customerId);
        $query->execute();
        echo "<script>alert('Successfully updated!')</script>";
        echo "<script>window.open('myaccount.php','_self')</script>";
    }
}

if(isset($_POST['changepass'])){
    $oldpword = $_POST['oldpass'];
    $newpword = $_POST['newpass'];
    $conpword = $_POST['conpass'];

    // Check if the old password matches the one in the database
    $checkPassword = $conn->prepare("SELECT customerId FROM customer_tbl WHERE password = :dupPass AND customerId = :uid");
    $checkPassword->bindParam(":dupPass", $oldpword);
    $checkPassword->bindParam(":uid", $customerId);
    $checkPassword->execute();

    if($checkPassword->rowCount() > 0) {
        if($newpword == $conpword) {
            $updatePassword = $conn->prepare("UPDATE customer_tbl SET password = :newPass WHERE customerId = :uid");
            $updatePassword->bindParam(":newPass", $newpword);
            $updatePassword->bindParam(":uid", $customerId);
            $updatePassword->execute();
            echo "<script>alert('Password successfully updated!')</script>";
        } else {
            // The new password and the confirmation password do not match
            echo "<script>alert('New password and confirmation password do not match.')</script>";
            echo "<script>window.open('','_self')</script>";
        }
    } else {
        // The old password is incorrect
        echo "<script>alert('Old password is incorrect.')</script>";
        echo "<script>window.open('','_self')</script>";
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
            justify-content:start;
            width: 100%;
        }
        .rightside {
            margin: 25px;
            width: 90%;
            border-radius: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            background-color: white;
        }
        .leftside {
            width:40%;
            margin:10px;
            display: block;
            flex: center;
            justify-content: center;
            align-items: center;
        }
        .leftside img {
            width: 150px;
            border-radius: 100px;
            border: 0.5px solid black;
        }
        .profilecontainer {
            text-align: center;
            margin: 15px;
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            border-radius: 3px;
            background-color: white;
        }
        .profilecontainer h3 {
            margin: 0;
            display: block;
            font-family: Century Gothic;
        }
        .profilecontainer #email {
            font-size: 13px;
            display: block;
            padding-bottom: 5px;
        }
        .profilecontainer a {
            display: block;
            text-decoration: none;
            color: white;
            background-color: black;
        }
        .profilecontainer a:hover {
            background-color: #ddd;
        }
        .optioncontainer {
            margin: 15px;
            background-color: white;
            border-radius: 3px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .optioncontainer a {
            text-decoration: none;
            color: black;
            padding-left: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .optioncontainer a:hover {
            background-color: #ddd;
        }
        .iconoption {
            display: flex;
            align-items: center;
        }
        #orderindicator {
            background-color: red;
            border-radius: 50px;
            color:white;
            font-size: 13px;
            padding:3px;
            margin-right: 5px;
        }
        #orderimg {
            width: 30px;
            border:none;
            margin-right: 5px;
        }
        .profilecontent {
            padding: 25px;
        }
        .profilecontent h2{
            margin:0;
        }
        .profilecontent label {
            padding-top: 10px;
        }
        .rightside label {
            display: block;
            font-size: 10px;
            color: #303030;
        }
        .rightside input {
            padding:5px;
        }
        .rightside span {
            font-size:10px; 
            color:gray; 
            font-style: italic;
        }
        .rightside img {
            width: 150px;
            border: 1px solid black;
        }
        .rightside #buttonSave, #changePasswordButton, #button{
            text-decoration: none;
            border: 1px solid black;
            color: black;
            font-size: 17px;
            cursor: pointer;
        }
        .buttons{
            display: flex;
            width: 200px;
        }
        .buttons input {
            margin: 20px;
        }
        .changepassword {
            padding: 25px;
        }
        .changepassword h4 {
            margin:0;
        }
        .changepassword label{
            padding-top:10px;
        }
        .button {
            margin-top: 10px;
        }
        input {
            width: 100%;
            box-sizing: border-box;
        }
        @media (max-width: 750px)  {
            .container {
                display: block;
                justify-content: center;
                align-items: center;
            }
            .rightside {
                width: 90%; /* Full width on small screens */
            }
            .leftside {
                margin:0;
                width: 100%; /* Full width on small screens */
            }
            .rightside input {
                width: 100%; /* Adjust input width on small screens */
            }
        }
        @media (min-width: 751px) and (max-width: 1000px) {
            .rightside {
                width: 120%; /* Adjust width for medium screens */
            }
            .leftside {
                width: 30%; /* Adjust width for medium screens */
            }
            .rightside input {
                width: 100%; /* Adjust input width for medium screens */
            }
        }
        @media (min-width: 1001px) and (max-width: 1200px) {
            .rightside {
                width: 140%; /* Adjust width for medium screens */
            }
            .leftside {
                width: 30%; /* Adjust width for medium screens */
            }
            .rightside input {
                width: 100%; /* Adjust input width for medium screens */
            }
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
    <div class="leftside">
            <div class="profilecontainer">
                <img src="userimg/<?php echo $retrato;?>" alt="" onerror="this.onerror=null; this.src='pictures/user1.png'" >
                <h3><?php echo $unangpangalan." ". $apelyido;?></h3>
                <span id="email"><?php echo $email;?></span>
                <a href="editprofile.php?cid=<?php echo $customerId;?>">Edit Profile</a>
            </div>
            <div class="optioncontainer">
                <?php 
                    $customerId = $_SESSION['cid'];
                    $orderStatuses = [
                        'All Orders' => 'order1.png',
                        'Processing' => 'process.png',
                        'On delivery' => 'ondelivery.png',
                        'Delivered' => 'delivered.png'
                    ];

                    foreach ($orderStatuses as $status => $image) {
                        $filter = $status === 'All Orders' ? '' : " AND actionn LIKE '%$status%'";
                        $select = $conn->prepare("SELECT COUNT(*) AS productCount FROM order_tbl WHERE customerId = ?$filter");
                        $select->bindParam(1, $customerId); 
                        $select->execute();

                        $row = $select->fetch();
                        $productCount = $row['productCount'];
                ?>
                    <a href="myorders.php?cid=<?php echo $customerId;?><?php echo $status === 'All Orders' ? '' : "&filter=$status";?>">
                        <div class="iconoption">
                            <img src="pictures/<?php echo $image;?>" id="orderimg">
                            <?php echo $status;?>
                        </div>
                        <label id="orderindicator"><?php echo $productCount;?></label>
                    </a>
                <?php } ?>
            </div>
        </div>
        <div class="rightside">
            <div class="profilecontent">
                <form action="" method="POST" enctype="multipart/form-data">
                <h2>My Profile</h2>
                <hr style="height:3px; background-color: black;">
                <label>Firstname</label>
                <input type="text" name="fname" value="<?php echo $unangpangalan;?>">
                <label>Middlename</label>
                <input type="text" name="mname" value="<?php echo $gitna;?>">
                <label>Lastname</label>
                <input type="text" name="lname" value="<?php echo $apelyido;?>">
                <label>Username</label>
                <input type="text" name="uname" value="<?php echo $username;?>">
                <br>
                <label>Profile Picture</label>
                <img src="userimg/<?php echo $retrato;?>" alt="No Profile Picture added"><br><span>(Leave the field empty if you want to have the same picture as before)</span><br>
                <input type="file" name="image">
            </div>
            <div class="buttons">
                <input type="button" id="changePasswordButton" name="change" value="Change Password">
                <input type="submit" id="buttonSave" name="save" value="Save Changes" style="background-color: yellowgreen;">
                </form>
            </div>
            <div class="changepassword" id="changePasswordDiv" style="display: none;">
                <form action="" method="POST">
                <hr>
                <h4>Change Password</h4>
                <label>Old Password</label>
                <input type="password" name="oldpass">
                <label>New Password</label>
                <input type="password" name="newpass">
                <label>Confirm Password</label>
                <input type="password" name="conpass">
                <div class="button">
                <input type="submit" id="button" name="changepass" value="Edit Password" style="background-color: yellowgreen;">
                </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('changePasswordButton').addEventListener('click', function() {
            var changePasswordDiv = document.getElementById('changePasswordDiv');
            var saveButton = document.getElementById('buttonSave');
            if (changePasswordDiv.style.display === 'none') {
                changePasswordDiv.style.display = 'block';
                saveButton.style.display = 'none'; 
                changePasswordButton.style.display = 'none';// Hide the Save Changes button
            } else {
                changePasswordDiv.style.display = 'none';
                saveButton.style.display = 'inline';
                changePasswordButton.style.display = 'inline'; // Show the Save Changes button
            }
        });
    </script>
</body>
</html>