<?php
    include_once("connection.php");

    if(isset($_POST['submit'])){
        $fname = $_POST['firstn'];
        $mname = $_POST['middlen'];
        $lname = $_POST['lastn'];
        $username = $_POST['usern'];
        $email = $_POST['email'];
        $pword = $_POST['passw'];

        $duplicateEmail = $conn->prepare("SELECT customerId FROM customer_tbl WHERE email = :dupEmail");
        $duplicateEmail->bindParam(":dupEmail", $email);
        $duplicateEmail->execute();
        $duplicateUsername = $conn->prepare("SELECT customerId FROM customer_tbl WHERE username = :dupUser");
        $duplicateUsername->bindParam(":dupUser", $username);
        $duplicateUsername->execute();

        if($duplicateEmail->rowCount() > 0){    
            echo "<script>alert('Email has already taken.')</script>";
            echo "<script>window.open('index.php','_self')</script>";
        } elseif($duplicateUsername->rowCount() >0){
            echo "<script>alert('Username has already taken.')</script>";
            echo "<script>window.open('index.php','_self')</script>";
        } else {
            $query = $conn->prepare("INSERT INTO customer_tbl (firstname, middlename, lastname, username, email, password) VALUES (:una, :ikalawa, :ikatlo, :ikaapat, :ikalima, :ikaanim)");
            $query->bindParam(":una", $fname);
            $query->bindParam(":ikalawa", $mname);
            $query->bindParam(":ikatlo", $lname);
            $query->bindParam(":ikaapat", $username);
            $query->bindParam(":ikalima", $email);
            $query->bindParam(":ikaanim", $pword);
            $query->execute();
            echo "<script>alert('Successfully registered!')</script>";
            echo "<script>window.open('login.php','_self')</script>";
        }
    }
        
       /* IF THERE'S A PIC IN SIGN UP FORM ----- 
        //code to process image upload
        $pictureFile = $_FILES['image']['name'];
        $picture_tmp_name = $_FILES['image']['tmp_name'];
        $pictureSize = $_FILES['image']['size'];

        $picture_folder = 'userimg/';
        
        $picExt = strtolower(pathinfo($pictureFile,PATHINFO_EXTENSION));

        $valid_ext = array('jpeg','jpg','gif','png');

        $newname = rand(1000, 10000000).".".$picExt;

        if(in_array($picExt, $valid_ext)){
            if($pictureSize < 5000000){
                $duplicateEmail = $conn->prepare("SELECT customerId FROM customer_tbl WHERE email = :dupEmail");
                $duplicateEmail->bindParam(":dupEmail", $email);
                $duplicateEmail->execute();
                $duplicateUsername = $conn->prepare("SELECT customerId FROM customer_tbl WHERE username = :dupUser");
                $duplicateUsername->bindParam(":dupUser", $username);
                $duplicateUsername->execute();

                if($duplicateEmail->rowCount() > 0){    
                    echo "<script>alert('Email has already taken.')</script>";
                    echo "<script>window.open('index.php','_self')</script>";
                } elseif($duplicateUsername->rowCount() >0){
                    echo "<script>alert('Username has already taken.')</script>";
                    echo "<script>window.open('index.php','_self')</script>";
                } else {
                    move_uploaded_file($picture_tmp_name,$picture_folder.$newname);
                    $query = $conn->prepare("INSERT INTO customer_tbl (firstname, middlename, lastname, username, email, password, customerpic) VALUES (:una, :ikalawa, :ikatlo, :ikaapat, :ikalima, :ikaanim, :ikapito)");
                    $query->bindParam(":una", $fname);
                    $query->bindParam(":ikalawa", $mname);
                    $query->bindParam(":ikatlo", $lname);
                    $query->bindParam(":ikaapat", $username);
                    $query->bindParam(":ikalima", $email);
                    $query->bindParam(":ikaanim", $pword);
                    $query->bindParam(":ikapito", $newname);
                    $query->execute();
                    echo "<script>alert('Successfully registered!')</script>";
                    echo "<script>window.open('signup.php','_self')</script>";
                }
        } else {
            echo "<script>alert('Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.')</script>";
            echo "<script>window.open('signup.php','_self')</script>";
        }
        } else {
            echo "<script>alert('Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.')</script>";
            echo "<script>window.open('signup.php','_self')</script>";
        }
} */
?>