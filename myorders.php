<?php 

session_start();
include('includes/header.php');

?>
<br><br><br><br><br><br>
<div class="text-center ml-5 mr-5">
    <h4 class="font-rubik font-size-20">Bestellingen</h4>
    <hr>
</div>
<table class="table">
    <thead>
        <tr>
            <th>Bestellingnr:</th>
            <th>Naam:</th>
        </tr>    
    </thead>
    <tbody>
<?php 

$conn = mysqli_connect('localhost','root','','pc4u');
$sql = "SELECT DISTINCT order_id FROM orders WHERE user_id='$_SESSION[loggedin]' ORDER BY order_id DESC";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)){
    $sql1 = "SELECT * FROM orders WHERE order_id='$row[order_id]'";
    $result1 = mysqli_query($conn, $sql1);
    $row1 = mysqli_fetch_assoc($result1);
    $sql2 = "SELECT * FROM users WHERE id='$row1[user_id]'";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    echo '<tr><td><a href="myordersdetail.php?id='.$row['order_id'].'">'.$row['order_id'].'</td><td>'.$row2['full_name'].'</a></td></tr>';
}
?>
    </tbody>
</table>