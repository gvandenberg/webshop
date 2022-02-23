<?php 
session_start();
include('includes/header.php'); 

$conn = mysqli_connect('localhost','root','','pc4u');
$sql = "SELECT * FROM admin";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$shippingcost = $row['shipping_costs'];
$freeshipping = $row['free_shipping'];

$user_id = $_SESSION['loggedin'];


?>

<div class="container">
  <br><br><br><br><br><br>

  <div class="row">
    <div class="col-md-4 order-md-2 mb-4">
      <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-muted">Je winkelwagen</span>
        <span class="badge badge-secondary badge-pill"><?php 
        $conn = mysqli_connect('localhost','root','','pc4u');
        $sql = "SELECT * FROM cart WHERE user_id = '$user_id' ORDER BY product_id";
        $result = mysqli_query($conn, $sql);
        $rows = mysqli_num_rows($result);
        echo $rows;        
        ?></span>
      </h4>
      <ul class="list-group mb-3">
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
            $pricetimeqty = $row['quantity'] * $row1['new_price'];
            echo '<li class="list-group-item d-flex justify-content-between lh-condensed">
            <div>
              <h6 class="my-0">'.$row1['brand'].' '.$row1['title'].'</h6>
              <small class="text-muted">Aantal: '.$row['quantity'].'</small>
            </div>
            <span class="text-muted">€'.$pricetimeqty.'</span>
            </li>';
          
          $total = $total + ($row1['new_price'] * $row['quantity']);
        }

        if ($total > $freeshipping) {
            $shippingcost = 0;
        }

        if ($total == 0) {
            $shippingcost = 0;
        }

        $totalcost = $total + $shippingcost;
        $_SESSION['shippingcost'] = $shippingcost;

        ?>

        
        <li class="list-group-item d-flex justify-content-between lh-condensed">
          <div>
            <h6 class="my-0">Verzendkosten</h6>

          </div>
          <span class="text-muted" id="shippingcost1">€<?php echo $shippingcost; ?></span>
        </li>
        <?php if(isset($_GET['promocode'])) {
          $promocode = $_GET['promocode'];
          $conn = mysqli_connect('localhost','root','','pc4u');
          $sql = "SELECT * FROM promocode WHERE code = '$promocode'";
          $result = mysqli_query($conn, $sql);
          $row = mysqli_fetch_assoc($result);
          if ($result->num_rows > 0) {
            echo '<li class="list-group-item d-flex justify-content-between bg-light">
          <div class="text-success">
            <h6 class="my-0">Promo code</h6>
            <small>'.$promocode.'</small>
          </div>
          <span class="text-success">-€'.$row['discount'].'</span>
        </li>';
        $totalcost = $totalcost - $row['discount'];
          }
          
        } ?>
       
       <li class="list-group-item d-flex justify-content-between">
          <span>Totaal ex. BTW</span>
          <strong id="totalex1">€<?php echo (round($totalcost/(1+(21/100)), 2)); ?></strong>
        </li>
        <li class="list-group-item d-flex justify-content-between">
          <span>Totaal incl. BTW</span>
          <strong id="totalbtw1">€<?php echo $totalcost; ?></strong>
        </li>
      </ul>

      <form class="card p-2">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Promo code" name="promocode">
          <div class="input-group-append">
            <button type="submit" class="btn btn-secondary">Inwisselen</button>
          </div>
        </div>
      </form>
    </div>
    <?php

    $sql = "SELECT * FROM users WHERE id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);


    ?>
    <div class="col-md-8 order-md-1">
      <h4 class="mb-3">Verzendadres</h4>
      <form class="needs-validation" novalidate method="post" action="ordercompleted.php">
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="firstName">Voornaam</label>
            <input type="text" name="first_name" class="form-control" id="firstName" placeholder="" value="<?php echo $row['first_name'] ?>" required>
            <div class="invalid-feedback">
              Voornaam is verplicht
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="lastName">Achternaam</label>
            <input type="text" name="last_name" class="form-control" id="lastName" placeholder="" value="<?php echo $row['last_name'] ?>" required>
            <div class="invalid-feedback">
              Achternaam is verplicht
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="address">Adres</label>
          <input type="text" name="address" class="form-control" id="address" placeholder="" value="<?php echo $row['address'] ?>" required>
          <div class="invalid-feedback">
            Vul je adres in
          </div>
        </div>

        <div class="row">
          <div class="col-md-3 mb-3">
            <label for="zip">Postcode</label>
            <input type="text" name="zipcode" class="form-control" id="zip" placeholder="" value="<?php echo $row['zipcode'] ?>" required>
            <div class="invalid-feedback">
              Vul een postcode in
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <label for="residence">Woonplaats</label>
            <input type="text" name="residence" class="form-control" id="residence" placeholder="" value="<?php echo $row['residence'] ?>" required>
            <div class="invalid-feedback">
              Vul een woonplaats in
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <label for="phone_number">Telefoonnummer</label>
            <input type="text" name="phone_number" class="form-control" id="phone_number" placeholder="" value="<?php echo $row['phone_number'] ?>" required>
            <div class="invalid-feedback">
              Vul een telefoonnummer in
            </div>
          </div>
        </div>

        <hr class="mb-4">

        <h4 class="mb-3">Betaling</h4>

        <div class="d-block my-3">
          <div class="custom-control custom-radio">
            <input id="bank" name="paymentMethod" type="radio" class="custom-control-input" value="Vooruitbetaling per bank" checked required>
            <label onclick="bankon()" class="custom-control-label" for="bank">Vooruitbetaling per bank</label>
          </div>
          <div class="custom-control custom-radio">
            <input id="rekening" name="paymentMethod" type="radio" class="custom-control-input" value="Op rekening" required>
            <label onclick="bankoff()" class="custom-control-label" for="rekening">Op rekening</label>
          </div>
          <?php

          $maxsql = "SELECT MAX(order_id) AS MaxOrder FROM orders";
          $result = mysqli_query($conn, $maxsql);
          $row = mysqli_fetch_assoc($result);


          $old_order_id = $row['MaxOrder'];
          $order_id = $old_order_id + 1;
          ?>
          <div id="bankdetails">
        	  <br><br>
            U kunt het bedrag overmaken naar:<br><br>

            PC4U<br>
            NL02ABNA0123456789<br>
            Onder vermelding van: <?php echo $order_id; ?>
            
          </div>
        </div>
        <hr class="mb-4">
        <button class="btn btn-primary btn-lg btn-block" type="submit">Ga verder met bestellen</button>
      </form>
    </div>
  </div>
<br><br><br><br>
<script>

function bankon(){
  document.getElementById('bankdetails').innerHTML = "<br><br> U kunt het bedrag overmaken naar:<br><br>PC4U<br>NL02ABNA0123456789<br>Onder vermelding van: <?php echo $_SESSION['email']; ?>";
}

function bankoff() {
  document.getElementById('bankdetails').innerHTML = "";
}

round("shippingcost1");
round("totalex1");
round("totalbtw1");

</script>


<?php include('includes/footer.php'); ?>