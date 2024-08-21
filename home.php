<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Veggie Heaven</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!--imageSlider javaScript-->
    <script>
      let slideIndex = 0; 
      function showSlides(){ 
        let i; 
        let slides = document.getElementsByClassName("slider-item"); 
        for (i = 0; i < slides.length; i++){
          slides[i].style.display = "none"; 
        } 
        slideIndex++; 
        if(slideIndex >= slides.length){slideIndex = 0} // Corrected condition
        slides[slideIndex].style.display = "block"; // Corrected index
        setTimeout(showSlides, 2000); 
      }
  </script>
  
</head>
<body onload="showSlides();">

    <!-- Navigation Bar -->
    <nav class="navbar navbar-fixed-top">
        <div class="navbar-container">
            <a class="navbar-brand" href="#">Green Veggie Heaven</a>
            <button class="navbar-toggler" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="./home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="./dishes.php">Dishes</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Veg Deals</a></li>
                <li class="nav-item"><a class="nav-link" href="./login.php">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Basket</a></li>
                <li class="nav-item "><a class="nav-link" href="#"><img  src="./img/icons8-user-50.png" alt="Food 2" style="height: 25px; width: 25px;"></a></li>
            </ul>
        </div>
    </nav>

    <!-- Image Slider -->
    <div class="image-slider">
      <div class="slider-item">
        <img src="PROD_Veg-Food-Banner_1645021052320_thumb_1200.jpeg" alt="Food 1">
      </div>
      <div class="slider-item">
        <img  src="./99b63ddee40456a5b8996420bf34ae1473368e82.webp" alt="Food 2">
      </div>
      <div class="slider-item">
        <img src="./image-2.png" alt="Food 3">
      </div>
    </div>

<!--- content-->
<div class="content"> <h3 class="p_h3">Our Products</h3></div>

    <div class="content">
   
    <div class="product-container">
        <?php
        $con = mysqli_connect("localhost", "root", "", "GreenVeggieHeaven");
        if(!$con) {
            die("Error: Could not connect to the database");
        }
        $result = mysqli_query($con, "SELECT * FROM Items");
        while ($row = mysqli_fetch_assoc($result)){
        ?>
        <div class="product-item">
            <div class="card">
                <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['itemName']; ?>">
                <div class="p_container">
                    <p><?php echo $row['itemName']; ?></p>  
                    <p><?php echo "Rs.".$row['price'].".00"; ?></p> 
                    <p><?php echo $row['quentity']; ?></p>
                    <a href="account.php"><img src="buy.png" alt="Buy" width="30px"></a>
                </div>
            </div>
        </div>
        <?php
        }
        mysqli_close($con);
        ?>
    </div>
</div>


        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <h5>Contact Information</h5>
                <p>Email: contact@greenveggieheaven.com</p>
                <p>Phone: +123 456 7890</p>
                <p>Address: 123 Green Street, Veggie Town</p>
            </div>
        </footer>
    </div>

</body>
</html>







