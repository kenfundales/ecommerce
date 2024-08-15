<?php
include_once("connection.php");
if(isset($_SESSION['cid'])){
	$uid = $_SESSION['cid'];
    $customerId = $_SESSION['cid'];
    $select = $conn->prepare("SELECT COUNT(*) AS productCount FROM cart_tbl WHERE customerId = ?");
    $select->bindParam(1, $customerId); 
    $select->execute();

    $row = $select->fetch();
    $productCount = $row['productCount'];

    // Add this condition
    if($productCount == 0){
        header("Location:index.php");
        die();
    }
} else {
    // Check if HTTP_REFERER is set
    if(isset($_SERVER['HTTP_REFERER'])) {
        $previousPage = $_SERVER['HTTP_REFERER'];
        header("Location:" . $previousPage);
    } else {
        // Default redirection to shipping.php
        header("Location:shipping.php");
    }
    die();
}

?>
