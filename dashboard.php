<?php
session_start();
if(isset($_SESSION['user'])){
  $con = mysqli_connect("localhost", "root", "", "GreenVeggieHeaven");
  $sql="select * from Admin where email='".$_SESSION['user']."'";
  $result=mysqli_query($con,$sql);
  $record=mysqli_fetch_assoc($result);
  $adminName = $record['userName'];
}else {
  echo 'error';
  exit; // Exit if the user is not logged in
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>
   <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<style>
	@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap');
* {
	font-family: 'Poppins', sans-serif;
	margin: 0;
	padding: 0;
	box-sizing: border-box;
   outline: none; border:none;
   text-decoration: none;

}
a {
	text-decoration: none;
}

li {
	list-style: none;
}
.container{
   max-width: 1200px;
   padding:2rem;
   margin:0 auto;
   background-color: #fff;
	border-radius: 10px;
  	box-shadow: 0 14px 28px rgba(0,0,0,0.25), 
			0 10px 10px rgba(0,0,0,0.22);
	position: relative;
	overflow: hidden;
}
/* NAVBAR */
#content nav {
	height: 56px;
	background:  #192a56;
	color: gold;
	padding: 0 24px;
	display: flex;
	grid-gap: 80px;
	position: sticky;
	
}
#content nav::before {
	content: '';
	position: absolute;
	width: 40px;
	height: 40px;
	bottom: -40px;
	left: 0;
	border-radius: 50%;
	box-shadow: -20px -20px 0  #192a56;
}
/* SIDEBAR */
#sidebar {
	position: fixed;
	width: 280px;
	height: 100%;
	background: #192a56;
}
#sidebar::--webkit-scrollbar {
	display: none;
}
#sidebar.hide {
	width: 60px;
}
#content .brand {
	font-size: 24px;
	font-weight:500;
	display: flex;
	border-radius: 10px;
	align-items: center;
	color: white;
	position: sticky;
}
#content .brand i{
	color: #27ae60;
}
#content .nav-msg {
	font-size: 15px;
	font-weight: normal;
	display: flex;
	align-items: center;
	color: white;
}
#sidebar .side-menu {
	width: 100%;
	margin-top: 92px;
}
#sidebar .side-menu li {
	display: flex;
    justify-content: center;
    align-items: center;
	height: 60px;
	border-radius: 30px 0 0 30px;
	padding: 6px;
}
#sidebar .side-menu li.active {
	background: #192a56;
	margin-bottom: 15px;
}
#sidebar .side-menu li a {
	text-align: center;
    width: 100%; 
	height: 100%;
	background:   #27ae60;
	border-radius: 30px;
	margin-bottom: 10px;
	margin:auto;
	padding: 10px;
	font-size: 20px;
	color: #eee;
	overflow-x: hidden;
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
#content main .box-info li {
	padding: 24px;
	background: #F9F9F9;
	border-radius: 20px;
	display: flex;
	align-items: center;
	grid-gap: 24px;
}
#content main .box-info li .bx {
	width: 80px;
	height: 80px;
	border-radius: 10px;
	font-size: 36px;
	display: flex;
	justify-content: center;
	align-items: center;
}
.text h2,p{
	font-size: large;
}
h2{
	color: #192a56;
}
</style>
</head>
<body>
  <!-- SIDEBAR -->
	<section id="sidebar">
		<ul class="side-menu top">
			<li class="active">
				<a href="./dashboard.php">
					<span class="text">Dashboard</span>
				</a>
			</li>
            <li class="active">
				<a href="./user.php">
					<span class="text">Users</span>
				</a>
			</li>
			<li class="active">
				<a href="./viewItems.php">
					<span class="text">All Dishes</span>
				</a>
			</li>
            <li class="active">
				<a href="./additem.php">
					<span class="text">Add Dishes</span>
				</a>
			</li>
			<li class="active">
				<a href="./viewPromotion.php">
					<span class="text">All Promotions</span>
				</a>
			</li>
            <li class="active">
				<a href="./addPromotion.php">
					<span class="text">Add Promotions</span>
				</a>
			</li>
			<li class="active">
				<a href="./orderManagement.php">
					<span class="text">Orders</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="./adminSessionHandler.php" class="logout">
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->

	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<a href="#" class="brand">
	
				<span class="text"><i class="fas fa-carrot"></i>Green Veggie Heaven</span>
			</a>
			<h1 class="nav-msg">Welcome back, <?php echo $adminName; ?></h1>
		</nav>
<main>
	<div class="container">
		<div class="head-title">
				<div class="left">
					<h2>Admin Dashboard</h2>
				</div>
		</div>
			
			<ul class="box-info">
				<li>
					<img src="./img/icons8-dish-50.png" alt="">
					<span class="text">
						<h2><?php $sql="select * from Items";
                            $result = mysqli_query($con,$sql);
							$rws=mysqli_num_rows($result);
							echo $rws;?>
						</h2>
						<p class="">Dishes</p>
					</span>
			
				</li>
				<li>
					<img src="./img/icons8-user-51.png" alt="">
					<span class="text">
					<h2><?php $sql="select * from Customer";
												$result=mysqli_query($con,$sql); 
													$rws=mysqli_num_rows($result);
													
													echo $rws;?></h2>
                    <p class="">Users</p>
					</span>
				</li>
				<li>
					<img src="./img/icons8-order-50.png" alt="">
					<span class="text">
					<h2><?php $sql="select * from Orders";
												$result=mysqli_query($con,$sql); 
													$rws=mysqli_num_rows($result);
													
													echo $rws;?></h2>
                                            <p class="m-b-0">Total Orders</p>
					</span>
				</li>
			</ul>
			<ul class="box-info">
				<li>
					<img src="./img/icons8-loading-32.png" alt="">
					<span class="text">
						 <h2><?php $sql="select * from orders WHERE status = 'processing'";
												$result=mysqli_query($con,$sql); 
													$rws=mysqli_num_rows($result);
													
													echo $rws;?></h2>
                                            <p class="m-b-0">Processing Orders</p>
					</span>
				</li>
				<li>
					<img src="./img/icons8-correct-30.png" alt="">
					<span class="text">
					<h2><?php $sql="select * from orders WHERE status = 'collected' ";
												$result=mysqli_query($con,$sql); 
													$rws=mysqli_num_rows($result);
													
													echo $rws; ?></h2>
                                            <p class="m-b-0">Collected Orders</p>
					</span>
				</li>
				<li>
					<img src="./img/icons8-cancel-30.png" alt="">
					<span class="text">
					<h2><?php $sql="select * from orders WHERE status = 'cancelled' ";
                                        $result=mysqli_query($con,$sql); 
                                            $rws=mysqli_num_rows($result);
                                            
                                            echo $rws; ?></h2>
                                            <p class="m-b-0">Cancelled Orders</p>
					</span>
				</li>
			</ul>

			<ul class="box-info">
				<li>
					<img src="./img/icons8-earnings-64.png" alt="">
					<span class="text">
					<h2><?php 
                                       	$result = mysqli_query($con, 'SELECT SUM(total_price) AS value_sum FROM orders WHERE status = "collected"'); 
                                        $row = mysqli_fetch_assoc($result); 
                                        $sum = $row['value_sum'];
                                        echo $sum;
                                        ?></h2>
                                            <p class="m-b-0">Total Earnings</p>
					</span>
				</li>
			<li class="active">
            <img src="./img/icons8-invoice-50.png" alt="">
				<a href="invoice.php">
					<span class="text">Invoice</span>
				</a>
			</li>
			<li class="active">
				<a href="invoice.php">
					<span class="text"></span>
				</a>
			</li>
        </ul><br>
		<div class="head-title">
				<div class="left">
					<h2>Report Generation</h2>
				</div>
		</div>
		<ul class="box-info">
			</li>
				<li class="active">
            		<img src="./img/icons8-invoice-50.png" alt="">
					<a href="./DReport.html">
						<span class="text">Dishes</span>
					</a>
				</li>
				<li class="active">
            		<img src="./img/icons8-invoice-50.png" alt="">
					<a href="./PReport.html">
						<span class="text">Promotion</span>
					</a>
				</li>
				<li class="active">
            		<img src="./img/icons8-invoice-50.png" alt="">
					<a href="./report.html">
						<span class="text">Orders</span>
					</a>
				</li>
				<li class="active">
            		<img src="./img/icons8-invoice-50.png" alt="">
					<a href="./UReport.html">
						<span class="text">Users</span>
					</a>
				</li>
		</ul>
	</div>

    
			

</main>
	</section>
</body>
</html>