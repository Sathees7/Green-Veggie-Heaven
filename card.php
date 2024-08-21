<?php
session_start();
include('db.php');

// Remove item from cart
if (isset($_POST["remove_item"])) {
    $productId = $_POST["product_id"];
    
    if (isset($_SESSION["cart"][$productId])) {
        unset($_SESSION["cart"][$productId]);
    }
}

$cart = $_SESSION["cart"] ?? [];
$orders = [];
$total = 0;

foreach ($cart as $productId => $productId) { 
    $sql = "SELECT itemName, price, image FROM Items WHERE itemID = $productId";
    $sql1 = "SELECT promotionName, price, image FROM Promotion WHERE promotionID = $productId";
    $result = $conn->query($sql);
    $result1 = $conn->query($sql1);

    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row["itemName"];
        $price = $row["price"];
        $image = $row["image"];
        $orders[] = [
            "product_id" => $productId,
            "name" => $name,
            "price" => $price,
            "image" => $image,
            "quantity" => $quantity
        ];
        $total += $price * $quantity;
    }else if($result1->num_rows > 0 ){
        $row = $result1->fetch_assoc();
        $name = $row["promotionName"];
        $price = $row["price"];
        $image = $row["image"];
        $orders[] = [
            "product_id" => $productId,
            "name" => $name,
            "price" => $price,
            "image" => $image,
            "quantity" => $quantity
        ];
        $total += $price * $quantity;
    }
}

// Insert orders into database
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["checkout"])) {
    if(!$_SESSION["user"]){
        header("Location: login.php");
        exit(); 
    }else{
        $conn->begin_transaction();

        try {
            foreach ($orders as $order) {
                $productId = $order["product_id"];
                $quantity = $_POST["quantity" . $order['product_id']];
                $totalPrice = $order["price"] * $quantity;
                $email = $_SESSION["user"];
                $status = "Processing";
            
                $sql = "INSERT INTO orders (product_id, quantity, total_price, email, status) VALUES ('$productId', '$quantity', '$totalPrice', '$email', '$status')";
            
                if (!$conn->query($sql)) {
                    throw new Exception("Error inserting order: " . $conn->error);
                }
            }

            $conn->commit();

            // Clear cart
            unset($_SESSION["cart"]);

            header("Location: index.php");
            exit();
        }catch (Exception $e) {
            $conn->rollback();
            echo "Transaction failed: " . $e->getMessage();
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
	    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap');

        .container{
            max-width: 1200px;
            padding:2rem;
            margin:100px auto;
            background-color: #fff;
	        border-radius: 10px;
  	        box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
	        position: relative;
	        overflow: hidden;
            margin-bottom: 50px;
        }
        #content {
	        position: relative;
	        width: calc(100% - 280px);
	        left: 280px;
        }
        #content main {
	        border-top: #1D5603;
	        width: 100%;
	        padding: 36px 24px;
        }
        #content main .box-info {
	        display: grid;
	        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
	        grid-gap: 24px;
	        margin-top: 36px;
        }
        .text h2,p{
	        font-size: large;
        }
        a{
	        text-decoration: none;
        }
        li {
	        list-style: none;
        }



:root{
   --green:#27ae60;
   --black:#333;
   --white:#fff;
   --bg-color:#eee;
   --box-shadow:0 .5rem 1rem rgba(0,0,0,.1);
   --border:.1rem solid var(--black);
}

.btn1{
   display: block;
   width: 100%;
   cursor: pointer;
   border-radius: .5rem;
   margin-top: 1rem;
   font-size: 2rem;
   font-weight: bold;
   padding:1rem ;
   background: #eee;
   color:black;
   text-align: center;
}

.btn1:hover{
   background: gray;
}

.message{
   display: block;
   background: var(--bg-color);
   padding:1.5rem 1rem;
   font-size: 2rem;
   color:var(--black);
   margin-bottom: 2rem;
   text-align: center;
}

.admin-product-form-container.centered{
   display: flex;
   align-items: center;
   justify-content: center;
   min-height: 100vh;
   
}

.admin-product-form-container form{
   max-width: 50rem;
   margin:0 auto;
   padding:2rem;
   border-radius: .5rem;
   background: var(--bg-color);
}

.admin-product-form-container form h3{
   text-transform: uppercase;
   color:var(--black);
   margin-bottom: 1rem;
   text-align: center;
   font-size: 2.5rem;
}

.admin-product-form-container form .box{
   width: 100%;
   border-radius: .5rem;
   padding:1.2rem 1.5rem;
   font-size: 1.7rem;
   margin:1rem 0;
   background: var(--white);
   text-transform: none;
}

.product-display{
   margin:2rem 0;
}

.product-display .product-display-table{
   width: 100%;
   text-align: center;
}

.product-display .product-display-table thead{
   background: var(--bg-color);
}

.product-display .product-display-table th{
   padding:1rem;
   font-size: 2rem;
}


.product-display .product-display-table td{
   padding:1rem;
   font-size: 2rem;
   border-bottom: #27ae60;
}

.product-display .product-display-table .btn:first-child{
   margin-top: 0;
}

.product-display .product-display-table .btn:last-child{
   background: crimson;
}

.product-display .product-display-table .btn:last-child:hover{
   background: var(--black);
}


@media (max-width:991px){

   html{
      font-size: 55%;
   }

}

@media (max-width:768px){

   .product-display{
      overflow-y:scroll;
   }

   .product-display .product-display-table{
      width: 80rem;
   }

}

@media (max-width:450px){

   html{
      font-size: 50%;
   }

}
</style>
</head>
<body>
	<header>
	    <a href="./index.php" class="logo"><i class="fas fa-carrot"></i>Green Veggie Heaven</a>
	    <nav class="navbar">
	        <a href="./index.php">Home</a>
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

<!-- Card section -->
<!-- Card section -->
<div class="container">
    <div class="product-display">
        <table class="product-display-table">
            <thead>
                <tr>
                    <th>Item Image</th>
                    <th>Item name</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Item Total</th> 
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><img src="<?= $order['image'] ?>" height='100'></td>
                        <td><h3><?= $order["name"] ?></h3></td>
                        <td>
                        <form action="" method="post">
                        <div class="input-group">
                            <label for="quantity<?= $order['product_id'] ?>">Quantity</label>
                            <input type="number" class="quantity" id="quantity<?= $order['product_id'] ?>" name="quantity<?= $order['product_id'] ?>" value="1" data-price="<?= $order["price"] ?>" data-product-id="<?= $order['product_id'] ?>">
                        </div>
                        </td>
                        <td class="unit-price">Rs.<?= $order["price"] ?></td>
                        <td class="item-total" name="item-total" >Rs.<?= $order["price"] ?></td>
                        <input type="hidden" name="item_totals[]" value="<?= $order["price"] ?>">
                        <td>
                            <input type="hidden" name="product_id" value="<?= $order["product_id"] ?>">
                            <input type="submit" name="remove_item" value="Remove" class="btn">
                        </td>

                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="2" align="center">
                        <h2>Total Rs. <span id="total"><?= $total ?></span></h2> 
                            <input type="submit" name="checkout" value="Checkout" class="btn1">
                        <a href="index.php" class="btn1">Continue Shopping</a>   
                    </td> 
                    </form> 
                </tr>
            </tbody>
        </table>
    </div>
</div>

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

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const quantityInputs = document.querySelectorAll(".quantity");
    quantityInputs.forEach(function(input) {
        input.addEventListener("input", function() {
            // Check if the entered value is negative
            if (parseInt(this.value) < 1) {
                // If negative, reset the value to 1 or any other default value
                this.value = 1;
            } else {
                // If positive, calculate item total and update total
                const quantity = parseInt(this.value);
                const price = parseFloat(this.getAttribute("data-price"));
                const itemTotalElement = this.closest("tr").querySelector(".item-total");
                const itemTotal = quantity * price;
                itemTotalElement.textContent = `Rs.${itemTotal.toFixed(2)}`;
                
                // Recalculate total
                let total = 0;
                document.querySelectorAll(".item-total").forEach(function(item) {
                    total += parseFloat(item.textContent.replace("Rs.", ""));
                });
                document.getElementById("total").textContent = `Rs.${total.toFixed(2)}`;
            }
        });
    });
});

</script>


</body>
</html>