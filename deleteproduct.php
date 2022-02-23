<?php 
session_start();

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
        $id = $_GET['id'];
        $conn = mysqli_connect('localhost','root','','pc4u'); 
        $sql = "SELECT * FROM products WHERE id='$id'"; 
        $result = mysqli_query($conn, $sql); 
        $row = mysqli_fetch_assoc($result);
        unlink('img/'.$row['productimg'].'');
        
        $conn = mysqli_connect('localhost','root','','pc4u');
        $sql = "DELETE FROM products where id='$id'";

        if ($conn->query($sql) === TRUE) {
            header('Location: adminportal.php');
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        mysqli_close($conn);

   } else { header('Location: index.php'); }
} else { header('Location: index.php'); }

?>