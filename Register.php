<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $message = "";

    if(isset($_POST['register'])){
        $name = $_POST['txtName'];
        $number = $_POST['txtContactNo'];
        $mail = $_POST['txtEmail'];
        $password = md5($_POST['txtPassword']);

		$sql = "SELECT * FROM Customer WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $mail);
$stmt->execute();
$result = $stmt->get_result();


        if ($result->num_rows == 1) {
            $message = "Email is already registered"; // Assign the error message as a string
        } else {
            $stmt = $conn->prepare("INSERT INTO Customer (name, contactNo, email, Password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $number, $mail, $password);
            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                $message = "Error: " . $conn->error; // Assign the error message as a string
            }
            $stmt->close();
        }
    }
} else {
    $message = ""; // Reset $message to an empty string if the form was not submitted
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="./style.css">
    <style>

body {
	background: #f6f5f7;
	display: flex;
	justify-content: center;
	flex-direction: column;
	font-family: 'Montserrat', sans-serif;
	height: 100vh;
	margin: -20px 0 50px;
}
.loginh1{
    font-style:italic;
	font-weight: bold;
    font-size: 23px;
    color: #228B22;
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
	border-radius: 10px;
	margin-top: 300px;
	margin-bottom: 50px;
	margin-left: 170px;
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
	right: 0;
}
    
    </style>
  
</head>
<body>
	<header>
		<a href="#" class="logo"><i class="fas fa-carrot"></i>Green Veggie Heaven</a>
		<nav class="navbar">
			<a class="active" href="./index.php">Home</a>
			<a href="#dishes">dishes</a>
			<a href="#about">about</a>
			<a href="#menu">menu</a>
			<a href="./feedback.php">review</a>
			<a href="./login.php">Login</a>
		</nav>
		<div class="icons">
			<i class="fas fa-bars" id="menu-bars"></i>
			<i class="fas fa-search" id="search-icon"></i>
			<a href="./myAccount.php" class="fas fa-user"></a>
			<a href="./card.php" class="fas fa-shopping-cart"></a>
		</div>
	</header>

<!-- search form -->
<form action="" id="search-form">
		<input type="search" name="" placeholder="Search here..." id="search-box">
		<label for="search-box" class="fas fa-search"></label>
		<i class="fas fa-times" id="close"></i>
	</form>
<!-- end of search form -->

<section>
    <h2>Green Veggie Heaven</h2>
    <div class="container" id="container">
        <div class="form-container sign-in-container">

		<form name="register" method="post" action="#" onsubmit="return checkPassword()">
    <h1><a href="./home.html">Green Veggie Heaven</a></h1>
    <h1>Sign up</h1>
    <input type="text" placeholder="Name" name="txtName" id="txtName" required/>
    <input type="email" placeholder="Email" name="txtEmail" id="txtEmail" required/>
    <input type="password" placeholder="Password" id="txtPassword" name="txtPassword" required/>
    <input type="password" placeholder="Confirm Password" id="txtConfirmPassword" name="txtConfirmPassword" required/>
    <input type="tel" placeholder="Contact Number" name="txtContactNo" id="txtContactNo" pattern="[0-9]{10}" required/>
	<?php
if (!empty($message)) {
    echo '<ul>';
    echo '<li class="message">' . $message . '</li>'; // Display the error message directly
    echo '</ul>';
}
?>

    <input type="submit" value="Sign Up" name="register">
</form>
        </div>
        <div class="overlay-panel overlay-right">
            <img src="/GreenVeggieHeaven/loginImg01.jpeg" alt="Welcome Image">
        </div>
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

	<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
	<script src="script.js"></script>
	<script>
    function checkPassword() {
        var password = document.getElementById('txtPassword').value;
        var confirmPassword = document.getElementById('txtConfirmPassword').value;

        if (password != confirmPassword) {
            alert("Passwords do not match.");
            return false;
        }
        return true;
    }
</script>
</body>
</html>