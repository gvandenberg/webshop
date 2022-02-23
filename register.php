


<?php
session_start();
if (isset($_POST['create'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['landcode'] . $_POST['phone_number'];
    $password = $_POST['password'];
    $passwordconfirm = $_POST['passwordconfirm'];


    $conn = mysqli_connect('localhost','root','','pc4u');
    

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows < 1) {

        if ($password == $passwordconfirm) {
            $sql = "INSERT INTO users (full_name, email, phone_number, password, role)
            VALUES ('$full_name','$email','$phone_number','$password','user')";

            if ($conn->query($sql) === TRUE) {
                header('Location: login.php');
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            
            $conn->close();
        }
    }

}


?>

<?php include 'includes/header.php'; ?>

<div class="card bg-light">
<article class="card-body mx-auto" style="max-width: 400px;">
	<br><br><br><br><br><br>
	<form method="post">
	<div class="form-group input-group">
		<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
		 </div>
        <input name="full_name" class="form-control" placeholder="Volledige naam" type="text">
    </div>
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
		 </div>
        <input name="email" class="form-control" placeholder="Email adres" type="email">
    </div>
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
		</div>
		<select name="landcode" class="custom-select" style="max-width: 120px;">
		    <option selected="">+31</option>
		    <option value="1">+32</option>
		</select>
    	<input name="phone_number" class="form-control" placeholder="Telefoonnummer" type="text">
    </div>
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
		</div>
        <input name="password" class="form-control" placeholder="Wachtwoord" type="password">
    </div>
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
		</div>
        <input name="passwordconfirm" class="form-control" placeholder="Herhaal wachtwoord" type="password">
    </div>
    <?php if (isset($_POST['create'])) { if ($result->num_rows > 0) { echo '<div class="form-group input-group">
        <a href=\'login.php\' class=\'text-decoration-none\'><input class="form-control  bg-warning" value="Email word al gebruikt!            Log hier in" type="button"></a>
    </div>';}} ?>
    <?php if (isset($_POST['create'])) { if (!($password == $passwordconfirm)) { echo '<div class="form-group input-group">
        <input class="form-control bg-danger" value="Je wachtwoorden komen niet overeen!" type="button">
    </div>';}} ?>
    <div class="form-group">
        <button name="create" type="submit" class="btn btn-primary btn-block"> Maak account  </button>
    </div>     
    <p class="text-center">Heb je al een account? <a href="/login.php">Log In</a> </p>                                                                 
</form>
</article>
</div>

</div> 



<?php include 'includes/footer.php'; ?>