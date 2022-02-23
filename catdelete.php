<?php 
session_start();

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
        $catname = $_SESSION['catname'];
        $id = $_GET['id'];
        $conn = mysqli_connect('localhost','root','','pc4u');
        $sql = "DELETE FROM cat where id='$id'";

        if ($conn->query($sql) === TRUE) {
            unlink("templates/".$catname.".php");
            unlink("cat/".$catname.".php");
            header('Location: adminportal.php');
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        mysqli_close($conn);

   } else { header('Location: index.php'); }
} else { header('Location: index.php'); }

?>