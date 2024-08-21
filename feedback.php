<?php
session_start();
include('db.php');

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Check if the session is started and user is logged in
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit();
    } else {
        $description = trim($_POST['iDescription']);
        $rating = $_POST['rating'];
        
        // Initialize error messages array
        $message = array();
        
        if (empty($description)) {
            $message[] = 'The description must not be empty';
        }
        if ($rating == 0) {
            $message[] = 'The rating must not be empty';
        }
        if (strlen($description) > 255) {
            $message[] = 'The description should not exceed 255 characters';
        }
        
        // If no errors, proceed to insert into database
        if (empty($message)) {
            $result = mysqli_query($conn, "SELECT * FROM Customer WHERE email='" . $_SESSION['user'] . "'");
            $row = mysqli_fetch_assoc($result);
            $name = $row['name'];
            $mail = $_SESSION['user'];
            
            $sql = "INSERT INTO feedback (name, rating, description, email) VALUES ('$name','$rating','$description','$mail')";
            
            $result = mysqli_query($conn, $sql);
            if ($result) {
                header("Location: feedback.php");
                exit();
            } else {
                $message[] = 'Could not add the review: ' . mysqli_error($con);
            }
        }
    }
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


.form-container {
	position: absolute;
	top: 0;
	height: 100%;
}

.sign-in-container {
	left: 0;
	width: 50%;
	z-index: 2;
}
a {
	text-decoration: none;
}

li {
	list-style: none;
}
h2{

font-size:small;
color:#666;


line-height: 1.5;

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
   font-size: 1.5rem;
   padding:1rem 3rem;
   background: #27ae60;
   color:var(--white);
   text-align: center;
}

.btn1:hover{
   background: #192a56;
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

.containerC{
 
   padding:2rem;

   	background-color: #fff;
	margin-top: 100px;
	margin-bottom: 50px;
	margin-left: 200px;
	border-radius: 10px ;
  	box-shadow: 0 14px 28px rgba(0,0,0,0.25), 
			0 10px 10px rgba(0,0,0,0.22);
	position: relative;
	overflow: hidden;
	width: 650px;
	max-width: 100%;
	min-height: 430px;
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
   margin-bottom: 20px;
}

.admin-product-form-container form h3{
   text-transform: uppercase;
   color:#192a56;
   margin-bottom: 1rem;
   text-align: center;
   font-size: 1.5rem;
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
h3{
    color: #192a56;
   text-transform: uppercase;
   margin-bottom: 1rem;
   text-align: center;
   font-size: 2rem;
}
.message{
    color: red;
    font-size: large;
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
	        <a class="active" href="./feedback.php">review</a>
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
	
<!-- review-->
<section class="home" id="home">
    <div class="containerC">
        <?php
            include('db.php');
            $result = mysqli_query($conn, "SELECT * FROM Customer WHERE email='" . $_SESSION['user'] . "'");
            $row = mysqli_fetch_assoc($result);
            $name = $row['name'];
        ?>
        <h3 class = "admin-product-form-container">Hello, <?php echo "$name"; ?></h3>       
        <div class="admin-product-form-container">
            <form method="POST" >
                <h3>Give your feedback</h3>
                <textarea name="iDescription" placeholder="Describe about the product" class="box"><?php echo isset($description) ? htmlspecialchars($description) : ''; ?></textarea>
                <h2>Rating </h2>
                <select name="rating" class="box">
                    <option value="0">Select Rating</option>
                    <option value="1" <?php echo ($rating == 1) ? ' selected' : ''; ?>>1</option>
                    <option value="2" <?php echo ($rating == 2) ? ' selected' : ''; ?>>2</option>
                    <option value="3" <?php echo ($rating == 3) ? ' selected' : ''; ?>>3</option>
                    <option value="4" <?php echo ($rating == 4) ? ' selected' : ''; ?>>4</option>
                    <option value="5" <?php echo ($rating == 5) ? ' selected' : ''; ?>>5</option>
                </select> 
                <p><input type="submit" value="Submit" name="submit" class="btn" /></p>
            </form>
        </div>
        <?php
            if (!empty($message)) {
                echo '<ul>';
                foreach($message as $message){
                    echo '<span class="message">'.$message.'</span>';
                }
                echo '</ul>';
            }
        ?>
    </div>
</section>
<div class="cc"></div>

 <!-- review section -->
 <section class="review" id="review">
		<h3 class="sub-heading">Reviews</h3>
		<h1 class="heading">Mine</h1>
		<div class="swiper-container review-slider">
		 	<div class="swiper-wrapper">
            <?php
               include('db.php');
                $result = mysqli_query($conn, "SELECT * FROM Feedback WHERE email='" . $_SESSION['user'] . "'");
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
    
    <!-- Footer-->
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="script.js"></script>
</body>
</html>