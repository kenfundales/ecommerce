<?php
    include_once("connection.php");

    $cartId = $_GET['cartId'];
    
    // Delete from cart_tbl
    $deleteCart = $conn->prepare("DELETE FROM cart_tbl WHERE cartId = :cartId");
    $deleteCart->bindParam(":cartId", $cartId);
    $deleteCart->execute();

    echo "<script>alert('Successfully deleted!')</script>";
    echo "<script>window.open('cart.php','_self')</script>";
?>
