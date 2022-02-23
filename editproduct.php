

<?php session_start();
$id = $_GET['id'];
if (isset($_POST['cancel'])) {
    header('Location: adminportal.php');
}

if (isset($_POST['editproduct'])) {
    


    if (file_exists($_FILES['productimgedit']['tmp_name'])){
        $conn = mysqli_connect('localhost','root','','pc4u');
        $sql = "SELECT * FROM products WHERE id='$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $productimgName = time() . '_' . $_FILES['productimgedit']['name'];

        $target = 'img/' . $productimgName;
        $productimgdelete = $row['productimg'];
        
        if (move_uploaded_file($_FILES['productimgedit']['tmp_name'], $target)) {
            $msg = "Image uploaded";
            $css_class = "bg-succes";
            unlink('img/'.$productimgdelete.'');        
        } else {
            $msg = "Failed to upload to upload";
            $css_class = "bg-danger";
        }
    } else {
        $conn = mysqli_connect('localhost','root','','pc4u');
        $sql = "SELECT * FROM products WHERE id='$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $productimgName = $row['productimg'];
    }

    
    $brand = $_POST['brand'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $old_price = $_POST['old_price'];
    $new_price = $_POST['new_price'];
    $cat = $_POST['cat'];
    $productimg = $productimgName;
    mysqli_close($conn);
    $conn = mysqli_connect('localhost','root','','pc4u');
    

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

    $sql = "UPDATE products SET brand='$brand', title='$title', description='$description', old_price='$old_price', new_price='$new_price', cat='$cat', productimg='$productimg' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        
        header('Location: adminportal.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
            
    $conn->close();
    

} 
include 'includes/header.php';
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
        
        $conn = mysqli_connect('localhost','root','','pc4u');
        $sql = "SELECT * FROM products WHERE id='$id'";
        $result = mysqli_query($conn, $sql);

        $row = mysqli_fetch_assoc($result);
        echo '<div class="card bg-light">
        <article class="card-body mx-auto" style="max-width: 400px;">
            <br><br><br><br><br><br>
            <form method="post" enctype="multipart/form-data">
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="bi bi-plus-square"></i> </span>
                 </div>
                <input name="brand" class="form-control" value="'.$row['brand'].'" type="text" placeholder="Merk" required> 
            </div>
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="bi bi-plus-square"></i> </span>
                 </div>
                <input name="title" class="form-control" value="'.$row['title'].'" type="text" placeholder="Titel" required>
            </div>
            <div class="form-group input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"> <i class="bi bi-plus-square"></i> </span>
             </div>
            <input name="description" size="4" class="form-control" value="'.$row['description'].'" placeholder="Omschrijving" type="text" required>
            </div>
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="bi bi-cash"></i> </span>
                 </div>
                <input name="old_price" class="form-control" value="'.$row['old_price'].'" type="text" placeholder="Prijs" required>
            </div>
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="bi bi-cash"></i> </span>
                 </div>
                <input name="new_price" class="form-control" value="'.$row['new_price'].'" type="text" placeholder="Aanbiedingsprijs (optioneel)">
            </div>
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="bi bi-card-list"></i>&nbsp Categorie: </span>
                 </div>
                 <select class="form-control" name="cat">';
                    mysqli_close($conn);
                    $conn = mysqli_connect('localhost','root','','pc4u');
                    $sql = "SELECT * FROM cat";
                    $result = mysqli_query($conn, $sql);
                                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option>
                        '.$row['name'].'
                    </option>';
                    }                     
                    mysqli_close($conn);
                    $conn = mysqli_connect('localhost','root','','pc4u');
                    $sql = "SELECT * FROM products where id='$id'";
                    $result = mysqli_query($conn, $sql);

                    $row = mysqli_fetch_assoc($result);  
            echo '    </select>
            </div>
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="bi bi-cloud-upload"></i> </span>
                 </div>
                <input name="productimgedit" id="productimgedit" onchange="displayImageEdit(this)" class="form-control" type="file" accept="image/x-png,image/jpeg" style="display: none;">
                <img src="img/'.$row['productimg'].'" onclick="imgClickEdit()" alt="product" id="productDisplayEdit"><br>
            </div>';
            
                if(!empty($msg)): ?>
                    <input class="form-control <?php echo $css_class; ?>" value="<?php echo $msg; ?>" type="button">
                <?php endif;
            echo '<div class="form-group">
                <button name="editproduct" type="submit" class="btn btn-primary btn-block"> Bewerken  </button>
            </div>
            <div class="form-group">
                <button name="cancel" type="submit" class="btn btn-warning btn-block"> Annuleren  </button>
            </div>                                                            
        </form>
        </article>
        
        
        
        </div>';


        

   } else { header('Location: index.php'); }
} else { header('Location: index.php'); }

?>

<?php include 'includes/footer.php'; ?>


