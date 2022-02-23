
<?php session_start(); ?>
<?php include ('includes/header.php'); ?>

<?php 
if (!isset($_SESSION['loggedin'])){
    if (isset($_SESSION['role'])) {
    if (!($_SESSION['role'] == 'admin')) {
        header('Location: index.php');
    }
} else {
    header('Location: index.php');
} } ?>

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
$sql = "SELECT DISTINCT order_id FROM orders ORDER BY order_id DESC";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)){
    $sql1 = "SELECT * FROM orders WHERE order_id='$row[order_id]'";
    $result1 = mysqli_query($conn, $sql1);
    $row1 = mysqli_fetch_assoc($result1);
    $sql2 = "SELECT * FROM users WHERE id='$row1[user_id]'";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    echo '<tr><td><a href="order.php?id='.$row['order_id'].'">'.$row['order_id'].'</td><td>'.$row2['full_name'].'</a></td></tr>';
}
?>
    </tbody>
</table>
<div class="text-center ml-5 mr-5">
    <h4 class="font-rubik font-size-20">Categorieën</h4>
    <hr>
</div>

<ul class="list-group">
    <?php
        $conn = mysqli_connect('localhost','root','','pc4u');
        $sql = "SELECT * FROM cat";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
        $_SESSION['catname'] = $row['name'];

        echo '<li class="list-group-item"><a href="/catedit.php?id='.$row["id"].'" class="d-inline"><i class="bi bi-pencil"></i></a>&nbsp
        <a onClick="return confirmDelete()" href="/catdelete.php?id='.$row["id"].'" class="d-inline"><i class="bi bi-x-circle"></i></a>&nbsp
        '.$row['name'].'</li>';
        }
    ?>
    <li class="list-group-item"><a href="/catadd.php" class="d-inline"><i class="bi bi-plus-circle"></i> Categorie toevoegen</a></li>
</ul>

<div class="text-center ml-5 mr-5">
    <h4 class="font-rubik font-size-20">Alle producten</h4>
    <hr>
</div>
<div class="container">
    <div class="row clearfix">
    <div class="col-lg-3 col-md-4 col-sm-12">
            <div class="card product_item">
                <div class="body">
                    <div class="cp_img">
                    <a href="productadd.php"><img src="/img/addproduct.png" alt="addproduct" class="img-fluid product-img"></a>
                    </div>
                    <div class="product_details product_add"><br>Product Toevoegen<br></div>
                </div>
            </div>
        </div>
    <?php
        $conn = mysqli_connect('localhost','root','','pc4u');
        $sql = "SELECT * FROM products";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {

        echo '<div class="col-lg-3 col-md-4 col-sm-12">
            <div class="card product_item">
                <div class="body">
                    <div class="cp_img">
                        <img src="/img/'.$row["productimg"].'" alt="Product" class="img-fluid product-img">
                        <div class="hover">
                            <a href="editproduct.php?id='.$row['id'].'" class="btn btn-primary btn-sm waves-effect"><i class="bi bi-pencil"></i></a>
                            <a onClick="return confirmDelete()" href="deleteproduct.php?id='.$row['id'].'" class="btn btn-primary btn-sm waves-effect"><i class="bi bi-x-circle"></i></a>
                        </div>
                    </div>
                    <div class="product_details">
                            <h5><a href="product-details.php?id='.$row['id'].'">'.$row["brand"]." ".$row["title"].'</a></h5>
                            <ul class="product_price list-unstyled">';
                            if (!empty($row['new_price'])){
                                echo '<li class="old_price text-decoration-line-through">€'.$row["old_price"].'</li>|
                                <li class="new_price">€'.$row["new_price"].'</li>';
                            } else {
                                echo '<li class="new_price">€'.$row["old_price"].'</li>';
                            }
                        echo '
                            </ul>
                        </div>
                </div>
            </div>
        </div>';
        }
    ?>
    </div>
</div>



<?php include ('includes/footer.php'); ?>