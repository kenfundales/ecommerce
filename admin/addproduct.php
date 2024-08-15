<?php
    include_once("../connection.php");
    session_start();
    include_once("session.php");

    if(isset($_POST['add'])){
        $name = $_POST['name'];
        $category = $_POST['category'];
        $details = $_POST['details'];
        $price = $_POST['price'];
        $color = $_POST['color'];
        
        $valid_ext = array('jpeg','jpg','gif','png');
        $picture_folder = '../shoes/';
    
        // Array of picture input names
        $pictureInputs = ['picture', 'picture2', 'picture3'];
    
        // Array to hold new file names
        $newnames = [];
    
        foreach ($pictureInputs as $inputName) {
            //code to process image upload
            $pictureFile = $_FILES[$inputName]['name'];
            $picture_tmp_name = $_FILES[$inputName]['tmp_name'];
            $pictureSize = $_FILES[$inputName]['size'];
            
            $picExt = strtolower(pathinfo($pictureFile,PATHINFO_EXTENSION));
    
            $newname = rand(1000, 10000000).".".$picExt;
    
            if(in_array($picExt, $valid_ext)){
                if($pictureSize < 5000000){
                    move_uploaded_file($picture_tmp_name,$picture_folder.$newname);
                    $newnames[] = $newname;
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
    
        // Prepare the SQL query
        $query = $conn->prepare("INSERT INTO product_tbl (productName, picture, picture1, picture2, category, description, color, price) VALUES (:una, :ikalawa, :ikatlo, :ikaapat, :ikalima, :ikaanim, :ikapito, :ikawalo)");
        $query->bindParam(":una", $name);
        $query->bindParam(":ikalawa", $newnames[0]);
        $query->bindParam(":ikatlo", $newnames[1]);
        $query->bindParam(":ikaapat", $newnames[2]);
        $query->bindParam(":ikalima", $category);
        $query->bindParam(":ikaanim", $details);
        $query->bindParam(":ikapito", $color);
        $query->bindParam(":ikawalo", $price);
    
        // Execute the query
        $query->execute();
        echo "<script>alert('Successfully added a product!')</script>";
        echo "<script>window.open('addproduct.php','_self')</script>";
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <title>Products</title>
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
            <h2>Your Products</h2>
            <table>
                <tr>
                    <td>Name of the Product</td>
                    <td>Image</td>
                    <td>Category</td>
                    <td>Description</td>
                    <td>Color</td>
                    <td>Price</td>
                    <td>Action</td>
                </tr>
                <?php 
                $select = $conn->prepare("SELECT * FROM product_tbl");
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
                <tr>
                    <td><?php echo $pangalan;?></td>
                    <td><img src="../shoes/<?php echo $imahe;?>" alt="Picture" width="100"></td>
                    <td><?php echo $kategorya;?></td>
                    <td><?php echo $detalye;?></td>
                    <td><?php echo $kulay;?></td>
                    <td><?php echo $presyo;?></td>
                    <td><a href="editproduct.php?uid=<?php echo $id;?>">Edit</a> | <a href="delete.php?uid=<?php echo $id;?>" onclick="return confirm('Are you sure?')"> Delete</a></td>
                </tr>
            <?php }
            ?>
            </table>
            <form action="" method="POST" enctype="multipart/form-data">
            <h2>Add a New Product</h2>
            <input type="text" placeholder="Enter the name of the product" name="name">
            <label for="image">Upload image of the product</label>
            <input type="file" name="picture" id="picbutt">
            <label for="image2">Upload 2nd image of the product</label>
            <input type="file" name="picture2" id="picbutt">
            <label for="image3">Upload 3rd image of the product</label>
            <input type="file" name="picture3" id="picbutt">
            <input type="text" placeholder="Enter the category of the product" name="category">
            <textarea placeholder="Enter the details of the product" name="details"></textarea>
            <textarea placeholder="Enter the color of the product" name="color"></textarea>
            <input type="text" placeholder="Enter the price of the product" name="price">
            <button type="submit" name="add" id="addbutt">Add Product</button>
        </div>
    </div>
    </form>
</body>
</html>