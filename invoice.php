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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="invoice.css">
    <title>Billing System</title>
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
th,
td{
    text-align: center;
}
#totalAmount{
    font-weight: bold;
    font-size: 18px;
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
				<a href="dashboard.php">
					<span class="text">Dashboard</span>
				</a>
			</li>
            <li class="active">
				<a href="users.php">
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
				<a href="./viewPromotions.php">
					<span class="text">All Promotions</span>
				</a>
			</li>
            <li class="active">
				<a href="./viewPromotions.php">
					<span class="text">Add Promotions</span>
				</a>
			</li>
			<li class="active">
				<a href="addPromotion.php">
					<span class="text">Orders</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="#" class="logout">
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
    <div class="container">
        <h2 class="mb-5 text-center" >Billing Invoice</h2>
        <form id="invoiceForm">
            <div class="row mt-5 mb-5">
    
                <div class="form-group col-md-3">
                    <label for="invoiceNo">Invoice No</label>
                    <input
                      type="text"
                      class="form-control"
                      id="invoiceNo"
                      placeholder="Enter Invoice No"
                        required
                      />
                  </div>
    
    
              <div class="form-group col-md-3">
              <label for="CustomerName">Customer Name</label>
              <input
                type="text"
                class="form-control"
                id="customerName"
                placeholder="Enter Customer Name"
                required
                />
            </div>
    
    
            
    
            <div class="form-group col-md-3">
                <label for="invoiceDate">Invoice Date</label>
                <input
                  type="text"
                  class="form-control"
                  id="invoiceDate"
                  disabled
                  readonly
                  />
              </div>
            </div>
            <table class="table table-borderd">
                <thead>
                    <tr>
                        <th scope="col">Description</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">unit price</th>
                        <th scope="col">Total</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="InvoiceItem">
                     <!--Item will be here dynamically-->
                </tbody>
               
            </table>
            <button type="button" class="btn btn-success"
             onclick="addInvoiceItem()">
                Add Item</button>
        
                <div class="col-md-6">
                    <div class="form-group col-md-6 mt-2">
                    <label for="totalAmount">Total Amount</label>
                    <input
                    type="text"
                    class="form-control"
                    id="totalAmount"
                    disabled
                    readonly
                    />
                    </div>
                </div>
              <button type="submit" class="btn btn-success mt-4">
                Gentrate Invoice</button>
        </form>
        <button class="btn btn-success btn-print mt-4" onclick="printInvoice()">
        Print Invoice</button>
      
    </div>
    
</main>
	</section>
     <!--script-->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js" 
     integrity="sha512-TPh2Oxlg1zp+kz3nFA0C5vVC6leG/6mm1z9+mA81MI5eaUVqasPLO8Cuk4gMF4gUfP5etR73rgU/8PNMsSesoQ==" 
     crossorigin="anonymous" referrerpolicy="no-referrer"></script>
     
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.slim.min.js" 
     integrity="sha512-sNylduh9fqpYUK5OYXWcBleGzbZInWj8yCJAU57r1dpSK9tP2ghf/SRYCMj+KsslFkCOt3TvJrX2AV/Gc3wOqA==" 
     crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
      crossorigin="anonymous"></script>
 
     <script src="invoice.js"></script>
</body>
</html>