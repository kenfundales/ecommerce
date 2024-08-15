<?php
    include_once("../connection.php");
    session_start();
    include_once("session.php");
    $orderId = $_GET['uid'];

   
    /*$insertQuery = $conn->prepare("INSERT INTO done_tbl (customerId, productId, shoesize2, qty2, totalPrice2)
    SELECT customerId, productId, shoesize, qty, totalPrice FROM order_tbl WHERE orderId = :customerId");
    $insertQuery->bindParam(":customerId", $orderId);
    $insertQuery->execute();*/

    
    $query = $conn->prepare("DELETE FROM order_tbl WHERE orderId = :oId");
    $query->bindParam(":oId", $orderId);
    $query->execute();

    echo "<script>alert('Successfully deleted!')</script>";
    echo "<script>window.open('orders.php','_self')</script>";

?>