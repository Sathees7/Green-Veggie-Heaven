<?php

if (isset($_POST['submit'])) {
    $con = mysqli_connect("localhost", "root", "", "GreenVeggieHeaven");
    if (!$con) {
        die("Error: Could not connect to the database");
    }

    $result = mysqli_query($con, "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'GreenVeggieHeaven' AND table_name = 'Promotion'");
    if (!$result) {
        die("Error: Failed to fetch position");
    }
    $position = mysqli_fetch_assoc($result);

    $img = $_POST['imageFile'];
    $imageDetails = pathinfo($_FILES['imageFile']['name']);
    $newImageName = "image-" . $position['AUTO_INCREMENT'] . "." . $imageDetails['extension'];
    move_uploaded_file($_FILES['imageFile']['tmp_name'], $newImageName);


    if(empty($_POST['itemName']) || empty($_POST['price'] ) || empty($newImageName)){
        $message[] = 'please fill out all';
     }else{  $sql1 = "INSERT INTO Promotion (promotionName, description, image, price) VALUES ('" . $_POST['itemName'] . "','" . $_POST['iDescription'] . "','" . $newImageName . "'," . $_POST['price'] . ")";
        $queryResult = mysqli_query($con, $sql1);
        if($queryResult){
           $message[] = 'New Promotion Added Successfully';
        }else{
           $message[] = 'Could not Add the Promotion';
        }
     }

    mysqli_close($con);
};


?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="">

</head>
<body>
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
	background:  #192a56;;
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
	box-shadow: -20px -20px 0  #192a56;;
}
/* SIDEBAR */
#sidebar {
	position: fixed;
	width: 280px;
	height: 100%;
	background: #192a56;;
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
   color:#27ae60 ;
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
	background:  #27ae60;
	border-radius: 30px;
	margin-bottom: 10px;
	margin:auto;
	padding: 10px;
	font-size: 20px;
	color: white;
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



html{
   font-size: 62.5%;
   overflow-x: hidden;
}

.btn{
   display: block;
   width: 100%;
   cursor: pointer;
   border-radius: .5rem;
   margin-top: 1rem;
   font-size: 1.7rem;
   padding:1rem 3rem;
   background: #27ae60;
   color:var(--white);
   text-align: center;
}

.btn:hover{
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

.container{
   max-width: 1200px;
   padding:2rem;
   margin:0 auto;
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
   color:#192a56;
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
   border-bottom: var(--border);
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
		</nav>
<main>
<?php

if(isset($message)){
   foreach($message as $message){
      echo '<span class="message">'.$message.'</span>';
   }
}

?>
   
<div class="container">

   <div class="admin-product-form-container">

      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
         <h3>Add Promotion</h3>
         <input type="text" name="itemName" placeholder="Promotion Name" class="box" required>
         <textarea name="iDescription" placeholder="Describe About the Promotion" class="box"></textarea>
         <input type="file" name="imageFile" placeholder="Upload a Image" class="box" required>
         <input type="text" name="price" placeholder="Item price" class="box" required>
         <p>
            <input type="submit" value="Add" name="submit" class="btn" />
         </p>
      </form>
   </div>
</div>
</main>
	</section>
</body>
</html>