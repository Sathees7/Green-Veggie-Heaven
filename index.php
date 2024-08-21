<?php
session_start();
include('db.php');

// Add to cart
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productId = $_POST["product_id"];

    $_SESSION["cart"][$productId] = 1;
}

// Fetch products
$sql = "SELECT * FROM Items";
$result = $conn->query($sql);
$products = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Fetch promotions
$sql1 = "SELECT * FROM Promotion";
$result1 = $conn->query($sql1);
$promotion = [];

if ($result1->num_rows > 0) {
    while($row = $result1->fetch_assoc()) {
        $promotion[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Veggie Heaven</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="./style.css">
</head>
<body>
	<header>
	    <a href="./index.php" class="logo"><i class="fas fa-carrot"></i>Green Veggie Heaven</a>
	    <nav class="navbar">
	        <a class="active" href="./index.php">Home</a>
	        <a href="./Dishes.php">dishes</a>
	        <a href="./aboutUs.html">about</a>
	        <a href="./promotion.php">Offers</a>
	        <a href="./feedback.php">review</a>
	        <a href="./login.php">Login</a>
	    </nav>
	    <div class="icons">
	        <i class="fas fa-bars" id="menu-bars"></i>
	        <i class="fas fa-search" id="search-icon"></i>
	        <a href="./myAccount.php" class="fas fa-user"></a>
			<a href="./card.php" class="fas fa-shopping-cart">
    			<?php
    				// Check if the cart session variable exists and has items
    				if(isset($_SESSION["cart"]) && count($_SESSION["cart"]) > 0) {
        				$itemCount = array_sum($_SESSION["cart"]);
        				echo "<span class='badge'>$itemCount</span>";
    				}
    			?>
			</a>
	    </div>
	</header>

    <!-- search form -->
	<form action="" id="search-form">
		<input type="search" name="" placeholder="Search here..." id="search-box">
		<label for="search-box" class="fas fa-search"></label>
		<i class="fas fa-times" id="close"></i>
	</form>

	<!--home -->
    <section class="home" id="home">
		<div class="swiper-container home-slider">
			<div class="swiper-wrapper wrapper">
				<div class="swiper-slide slide">
					<div class="content">
						<span>Our Special Dish</span>
						<h3>Paneer Butter Masala Dosa</h3>
						<p>Experience the sizzle and aroma as golden dosa graces the griddle. Inside, indulge in tender paneer, onions, tomatoes, and aromatic spices.</p>
						<p> A symphony of flavors awaits, promising a feast for the senses at Green Veggie Haven.</p>
						<form method='post' action=''>
    						<input type="hidden" name="product_id" value="31">
    						<input type="hidden" class="quantity" name="quantity" value="1">
    						<button type="submit" class="btn">Order now</button>
						</form>	
					</div>
					<div class="image">
						<img src="./img/item2.png" alt="">
					</div>
				</div>
				<div class="swiper-slide slide">
					<div class="content">
						<span>Our Special Dish</span>
						<h3>Indian Upma <br>Utopia</h3>
						<p>Upma, a beloved South Indian breakfast, features roasted rava cooked with onions, spices, and ghee.</p>
						<p>Its comforting flavors and fluffy texture make it a cherished morning delight.</p>
						<form method='post' action=''>
    						<input type="hidden" name="product_id" value="34">
    						<input type="hidden" class="quantity" name="quantity" value="1">
    						<button type="submit" class="btn">Order now</button>
						</form>	
					</div>
					<div class="image">
						<img src="./img/item8.png" alt="">
					</div>
				</div>
				<div class="swiper-slide slide">
					<div class="content">
						<span>Our Special Dish</span>
						<h3>Paneer Butter Masala Dosa</h3>
						<p>Experience the sizzle and aroma as golden dosa graces the griddle. Inside, indulge in tender paneer, onions, tomatoes, and aromatic spices.</p>
						<p> A symphony of flavors awaits, promising a feast for the senses at Green Veggie Haven.</p>
						<form method='post' action=''>
    						<input type="hidden" name="product_id" value="35">
    						<input type="hidden" class="quantity" name="quantity" value="1">
    						<button type="submit" class="btn">Order now</button>
						</form>	
					</div>
					<div class="image">
						<img src="./img/item6.png" alt="">
					</div>
				</div> 
			</div>
			<div class="swiper-pagination"> </div>
		</div>
	</section>

<!-- dishes -->
<section class="dishes" id="dishes">
    <h3 class="sub-heading">Our dishes</h3>
    <h1 class="heading">Today's Special</h1>
    <div class="box-container">
        <?php foreach ($products as $product): ?>
            <div class='box'>
                <form method='post' action=''>
                    <input type="hidden" name="product_id" value="<?= $product["itemID"] ?>">
                    <img src="<?= $product["image"] ?>" alt="<?= $product["itemName"] ?>"/>
                    <h3><?= $product["itemName"] ?></h3>
                    <h2>Rs.<?= $product["price"] ?></h2>
                    <input type="submit" value="Add to Cart" class='btnD'>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- about  -->
	<section class="about" id="about">
		<h3 class="sub-heading">about us</h3>
		<h1 class="heading">Why choose us</h1>
		<div class="row">
			<div class="image">
				<img src="./img/item2.png" alt="">
			</div>
		 	<div class="content">
				<h3>delicious Veditatian food</h3>
				<p>Welcome to Green Veggie Heaven Colombo, where we offer a delectable array of vegetarian cuisine that will tantalize your taste buds. Our menu features a delightful selection of North Indian, South Indian, and Sri Lankan specialties, each meticulously crafted to perfection by our skilled chefs.</p>
				<p>At Green Veggie Heaven, we pride ourselves on using only the finest ingredients to create dishes that are bursting with flavor. From the rich gravies to the authentic spices, every bite is a celebration of taste and tradition.</p>
				<p>Whether you're dining in with us or opting for takeout, we strive to provide every guest with an exceptional culinary experience. Our goal is to ensure that each visit to Green Veggie Heaven is memorable, leaving you craving for more.</p>
			 	<div class="icons-container">
			 		<div class="icons">
						<i class="fas fa-shipping-fast"></i>
				 		<span>Take away</span>
				 	</div>
					<div class="icons">
						<i class="fas fa-handshake"></i>
				 		<span>Get offers</span>
				 	</div>
			 	</div>
			 	<a href="#" class="btn">learn more</a>
			</div>
		</div>
	</section>

    <!--Promotions section -->
	<section class="dishes" id="dishes">
    	<h3 class="sub-heading">Our dishes</h3>
    	<h1 class="heading">Today's Special</h1>
    	<div class="box-container">
        	<?php foreach ($promotion as $promotions): ?>
            	<div class='box'>
                	<form method='post' action=''>
                    	<input type="hidden" name="product_id" value="<?= $promotions["promotionID"] ?>">
                    	<img src="<?= $promotions["image"] ?>" alt="<?= $promotions["promotionName"] ?>"/>	
                    	<h3><?= $promotions["promotionName"] ?></h3>
						<h2><?= $promotions["description"] ?></h2>
						<h2>Rs.<?= $promotions["price"] ?></h2>
                    	<input type="submit" value="Add to Cart" class='btnD'>
               		</form>
            	</div>
       		<?php endforeach; ?>
    	</div>
	</section>

    <!-- review section -->
    <section class="review" id="review">
		<h3 class="sub-heading">Customer's review</h3>
		<h1 class="heading">What they say</h1>
		<div class="swiper-container review-slider">
		 	<div class="swiper-wrapper">
            <?php
               include('db.php');

                $result = mysqli_query($conn, "SELECT * FROM Feedback");
                while ($row = mysqli_fetch_assoc($result))
                {
            ?> 
			 	<div class="swiper-slide slide">
					<i class="fas fa-quote-right"></i>
			 		<div class="user">
				 		<img src="./img/user-6.png" alt="">
				 		<div class="user-info">
							<h3><?php echo $row['name']; ?></h3>
							<div class="stars">
							    <i class="fas fa-star"></i>
			 					<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star"></i>
								<i class="fas fa-star-half-alt"></i>
					  		</div>
				 		</div>
				 	</div>
				 	<p><?php echo $row['description']; ?></p>
				</div>
                <?php
                }
                    mysqli_close($conn);
                ?>
            </div>
		</div>
	</section>

    <!-- Footer -->
	<section class="footer">
        <div class="fbox">
            <h3>Contact Info</h3>
		    <p>R. vimalraj</p>
		    <p>+94773344314</p>
		    <p>greenveggieheaven@gmail.com</p>
		    <p>vimalraj@gmail.com</p>
		    <p>1st Street,Pettah</p>
        </div>
		<div class="credit">Copyright @ 2024 by <span>Mr Sathees</span></div>
	</section>


    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
	<script src="script.js"></script>
</body>
</html>