<?php
session_start();
include('db.php');

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$sql = "select * from Customer where email='" . $_SESSION['user'] . "'";
$result = mysqli_query($conn, $sql);
$record = mysqli_fetch_assoc($result);

$sql1 = "SELECT * FROM orders where email='" . $_SESSION['user'] . "'";
$order_result =mysqli_query($conn, $sql1);


if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    // Redirect to the login page
    header("Location: login.php");
    exit;
}


mysqli_close($conn);
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
    /* Reset CSS */


/* Body styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    font-size: large;
}

/* Container styles */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}



/* Section styles */
.section {
    margin-bottom: 40px;
}

.section h2 {
    color: #333;
    margin-bottom: 20px;
}

/* Personal info styles */
.info p {
    margin-bottom: 10px;
}

/* Order history styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

table th, table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

table th {
    background-color: #f2f2f2;
    color: #333;
}

/* Loyalty points styles */
#loyalty-points p {
    margin-bottom: 10px;
}

/* Footer styles */
footer {
    background-color: #333;
    color: #fff;
    padding: 20px 0;
    text-align: center;
}

    </style>
</head>
<body>
    <!-- header -->
	<header>

	    <a href="./index.php" class="logo"><i class="fas fa-carrot"></i>Green Veggie Heaven</a>
	    <nav class="navbar">
	        <a href="./index.php">Home</a>
	        <a href="./Dishes.php">dishes</a>
	        <a href="./aboutUs.html">about</a>
	        <a href="./promotion.php">menu</a>
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
	<!-- End of the header -->

    <!-- search form -->
	<form action="" id="search-form">
		<input type="search" name="" placeholder="Search here..." id="search-box">
		<label for="search-box" class="fas fa-search"></label>
		<i class="fas fa-times" id="close"></i>
	</form>

    <div class="container">
           
    </div>


    <section id="personal-info" class="section">
        <div class="container">
            <h2>Personal Information</h2>
            <div class="info">
                <p><strong>Name:</strong> <?php echo $record['name']; ?></p>
                <p><strong>Email:</strong> <?php echo $record['email']; ?></p>
                <p><strong>Contact No:</strong> <?php echo $record['contactNo']; ?></p>
                <?php if (isset($record['customerID'])) : ?>
        <a href="./myAccount.php?logout">Logout</a>
    <?php endif; ?>
            </div>
        </div>
    </section>

   


<section id="order-history" class="section">
        <div class="container">
            <h2>Order History</h2>
            <?php if (mysqli_num_rows($order_result) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = mysqli_fetch_assoc($order_result)) : ?>
                            <tr>
                                <td><?php echo $order['id']; ?></td>
                                <td><?php echo $order['created_at']; ?></td>
                                <td>Rs.<?php echo $order['total_price']; ?></td>
                                <td><?php echo $order['status']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>No orders found.</p>
            <?php endif; ?>
        </div>
    </section>

    


    <!-- Footer section starts -->
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
	<!-- end of footer section -->
</body>
</html>