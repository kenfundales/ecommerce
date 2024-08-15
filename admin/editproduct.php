<?php
    include_once("../connection.php");
    session_start();
    include_once("session.php");

    $uid = $_GET['uid'];
    $select = $conn->prepare("SELECT * FROM product_tbl WHERE productId=:uid");
    $select->bindParam(":uid", $uid);
    $select->execute();

    while($row = $select->fetch()){
        $pangalan = $row['productName'];
        $detalye = $row['description'];
        $imahe = $row['picture'];
        $imahe2 = $row['picture1'];
        $imahe3 = $row['picture2'];
        $kategorya = $row['category'];
        $presyo = $row['price'];
        $kulay = $row['color'];
    }

    if(isset($_POST['update'])){
        $name1 = $_POST['name'];
        $category1 = $_POST['category'];
        $details1 = $_POST['details'];
        $price1 = $_POST['price'];
        $color1 = $_POST['color'];
    
        $valid_ext = array('jpeg','jpg','gif','png');
        $picture_folder = '../shoes/';
    
        // Array of picture input names
        $pictureInputs = ['picture', 'picture2', 'picture3'];
    
        // Array to hold new file names
        $newnames = [$imahe, $imahe2, $imahe3];
    
        foreach ($pictureInputs as $index => $inputName) {
            //code to process image upload
            $pictureFile = $_FILES[$inputName]['name'];
            $picture_tmp_name = $_FILES[$inputName]['tmp_name'];
            $pictureSize = $_FILES[$inputName]['size'];
            
            $picExt = strtolower(pathinfo($pictureFile,PATHINFO_EXTENSION));
    
            $newname = rand(1000, 10000000).".".$picExt;
    
            if(!empty($pictureFile)){
                if(in_array($picExt, $valid_ext)){
                    if($pictureSize < 5000000){
                        move_uploaded_file($picture_tmp_name,$picture_folder.$newname);
                        $newnames[$index] = $newname; // Update the picture only if a new file has been uploaded
                    } else {
                        echo "<script>alert('Sorry, your file is too large!')</script>";
                        echo "<script>window.open('addproduct.php','_self')</script>";
                        return;
                    }
                } else {
                    echo "<script>alert('Sorry, only jpeg, jpg, gif and png is allowed!')</script>";
                    echo "<script>window.open('addproduct.php','_self')</script>";
                    return;
                }
            }
        }
    
        // Prepare the SQL query
        $query = $conn->prepare("UPDATE product_tbl SET productName=:una, picture=:ikalawa, picture1=:ikatlo, picture2=:ikaapat, category=:ikalima, description=:ikaanim, color=:ikapito, price=:ikawalo WHERE productId=:uid");
        $query->bindParam(":una", $name1);
        $query->bindParam(":ikalawa", $newnames[0]);
        $query->bindParam(":ikatlo", $newnames[1]);
        $query->bindParam(":ikaapat", $newnames[2]);
        $query->bindParam(":ikalima", $category1);
        $query->bindParam(":ikaanim", $details1);
        $query->bindParam(":ikapito", $color1);
        $query->bindParam(":ikawalo", $price1);
        $query->bindParam(":uid",$uid);
    
        // Execute the query
        $query->execute();
        echo "<script>alert('Successfully edited a product!')</script>";
        echo "<script>window.open('addproduct.php','_self')</script>";
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <title>Edit Product</title>
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
        <h2>Edit Product</h2>
            <span>Name</span><input type="text" value="<?php echo $pangalan?>" name="name">
            <span>Picture</span><br><label for="image">Image uploaded:</label>
            <img src="../shoes/<?php echo $imahe?>" width="300px"><br><label for="image" id="psinfo">(Leave the field empty if you want to have the same picture as before)</label>
            <input type="file" name="picture">
            <img src="../shoes/<?php echo $imahe2?>" width="300px"><br><label for="image" id="psinfo">(Leave the field empty if you want to have the same picture as before)</label>
            <input type="file" name="picture2">
            <img src="../shoes/<?php echo $imahe3?>" width="300px"><br><label for="image" id="psinfo">(Leave the field empty if you want to have the same picture as before)</label>
            <input type="file" name="picture3">
            <span>Category</span><input type="text" value="<?php echo $kategorya?>" name="category">
            <span>Description</span><textarea name="details"><?php echo $detalye?></textarea>
            <span>Color</span><textarea name="color"><?php echo $kulay?></textarea>
            <span>Price</span><input type="text" value="<?php echo $presyo?>" name="price">
            <button type="submit" name="update" id="upbutt">Update Product</button>
        </div>
    </form>
    </div>
</body>
</html>