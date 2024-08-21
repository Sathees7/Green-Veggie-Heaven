<?php 
  if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $con = mysqli_connect("localhost", "root", "", "GreenVeggieHeaven");
    $sql = "DELETE FROM Promotion WHERE promotionID = " . $id;
    mysqli_query($con,$sql);
    mysqli_close($con);
    header('Location: viewPromotion.php');
 };
?>