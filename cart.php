<?php session_start(); ?>

<?php if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
} ?>

<?php include ('includes/header.php'); ?>
<br><br><br><br><br><br><br>


<?php 

$user_id = $_SESSION['loggedin'];
$conn = mysqli_connect('localhost','root','','pc4u');
$sql = "SELECT * FROM admin";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$shippingcost = $row['shipping_costs'];
$freeshipping = $row['free_shipping'];


?>





<div class="pb-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">

          <!-- Shopping cart table -->
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col" class="border-0 bg-light">
                    <div class="p-2 px-3 text-uppercase">Product</div>
                  </th>
                  <th scope="col" class="border-0 bg-light">
                    <div class="py-2 text-uppercase">Prijs</div>
                  </th>
                  <th scope="col" class="border-0 bg-light">
                    <div class="py-2 text-uppercase">Aantal</div>
                  </th>
                  <th scope="col" class="border-0 bg-light">
                    <div class="py-2 text-uppercase">Totale prijs</div>
                  </th>
                  <th scope="col" class="border-0 bg-light">
                    <div class="py-2 text-uppercase">Verwijderen</div>
                  </th>
                </tr>
              </thead>
              <tbody>
              <?php
                $total = 0;
                $conn = mysqli_connect('localhost','root','','pc4u');
                $sql = "SELECT * FROM cart WHERE user_id = '$user_id' ORDER BY product_id";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $productid = $row['product_id'];
                    $sql1 = "SELECT * FROM products WHERE id = '$productid'";
                    $result1 = mysqli_query($conn, $sql1);
                    $row1 = mysqli_fetch_assoc($result1);
                    if (empty($row1['new_price'])){
                      $row1['new_price'] = $row1['old_price'];
                    }
                    $priceqty = $row1['new_price'] * $row['quantity'];
                    echo '<tr>
                    <th scope="row" class="border-0">
                      <div class="p-2">
                        <img src="/img/'.$row1['productimg'].'" alt="" width="70" class="img-fluid rounded shadow-sm">
                        <div class="ml-3 d-inline-block align-middle">
                          <h5 class="mb-0"> <a href="#" class="text-dark d-inline-block align-middle">'.$row1['brand'].' '.$row1['title'].'</a></h5><span class="text-muted font-weight-normal font-italic d-block">Categorie: '.$row1['cat'].'</span>
                        </div>
                      </div>
                    </th>
                    <td class="border-0 align-middle"><strong id="price">€'.$row1['new_price'].'</strong></td>
                    <td class="border-0 align-middle"><a href="mincart.php?productid='.$productid.'"><i class="bi bi-dash mr-2"></a></i><strong id="quantity">'.$row['quantity'].'<a href="addtocart.php?productid='.$productid.'"><i class="bi bi-plus ml-2"></i></a></strong></td>
                    <td class="border-0 align-middle"><strong id="price">€'.$priceqty.'</strong></td>
                    <td class="border-0 align-middle"><a href="deletefromcart.php?productid='.$productid.'" class="text-dark"><i class="fa fa-trash"></i></a></td>
                  </tr>';
                  
                  $total = $total + ($row1['new_price'] * $row['quantity']);
                }

                if ($total > $freeshipping) {
                    $shippingcost = 0;
                }

                if ($total == 0) {
                    $shippingcost = 0;
                }

                $totalcost = $total + $shippingcost;

              ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>

      <div class="row py-5 p-4 bg-white rounded shadow-sm">

        <div class="col-lg-6">
          <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Coupon code</div>
            <div class="p-4">
            <p class="font-italic mb-4">Als je een coupon code hebt, vul het hieronder in</p>
          </div>
      <form>
        <div class="input-group input-group mb-4 border rounded-pill p-2">
          <input type="text" class="form-control border-0" placeholder="Promo code" name="promocode">
          <div class="input-group-append border-0">
            <button id="button-addon3" type="submit" class="btn btn-dark px-4 rounded-pill"><i class="fa fa-gift mr-2"></i>Inwisselen</button>
          </div>
        </div>
      </form>
          <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Opmerkingen</div>
          <div class="p-4">
            <p class="font-italic mb-4">Als je opmerkingen hebt vul deze hieronder in</p>
            <textarea name="" cols="30" rows="2" class="form-control"></textarea>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="bg-light rounded-pill px-4 py-3 text-uppercase font-weight-bold">Overzicht Bestelling </div>
          <div class="p-4">
            <ul class="list-unstyled mb-4">
              <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Bestelling Totaal </strong><strong id="total"><?php echo $total; ?></strong></li>
              <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Verzendkosten</strong><strong id="shipping"><?php echo $shippingcost; ?></strong></li>
              <?php if(isset($_GET['promocode'])) {
                $promocode = $_GET['promocode'];
                $conn = mysqli_connect('localhost','root','','pc4u');
                $sql = "SELECT * FROM promocode WHERE code = '$promocode'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                if ($result->num_rows > 0) {
                  echo '<li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Coupon</strong><strong>€'.$row['discount'].'</strong></li>';
                  $totalcost = $totalcost - $row['discount'];
                  if ($totalcost < 0) {
                    $totalcost = 0;
                  }
              }
              
            } ?>
              <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Totaal ex. BTW</strong>
                <h5 id="totex" class="font-weight-bold"><?php echo (round($totalcost/(1+(21/100)), 2)); ?></h5>
              </li>
              <li class="d-flex justify-content-between py-3 border-bottom"><strong class="text-muted">Totaal incl. BTW</strong>
                <h5 id="totbtw" class="font-weight-bold"><div id="total"><?php echo $totalcost ?></div></h5>
              </li>
            </ul><a href="<?php if (isset($_GET['promocode'])){echo 'completeorder.php?promocode='.$_GET['promocode'];} else {echo 'completeorder.php';} ?>" class="btn btn-dark rounded-pill py-2 btn-block">Doorgaan met bestellen</a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
</form>

<div class="pb-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 p-5 bg-white rounded shadow-sm mb-5">

          <!-- Shopping cart table -->
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col" class="border-0 bg-light">
                    <div class="p-2 px-3 text-uppercase">Product</div>
                  </th>
                  <th scope="col" class="border-0 bg-light">
                    <div class="py-2 text-uppercase">Prijs</div>
                  </th>
                  <th scope="col" class="border-0 bg-light">
                    <div class="py-2 text-uppercase">Actie</div>
                  </th>
                </tr>
              </thead>
              <tbody>
              <?php
                $total = 0;
                $conn = mysqli_connect('localhost','root','','pc4u');
                $sql = "SELECT * FROM wishlist WHERE user_id = '$user_id' ORDER BY product_id";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $productid = $row['product_id'];
                    $sql1 = "SELECT * FROM products WHERE id = '$productid'";
                    $result1 = mysqli_query($conn, $sql1);
                    $row1 = mysqli_fetch_assoc($result1);
                    if (empty($row1['new_price'])){
                      $row1['new_price'] = $row1['old_price'];
                    }
                    $priceqty = $row1['new_price'] * $row['quantity'];
                    echo '<tr>
                    <th scope="row" class="border-0">
                      <div class="p-2">
                        <img src="/img/'.$row1['productimg'].'" alt="" width="70" class="img-fluid rounded shadow-sm">
                        <div class="ml-3 d-inline-block align-middle">
                          <h5 class="mb-0"> <a href="#" class="text-dark d-inline-block align-middle">'.$row1['brand'].' '.$row1['title'].'</a></h5><span class="text-muted font-weight-normal font-italic d-block">Categorie: '.$row1['cat'].'</span>
                        </div>
                      </div>
                    </th>
                    <td class="border-0 align-middle"><strong id="price">€'.$row1['new_price'].'</strong></td>
                    <td class="border-0 align-middle"><a href="deletefromwishlist.php?productid='.$productid.'" class="text-dark"><i class="fa fa-trash"></i></a><a href="addtocart.php?productid='.$productid.'" class="text-dark">   <i class="fas fa-cart-plus"></i></a></td>
                  </tr>';}
                  
                  ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
      </div>
      </div>


<script>
function round(id) {
  var num = +document.getElementById(id).textContent;
  var n = num.toFixed(2);
  document.getElementById(id).innerHTML = "€" + n;
}

round("total");
round("shipping");
round("totex");
round("totbtw");


</script>

<?php include ('includes/footer.php'); ?>