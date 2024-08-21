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
// Initialize productsByCategory as an empty array
$productsByCategory = [];

// Fetch all products if no category is selected
if (!isset($_GET['category'])) {
    $sqlProducts = "SELECT * FROM Items";
} else {
    // Fetch products based on category
    $category = $_GET['category'];
    if ($category == 'all') {
        $sqlProducts = "SELECT * FROM Items";
    } else {
        $sqlProducts = "SELECT * FROM Items WHERE catogory = '$category'";
    }
}

$resultProducts = $conn->query($sqlProducts);

if (!$resultProducts) {
    // Display error message if query fails
    echo "Error: " . $sqlProducts . "<br>" . $conn->error;
} else {
    if ($resultProducts->num_rows > 0) {
        while ($row = $resultProducts->fetch_assoc()) {
            $productsByCategory[] = $row;
        }
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
    <style>
    .containerX{
        margin-top: 80px;
    }
    .category-form {
        margin-bottom: 10px;
    }
    </style>
</head>
<body>
	<header>
	    <a href="./index.php" class="logo"><i class="fas fa-carrot"></i>Green Veggie Heaven</a>
	    <nav class="navbar">
	        <a href="./index.php">Home</a>
	        <a  class="active" href="./Dishes.php">dishes</a>
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

    <!-- dishes -->
    <div class="containerX">
        <section class="dishes" id="dishes">
            <h3 class="sub-heading">Our dishes</h3>
            <h1 class="heading">Today's Special</h1>
            <form id="category-form" class="category-form">
            <select name="category" id="category-select">
                <option value="all">All Dishes</option> 
                <option value="breakfast"<?php if(isset($_GET['category']) && $_GET['category'] == 'breakfast') echo ' selected'; ?>>Breakfast</option>
                <option value="lunch"<?php if(isset($_GET['category']) && $_GET['category'] == 'lunch') echo ' selected'; ?>>Lunch</option>
                <option value="dinner"<?php if(isset($_GET['category']) && $_GET['category'] == 'dinner') echo ' selected'; ?>>Dinner</option>
            </select>
            </form>
            <div class="box-container" id="food-list">
                <?php foreach ($productsByCategory as $product): ?>
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
    </div>

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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const categoryForm = document.getElementById("category-form");

            // Event listener for category selection change
            categoryForm.addEventListener("change", function() {
                // Submit the form when the category is changed
                categoryForm.submit();
            });
        });
    </script>

</body>
</html>