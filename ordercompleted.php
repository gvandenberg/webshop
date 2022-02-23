<?php session_start(); 
    include('includes/header.php');?>
<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="ordercompleted.css">

<body style="margin: 0 !important; padding: 0 !important; background-color: #eeeeee;" bgcolor="#eeeeee">
<br><br><br><br><br><br>

<?php

$conn = mysqli_connect("localhost", "root", "", "pc4u");


$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$address = $_POST['address'];
$zipcode = $_POST['zipcode'];
$residence = $_POST['residence'];
$phone_number = $_POST['phone_number'];
$paymentMethod = $_POST['paymentMethod'];
$user_id = $_SESSION['loggedin'];


$sql = "UPDATE users SET first_name='$first_name', last_name='$last_name', address='$address', zipcode='$zipcode', residence='$residence', phone_number='$phone_number' WHERE id='$user_id'";
mysqli_query($conn, $sql);



$maxsql = "SELECT MAX(order_id) AS MaxOrder FROM orders";
$result = mysqli_query($conn, $maxsql);
$row = mysqli_fetch_assoc($result);


$old_order_id = $row['MaxOrder'];
$order_id = $old_order_id + 1;


$productsql = "SELECT * FROM cart WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $productsql);

while ($row = mysqli_fetch_assoc($result)) {
    $product_id = $row['product_id'];
    $quantity = $row['quantity'];

    $sql = "INSERT INTO orders (user_id, order_id, product_id, quantity, paymentMethod) VALUES ('$user_id', '$order_id', '$product_id', '$quantity', '$paymentMethod')";
    mysqli_query($conn, $sql);

    $sql = "DELETE FROM cart where id='$row[id]'";
    mysqli_query($conn, $sql);
}









?>
<div class="container">
    <div class="text-center">
        <img src="https://img.icons8.com/carbon-copy/100/000000/checked-checkbox.png"/>
        <h1>Bedankt voor je Bestelling!</h1>
            <tr>
                <td>Bestelling nr: </td>
                <td><?php echo $order_id ?></td>
            </tr>
            <br><br><br><br><br>

        <table class="table">

            <thead>
                <tr>
                    <th>Product</th>
                    <th>Prijs</th>
                    <th>Aantal</th>
                    <th>Totaal</th>
                </tr>
            </thead>
            <tbody>

                <?php
                    $total = 0;
                    $sql = "SELECT * FROM orders WHERE order_id = '$order_id'";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $sql1 = "SELECT * FROM products WHERE id = '$row[product_id]'";
                        $result1 = mysqli_query($conn, $sql1);
                        $row1 = mysqli_fetch_assoc($result1);
                        if (empty($row1['new_price'])){
                            $row1['new_price'] = $row1['old_price'];
                          }
                        echo '<tr><td>'.$row1['brand'].' '.$row1['title'].'</td><td>€'.$row1['new_price'].'</td><td>'.$row['quantity'].'</td><td>€'.$row1['new_price'] * $row['quantity'];
                        $total = $total + ($row1['new_price'] * $row['quantity']);
                        
                    }
                ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="font-weight-bold text-left">Totaal</td>
                    <td>€<?php echo $total; ?></td>
                <tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="font-weight-bold text-left">Verzendkosten</td>
                    <td>€<?php echo $_SESSION['shippingcost']; ?></td>
                <tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="font-weight-bold text-left">Totaal incl. verzendkosten</td>
                    <td>€<?php echo $total + $_SESSION['shippingcost']; ?></td>
                <tr>
            </tbody>
        </table>
        
        <br><br><br><br><br>

        <h2 class="text-left">Afleveradres</h2><br>
        <table class="table text-left">
            <tr>
                <td>Naam</td>
                <td><?php echo $first_name.' '. $last_name; ?></td>
            </tr>
            <tr>
                <td>Adres</td>
                <td><?php echo $address; ?></td>
            </tr>
            <tr>
                <td>Postcode</td>
                <td><?php echo $zipcode; ?></td>
            </tr>
            <tr>
                <td>Woonplaats</td>
                <td><?php echo $residence; ?></td>
            </tr>
            <tr>
                <td>Telefoonnummer</td>
                <td><?php echo $phone_number; ?></td>
            </tr>
            <tr>
                <td>Betaalmethode</td>
                <td><?php echo $paymentMethod; ?></td>
            </tr>
        </table>
           
</body>

</html>

<?php



?>