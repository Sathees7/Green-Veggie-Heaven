<?php 
  if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $con = mysqli_connect("localhost", "root", "", "GreenVeggieHeaven");
    $sql = "DELETE FROM Items WHERE itemID = " . $id;
    mysqli_query($con,$sql);
    mysqli_close($con);
    header('Location:viewItems.php');
 };
?>