<?php
$hostname = "localhost";
$username = "root";
$password = "";
$db = "ecommerce";

try{
    $conn = new PDO("mysql:host=$hostname;dbname=$db", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e){
    echo "Connection Failed!: " .$e->getMessage();
}
?>