<?php 
  if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $con = mysqli_connect("localhost", "root", "", "GreenVeggieHeaven");
    $sql = "DELETE FROM Customer WHERE customerID = " . $id;
    mysqli_query($con,$sql);
    mysqli_close($con);
    header('Location: user.php');
 };
?>