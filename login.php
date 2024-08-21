<?php
session_start();
include('db.php');
$message = array();

if (isset($_POST['btnSubmit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['txtEmail']);
    $password = mysqli_real_escape_string($conn, $_POST['txtPassword']);
    
    // Check if email and password are not empty
    if (empty($email) || empty($password)) {
        $message[] = 'Email and password are required.';
    } else {
        // Check if admin login
        if ($email == "admin@gmail.com") {
            $sql = "SELECT * FROM Admin WHERE email='$email'";
            $redirect_page = "dashboard.php"; 
        } else {
            $sql = "SELECT * FROM Customer WHERE email='$email'";
            $redirect_page = "myAccount.php"; 
        }
        
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        
        // Check if user exists and password is correct
        if (empty($row)) {
            $message[] = 'The email address and password are invalid';
        } elseif (md5($password )== $row['Password']) {
			$_SESSION['user'] = $email;
            header("Location: $redirect_page");
            exit();
            
        } else {
			$message[] = 'The Password is invalid';
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
    <title>Login</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="./style.css">
	<script>
    	function checkPassword(){
            let pw = document.getElementById("txtPassword").value;
            let cpw = document.getElementById("txtConfimPassword").value;
            if(pw != cpw){
                alert("Password and confrim password should be the same 12");
                event.preventDefault();
            }else{
				document.forms['F1'].submit();
			}
        }
    </script>
    <style>
body {
	display: flex;
	justify-content: center;
	flex-direction: column;
	height: 100vh;
	margin: -20px 0 50px;
}
.loginh1{
    font-style:italic;
	font-weight: bold;
    font-size: 23px;
    color: #27ae60;
	margin: 0;
}
.container h1 {
    font-style:italic;
	font-weight: bold;
    font-size: 20px;
	margin: 0;
}

.container h2 {
	text-align: center;
}


.container a {
	color: #333;
	font-size: 14px;
	text-decoration: none;
	margin: 15px 0;
}

.container input[type="submit"] {
	border-radius: 20px;
	border: 1px solid #228B22;
	background-color: #228B22;
	color: #FFFFFF;
	font-size: 12px;
	font-weight: bold;
	padding: 12px 45px;
	letter-spacing: 1px;
	text-transform: uppercase;
}


.container form {
	background-color: #FFFFFF;
	display: flex;
	align-items: center;
	justify-content: center;
	flex-direction: column;
	padding: 0 50px;
	height: 100%;
	text-align: center;
}

.container input {
	background-color: #eee;
	border: none;
	padding: 12px 15px;
	margin: 8px 0;
	width: 100%;
}

.container {
	background-color: #fff;
	margin-top: 300px;
	margin-bottom: 50px;
	margin-left: 200px;
	border-radius: 10px ;
  	box-shadow: 0 14px 28px rgba(0,0,0,0.25), 
			0 10px 10px rgba(0,0,0,0.22);
	position: relative;
	overflow: hidden;
	width: 768px;
	max-width: 100%;
	min-height: 480px;
}

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

.overlay-panel { 
	position: absolute;
	display: flex;
	align-items: center;
	justify-content: center;
	flex-direction: column;
	text-align: center;
	top: 0;
	height: 100%;
	width: 80%;
}

.overlay-right {
	right: 30px;
}
.message{
    color: red;
    font-size: 12px;
    margin-top: 2px;
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
			<a class="active" href="./login.php">Login</a>
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

<section>
    <h2>Welcome to Green Veggie Heaven.</h2>
    <div class="container" id="container">
        <div class="form-container sign-in-container">
            <form method="post">
                <h1 class="loginh1">Green Veggie Heaven</h1>
                <h1>Sign in</h1>
				<input type="email" name="txtEmail" placeholder="Email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required/>
				<input type="password" name="txtPassword" placeholder="Password" value="<?php echo isset($password) ? htmlspecialchars($password) : ''; ?>" required/>
                <?php
                if (!empty($message)) {
                    echo '<ul>';
                    foreach ($message as $msg){
                        echo '<li class="message">' . $msg . '</li>';
                    }
                    echo '</ul>';
                }
                ?>
                <a href="#">Forgot your password?</a>
                <input type="submit" value="Sign In" name="btnSubmit">
                <br>
                <a href="./Register.php">Don't have an account? SIGN UP</a>
            </form>
        </div>
        <div class="overlay-panel overlay-right"><img src="/GreenVeggieHeaven/loginImg01.jpeg" alt=""></div>
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