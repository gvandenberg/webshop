<?php
session_start();
if (isset($_POST['login'])) {
    session_start();
    $email = $_POST['email'];
    $password = $_POST['password'];


    $conn = mysqli_connect('localhost','root','','pc4u');
    

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);

    if ($result->num_rows > 0) {
        if ($password == $row['password']) {
            $_SESSION['loggedin'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['email'] = $row['email'];
            header('Location: /index.php');
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
		    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
		 </div>
        <input name="email" class="form-control" placeholder="Email adres" type="email">
    </div>
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
		</div>
        <input name="password" class="form-control" placeholder="Wachtwoord" type="password">
    </div>
    <?php if (isset($_POST['login'])) { if ($result->num_rows < 1) { echo '<div class="form-group input-group">
        <a href=\'register.php\' class=\'text-decoration-none\'><input class="form-control  bg-warning" value="Email bestaat niet! Registreer je nu!" type="button"></a>
    </div>';}} ?>
    <?php if (isset($_POST['login'])) { if ($result->num_rows > 0) {
        if (!($password == $row['password'])) {
            echo '<div class="form-group input-group">
            <input class="form-control  bg-warning" value="Wachtwoord onjuist!" type="button">
            </div>';
        }
    }} ?>
    <div class="form-group">
        <button name="login" type="submit" class="btn btn-primary btn-block"> Inloggen  </button>
    </div>     
    <p class="text-center">Heb nog geen account? <a href="/register.php">Registreren</a> </p>                                                                 
</form>
</article>
</div>

</div> 



<?php include 'includes/footer.php'; ?>