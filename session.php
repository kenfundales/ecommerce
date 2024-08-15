<?php
include_once("connection.php");
if(isset($_SESSION['cid'])){
	$uid = $_SESSION['cid'];
	$userQuery = $conn->prepare("SELECT * FROM customer_tbl WHERE customerId = :uid");
	$userQuery->bindParam(':uid', $uid);
	$userQuery->execute();
	
	while($data = $userQuery->fetch()){
		$customerId = $data['customerId'];
		$unangpangalan = $data['firstname'];
		$gitna = $data['middlename'];
		$apelyido = $data['lastname'];
		$retrato = $data['customerpic'];
		$email = $data['email'];
		$username = $data['username'];
	}
} else {
	header("Location:login.php");
	die();
}
?>