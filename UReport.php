<?php
include('db.php');


/*if ($date && !$dish ) {
$sql = "SELECT * FROM items WHERE DATE(created_at) = '$date'";
$result = $conn->query($sql);
}*/

    $sql = "SELECT * FROM Customer";
    $result = $conn->query($sql);

   /* if ($date && $dish ) {
        $sql = "SELECT * FROM orders WHERE DATE(created_at) = '$date' and status = '$dish'";
        $result = $conn->query($sql);
        }*/

// Start the table
$output = "<div class='product-display'>
<table class='product-display-table'>
            <thead>
            <tr>
                <th>User ID</th>
                <th>User Name</th>
                <th>Contact No</th>
                <th>Email</th>
            </tr>
            </thead>";

// Initialize the grand total
$grandTotal = 0;

// Loop through the results and add rows to the table
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>
                    <td>" . $row["customerID"] . "</td>
                    <td>" . $row["name"] . "</td>
                    <td>" . $row["contactNo"] . "</td>
                    <td>" . $row["email"] . "</td>
                </tr>";
    }
} else {
    $output .= "<tr><td colspan='2'>No orders found for the selected date</td></tr>";
}

// Close the database connection
$conn->close();

// Output the table
echo $output;