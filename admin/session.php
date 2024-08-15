<?php
include_once("../connection.php");
if(isset($_SESSION['aid'])){
	$uid = $_SESSION['aid'];
	$userQuery = $conn->prepare("SELECT * FROM admin_tbl WHERE id = :uid");
	$userQuery->bindParam(':uid', $uid);
	$userQuery->execute();
	
	while($data = $userQuery->fetch()){
		$user = $data['username'];
	}
} else {
	header("Location:login.php");
	die();
}
?>