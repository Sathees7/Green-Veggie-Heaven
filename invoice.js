let itemCounter =0;

function addInvoiceItem()
{
    itemCounter++;

    const newItemRow =`
    <tr id="itemRow${itemCounter}">
        <td><input type="text" class="form-control" placeholder="Enter Food item" required></td>
        <td><input type="number" class="form-control quantity" placeholder="Enter Quantity" required></td>
        <td><input type="number" class="form-control unitPrice" placeholder="Enter Unit Price" required></td>
        <td><input type="text" class="form-control totalItemPrice" disabled readonly></td>
        <td><button type="button" class="btn btn-danger" onclick="removeInvoiceItem(${itemCounter})">Remove</button></td>
    </tr>
`;

$("#InvoiceItem").append(newItemRow);

//update totalamount on every item added
updateTotalAmount();
}

function removeInvoiceItem(itemId){
    $(`#itemRow${itemId}`).remove();
    updateTotalAmount();
}

function updateTotalAmount()
{
    let totalAmount=0;

    $("tr[id^='itemRow']").each(function(){
        const quantity=parseFloat($(this).find(".quantity").val
        ())||0;
        const unitPrice=parseFloat($(this).find(".unitPrice").val
        ())||0;
    
        const totalItemPrice = quantity * unitPrice;
    
        $(this).find(".totalItemPrice").val(totalItemPrice.toFixed
 (2));
            totalAmount+= totalItemPrice;
    });
    
    $("#totalAmount").val(totalAmount.toFixed(2));
    }
    
    // automatic set current date for invoice date
    $(document).ready(function() {
    const currentDate = new Date();
    const formattedDate = currentDate.toISOString().slice(0,10);
    $("#invoiceDate").val(formattedDate);
    });
    
    $("#invoiceForm").submit(function(event){
    event.preventDefault();
    updateTotalAmount();
    });


       //review  
     let profile = document.querySelector('.header .flex .profile');

document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
}

window.onscroll = () =>{
   profile.classList.remove('active');
}

document.querySelectorAll('input[type="number"]').forEach(inputNumber => {
   inputNumber.oninput = () =>{
      if(inputNumber.value.length > inputNumber.maxLength) inputNumber.value = inputNumber.value.slice(0, inputNumber.maxLength);
   };
});

   //print bill invoive    
    
    function printInvoice()
{
    const customerName= $("#customerName").val();
    const invoiceDate = $("#invoiceDate").val();
    const item=[];
    
    $("tr[id^='itemRow']").each(function (){
        const description =$(this).find("td:eq(0) input").val();
        const quantity=$(this).find("td:eq(1) input").val();
        const unitPrice=$(this).find("td:eq(2) input").val();
        const totalItemPrice=$(this).find("td:eq(3) input").val();
    


        item.push({
            description: description,
            quantity: quantity,
            unitPrice: unitPrice,
            totalItemPrice: totalItemPrice,
        });

      
    });
    
    const totalAmount = $("#totalAmount").val();
    const invoiceContent=`
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
        background: #1D5603;
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
        background: #236904;
        margin-bottom: 15px;
    }
    #sidebar .side-menu li a {
        text-align: center;
        width: 100%; 
        height: 100%;
        background:  #236904;
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


    h2{
        color: blue;
    }
    table{
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;

    }
    th,td{
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
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
        
                    <span class="text">Green Veggie Heaven</span>
                </a>
                <h1 class="nav-msg">Welcome back, <?php echo $adminName; ?></h1>
            </nav>
    <main>
        <div class="container">
            <h2>Invoice Slip</h2>
            <p><strong>Customer Name:</strong>${customerName} </p>
            <p> <strong>Date and Time:</strong>${invoiceDate}</p>
            <table>
                <thead>
                    <tr>
                        <th>description</th>
                        <th>quantity</th>
                        <th>unitPrice</th>
                        <th>totalItemPrice</th>
                    </tr>
                </thead>
                <tbody>
                    ${item.map((item)=>`
                    <tr>
                        <td>${item.descridescriptionption}</td>
                        <td>${item.quantity}</td>
                        <td>${item.unitPrice}</td>
                        <td>${item.totalItemPrice}</td>
                    </tr> `
                    ).join("")}
                </tbody>
            </table>

            <p class="total">Total Amount: ${totalAmount}</p>
                
    </div>
    </main>
        </section>
    </body>
    </html>
                    
    `;
 const printWindow = window.open(" ","_blank");
 printWindow.document.write(invoiceContent);
 printWindow.document.close();
 printWindow.printInvoice();

}




