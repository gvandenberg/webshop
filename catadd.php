


<?php
session_start();
if (isset($_POST['cancel'])) {
    header('Location: adminportal.php');
}

if (isset($_POST['catadd'])) {
    $cat = $_POST['cat'];

    $conn = mysqli_connect('localhost','root','','pc4u');
    
    

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

    $sql = "INSERT INTO cat (name)
    VALUES ('$cat')";

    if ($conn->query($sql) === TRUE) {
        $myfile = fopen("templates/".$cat.".php", "w");
        $txt = '<div class="text-center ml-5 mr-5">
        <h4 class="font-rubik font-size-20">'.$cat.'</h4>
        </div>
        <div class="text-right mr-5"><a href="?'.$cat.'sortbyprice"><i class="text-right zmdi zmdi-money"></i></a></div>
        
        <hr class="text-center ml-5 mr-5">
        <div class="container">
            <div class="row clearfix">
        <?php
            $conn = mysqli_connect(\'localhost\',\'root\',\'\',\'pc4u\');
            if (isset($_GET[\''.$cat.'\'])) {
                $sql = "SELECT * FROM products WHERE cat = \''.$cat.'\' ORDER BY old_price ASC";
            } else {
            $sql = "SELECT * FROM products WHERE cat = \''.$cat.'\'";}
            $result = mysqli_query($conn, $sql);
    
            while ($row = mysqli_fetch_assoc($result)) {
    
            echo \'<div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card product_item">
                    <div class="body">
                        <div class="cp_img">
                            <img src="/img/\'.$row["productimg"].\'" alt="Product" class="img-fluid" heigt="315" width="315">
                            <div class="hover">
                                <a href="/addtowishlist.php?productid=\'.$row[\'id\'].\'" class="btn btn-primary btn-sm waves-effect"><i class="zmdi zmdi-plus"></i></a>
                                <a href="/addtocart.php?productid=\'.$row[\'id\'].\'" class="btn btn-primary btn-sm waves-effect"><i class="zmdi zmdi-shopping-cart"></i></a>
                            </div>
                        </div>
                        <div class="product_details">
                            <h5><a href="product-details.php?id=\'.$row[\'id\'].\'">\'.$row["brand"]." ".$row["title"].\'</a></h5>
                            <ul class="product_price list-unstyled">\';
                            if (!empty($row[\'new_price\'])){
                                echo \'<li class="old_price text-decoration-line-through">€\'.$row["old_price"].\'</li>|
                                <li class="new_price">€\'.$row["new_price"].\'</li>\';
                            } else {
                                echo \'<li class="new_price">€\'.$row["old_price"].\'</li>\';
                            }
                        echo \'
                            </ul>
                        </div>
                    </div>
                </div>
            </div>\';
            }
        ?>
        </div>
    </div>';
        fwrite($myfile, $txt);
        fclose($myfile);
        $myfile = fopen("cat/".$cat.".php", "w");
        $txt = '<?php include (\'../includes/header.php\'); ?>

        <br><br><br><br><br><br>
        
        <?php include (\'../templates/'.$cat.'.php\'); ?>
        
        <?php include (\'../includes/footer.php\'); ?>';
        fwrite($myfile, $txt);
        fclose($myfile);
        $homepage = file_get_contents("allproducts.php", "r");
        $myfile = fopen("allproducts.php", "w");
        $txt = $homepage . "
        <?php
        if (file_exists('templates/".$cat.".php')) {
        include ('templates/".$cat.".php');
        } ?>";
        fwrite($myfile, $txt);
        fclose($myfile);
        header('Location: adminportal.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
            
    $conn->close();
    

}


?>

<?php include 'includes/header.php'; 
$index = fopen("allproducts.php", "r");

?>

<div class="card bg-light">
<article class="card-body mx-auto" style="max-width: 400px;">
	<br><br><br><br><br><br>
	<form method="post">
	<div class="form-group input-group">
		<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="bi bi-plus-square"></i> </span>
		 </div>
        <input name="cat" class="form-control" placeholder="Categorie" type="text">
    </div>
    <div class="form-group">
        <button name="catadd" type="submit" class="btn btn-primary btn-block"> Toevoegen  </button>
    </div>
    <div class="form-group">
        <button name="cancel" type="submit" class="btn btn-warning btn-block"> Annuleren  </button>
    </div>                                                            
</form>
</article>
</div>
</div> 



<?php include 'includes/footer.php'; ?>