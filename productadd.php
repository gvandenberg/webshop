


<?php 

session_start();

if (!isset($_SESSION['role'])) {
    if (!$_SESSION['role'] == 'admin') {
        header('Location: index.php');
    }}
$msg = "";
$css_class = "";

if (isset($_POST['cancel'])) {
    header('Location: adminportal.php');
}

if (isset($_POST['productadd'])) {
    $productimgName = time() . '_' . $_FILES['productimg']['name'];

    $target = 'img/' . $productimgName;

    
    if (move_uploaded_file($_FILES['productimg']['tmp_name'], $target)) {
        $msg = "Image uploaded";
        $css_class = "bg-succes";        
    } else {
        $msg = "Failed to upload to upload";
        $css_class = "bg-danger";
    }




    
    $brand = $_POST['brand'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $old_price = $_POST['old_price'];
    $new_price = $_POST['new_price'];
    $cat = $_POST['cat'];
    $productimg = $productimgName;

    $conn = mysqli_connect('localhost','root','','pc4u');
    

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

    $sql = "INSERT INTO products (brand, title, description, old_price, new_price, cat, productimg)
    VALUES ('$brand', '$title', '$description', '$old_price', '$new_price', '$cat', '$productimg')";

    if ($conn->query($sql) === TRUE) {
        
        header('Location: adminportal.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
            
    $conn->close();
    

} ?>


<?php include 'includes/header.php'; ?>

<div class="card bg-light">
<article class="card-body mx-auto" style="max-width: 400px;">
	<br><br><br><br><br><br>
	<form method="post" enctype="multipart/form-data">
    <div class="form-group input-group">
		<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="bi bi-plus-square"></i> </span>
		 </div>
        <input name="brand" class="form-control" placeholder="Merk" type="text" required>
    </div>
    <div class="form-group input-group">
		<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="bi bi-plus-square"></i> </span>
		 </div>
        <input name="title" class="form-control" placeholder="Titel" type="text" required>
    </div>
    <div class="form-group input-group">
		<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="bi bi-plus-square"></i> </span>
		 </div>
        <input name="description" size="4" class="form-control" placeholder="Omschrijving" type="text" required>
    </div>
    <div class="form-group input-group">
		<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="bi bi-cash"></i> </span>
		 </div>
        <input name="old_price" class="form-control" placeholder="Prijs" type="text" required>
    </div>
    <div class="form-group input-group">
		<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="bi bi-cash"></i> </span>
		 </div>
        <input name="new_price" class="form-control" placeholder="Aanbiedingsprijs (optioneel)" type="text">
    </div>
	<div class="form-group input-group">
		<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="bi bi-card-list"></i>&nbsp Categorie: </span>
		 </div>
         <select class="form-control" name="cat">
         <?php 
            $conn = mysqli_connect('localhost','root','','pc4u');
            $sql = "SELECT * FROM cat";
            $result = mysqli_query($conn, $sql);
                            
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<option>
                '.$row['name'].'
            </option>';
            }                     
            ?>
        </select>
    </div>
    <div class="form-group input-group">
		<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="bi bi-cloud-upload"></i> </span>
		 </div>
        <input name="productimg" id="productimg" onchange="displayImage(this)" class="form-control" type="file" accept="image/x-png,image/jpeg" style="display: none;">
        <img src="img/placeholder.png" onclick="imgClick()" alt="placeholder" id="productDisplay"><br>
    </div>
    
        <?php if(!empty($msg)): ?>
            <input class="form-control <?php echo $css_class; ?>" value="<?php echo $msg; ?>" type="button">
        <?php endif; ?>
    <div class="form-group">
        <button name="productadd" type="submit" class="btn btn-primary btn-block"> Toevoegen  </button>
    </div>
    <div class="form-group">
        <button name="cancel" type="submit" class="btn btn-warning btn-block"> Annuleren  </button>
    </div>                                                            
</form>
</article>



</div>








<?php include 'includes/footer.php'; ?>
