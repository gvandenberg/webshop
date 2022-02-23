<?php
session_start();

if (!isset($_SESSION['loggedin'])){
    header('Location: login.php');
}

$productid = $_GET['productid'];
$userid = $_SESSION['loggedin'];

$conn = mysqli_connect('localhost','root','','pc4u');
$sql = "SELECT * FROM cart WHERE user_id = '$userid' AND product_id = '$productid'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if(mysqli_num_rows($result) >0){
    $quantity = $row['quantity'] + 1;
    $conn->close();
    $conn = mysqli_connect('localhost','root','','pc4u');
    $sql = "DELETE FROM cart WHERE user_id = '$userid' AND product_id = '$productid'";

    if ($conn->query($sql) === TRUE) {

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();

} else {
    $quantity = 1;
}



$conn = mysqli_connect('localhost','root','','pc4u');
$sql = "INSERT INTO cart (user_id, product_id, quantity)
VALUES ('$userid', '$productid', '$quantity')";

if ($conn->query($sql) === TRUE) {

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

$conn->close();


$conn = mysqli_connect('localhost','root','','pc4u');

$sql = "SELECT * FROM wishlist WHERE user_id = '$userid' AND product_id = '$productid'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);


if(mysqli_num_rows($result) >0){


    $sql = "DELETE FROM wishlist WHERE user_id = '$userid' AND product_id = '$productid'";

    if ($conn->query($sql) === TRUE) {
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}

header('Location: cart.php');


?>