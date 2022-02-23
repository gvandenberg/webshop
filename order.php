<?php 
session_start();
include ('includes/header.php');
if (isset($_SESSION['role'])) {
    if (!($_SESSION['role'] == 'admin')) {
        header('Location: index.php');
    }
} else {
    header('Location: index.php');
} 


$conn = mysqli_connect("localhost", "root", "", "pc4u");
$sql = "SELECT * FROM admin";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$shippingcost = $row['shipping_costs'];
$freeshipping = $row['free_shipping'];

?>
<br><br><br><br><br><br><br><br>

<h3>Bestelling nr: <?php echo $_GET['id']; ?></h3>
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
                    $sql = "SELECT * FROM orders WHERE order_id = '$_GET[id]'";
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
                        $user_id = $row['user_id'];
                        
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
                    <td>€<?php if ($total > $freeshipping){$shippingcost = 0;}echo $shippingcost;?></td>
                <tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="font-weight-bold text-left">Totaal incl. verzendkosten</td>
                    <td>€<?php echo $total + $shippingcost; ?></td>
                <tr>
            </tbody>
        </table>
        
        <br><br><br><br><br>

<?php $sql = "SELECT * FROM users WHERE id='$user_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
     
     ?>
        <h2 class="text-left">Afleveradres</h2><br>
        <table class="table text-left">
            <tr>
                <td>Naam</td>
                <td><?php echo $row['first_name'].' '. $row['last_name']; ?></td>
            </tr>
            <tr>
                <td>Adres</td>
                <td><?php echo $row['address']; ?></td>
            </tr>
            <tr>
                <td>Postcode</td>
                <td><?php echo $row['zipcode']; ?></td>
            </tr>
            <tr>
                <td>Woonplaats</td>
                <td><?php echo $row['residence']; ?></td>
            </tr>
            <tr>
                <td>Telefoonnummer</td>
                <td><?php echo $row['phone_number']; ?></td>
            </tr>
        </table>

