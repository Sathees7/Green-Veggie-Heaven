<?php
include('db.php');
$dish= $_GET['dish'];


/*if ($date && !$dish ) {
$sql = "SELECT * FROM items WHERE DATE(created_at) = '$date'";
$result = $conn->query($sql);
}*/
if ($dish) {
    $sql = "SELECT * FROM items WHERE itemName = '$dish'";
    $result = $conn->query($sql);
    }else{
        $sql = "SELECT * FROM items";
        $result = $conn->query($sql); 
    }
   /* if ($date && $dish ) {
        $sql = "SELECT * FROM orders WHERE DATE(created_at) = '$date' and status = '$dish'";
        $result = $conn->query($sql);
        }*/
  
// Start the table
$output = " <div class='product-display'>
<table class='product-display-table'>
            <thead>
            <tr>
                <th>Dishe ID</th>
                <th>Dishe Name</th>
                <th>Category</th>
                <th>Quantity</th> 
                <th>Price</th>
            </tr>
            </thead>
            ";

// Loop through the results and add rows to the table
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>
                    <td>" . $row["itemID"] . "</td>
                    <td>" . $row["itemName"] . "</td>
                    <td>" . $row["catogory"] . "</td>
                    <td>" . $row["quantity"] . "</td>
                    <td>" . $row["price"] . "</td>
                </tr>
                ";
    }
} else {
    $output .= "<tr><td colspan='2'>No orders found for the selected date</td></tr>";
}

// Close the database connection
$conn->close();

// Output the table
echo $output;