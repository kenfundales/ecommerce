<?php
    include_once("../connection.php");

    $id = $_GET['uid'];

    $query = $conn->prepare("DELETE FROM product_tbl WHERE productId = :pId");
    $query->bindParam(":pId", $id);
    $query->execute();

    echo "<script>alert('Successfully deleted!')</script>";
    echo "<script>window.open('addproduct.php','_self')</script>";

?>