<?php
session_start();

if (!isset($_SESSION['loggedin'])){
    header('Location: login.php');
}

$productid = $_GET['productid'];
$userid = $_SESSION['loggedin'];

$conn = mysqli_connect('localhost','root','','pc4u');
$sql = "DELETE FROM wishlist WHERE user_id = '$userid' AND product_id = '$productid'";
if ($conn->query($sql) === TRUE) {
    header('Location: cart.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();