<?php
session_start(); 
include("includes/header.php"); 

?>
<head>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
<link rel="stylesheet" href="details.css">
</head>
<body>
  

<br>
<br><br><br><br><br><br><br>
<?php  

$product_id = $_GET['id'];
$conn = mysqli_connect("localhost", "root", "", "pc4u");
$sql = "SELECT * FROM products WHERE id = '$product_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);


?>
<div class="container">
		<div class="card">
			<div class="container-fliud">
				<div class="wrapper row">
					<div class="preview col-md-6">
						
						<div class="preview-pic tab-content">
						  <div class="tab-pane active" id="pic-1"><img src="img/<?php echo $row['productimg'] ?>" /></div>
						</div>
						<ul class="preview-thumbnail nav nav-tabs">

						</ul>
						
					</div>
					<div class="details col-md-6">
						<h3 class="product-title"><?php echo $row['brand'].' '.$row['title'] ?></h3>
						<div class="rating">
							<div class="stars">
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star checked"></span>
								<span class="fa fa-star"></span>
								<span class="fa fa-star"></span>
							</div>
							<span class="review-no">41 reviews</span>
						</div>
						<p class="product-description"><?php echo $row['description'] ?></p>
						<h4 class="price">Huidige prijs: <span>€<?php echo $row['new_price'] ?></span></h4>
						<p class="vote"><strong>91%</strong> van de kopers vinden dit product leuk <strong>(87 stemmen)</strong></p>
						<div class="action">
							<a href="/addtocart.php?productid=<?php echo $row['id'] ?>"><button class="add-to-cart btn btn-primary" type="button">In winkelwagen <i class="zmdi zmdi-shopping-cart"></i></button></a>
							<button class="like btn btn-default btn-danger" type="button">Verlanglijst <span class="fa fa-heart"></span></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
  
  </body>