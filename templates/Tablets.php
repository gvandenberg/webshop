<div class="text-center ml-5 mr-5">
        <h4 class="font-rubik font-size-20">Tablets</h4>
        </div>
    <div class="text-right mr-5"><a href="?Tabletssortbyprice"><i class="text-right zmdi zmdi-money"></i></a></div>
    
    <hr class="text-center ml-5 mr-5">
    <div class="container">
        <div class="row clearfix">
        <?php
            $conn = mysqli_connect('localhost','root','','pc4u');
            if (isset($_GET['Tabletssortbyprice'])) {
                $sql = "SELECT * FROM products WHERE cat = 'Tablets' ORDER BY old_price ASC";
            } else {
            $sql = "SELECT * FROM products WHERE cat = 'Tablets'";}
            $result = mysqli_query($conn, $sql);
    
            while ($row = mysqli_fetch_assoc($result)) {
    
                echo '<div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card product_item">
                    <div class="body">
                        <div class="cp_img">
                            <img src="/img/'.$row['productimg'].'" alt="Product" class="img-fluid" heigt="315" width="315">
                            <div class="hover">
                                <a href="/addtowishlist.php?productid='.$row['id'].'" class="btn btn-primary btn-sm waves-effect"><i class="zmdi zmdi-plus"></i></a>
                                <a href="/addtocart.php?productid='.$row['id'].'" class="btn btn-primary btn-sm waves-effect"><i class="zmdi zmdi-shopping-cart"></i></a>
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