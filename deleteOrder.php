<?php 
  if(isset($_GET['cancel'])){
    $id = $_GET['cancel'];
    $con = mysqli_connect("localhost", "root", "", "GreenVeggieHeaven");
    $sql = "UPDATE orders SET status = 'Cancelled' WHERE id = " . $id;
    mysqli_query($con,$sql);
    mysqli_close($con);
    header('Location: orderManagement.php');
 }else if (isset($_GET['ready'])){
  $id = $_GET['ready'];
  $con = mysqli_connect("localhost", "root", "", "GreenVeggieHeaven");
  $sql = "UPDATE orders SET status = 'Collected' WHERE id = " . $id;
  mysqli_query($con,$sql);
  mysqli_close($con);
  header('Location: orderManagement.php'); 
 };
?>