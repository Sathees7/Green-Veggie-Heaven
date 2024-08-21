<?php
include('db.php');
$date = $_GET['date'];
$status= $_GET['status'];


if ($date && !$status ) {
$sql = "SELECT * FROM orders WHERE DATE(created_at) = '$date'";
$result = $conn->query($sql);
}
if ($status && !$date ) {
    $sql = "SELECT * FROM orders WHERE status = '$status'";
    $result = $conn->query($sql);
    }
    if ($date && $status ) {
        $sql = "SELECT * FROM orders WHERE DATE(created_at) = '$date' and status = '$status'";
        $result = $conn->query($sql);
        }

// Start the table
$output = "<div class='product-display'>
<table class='product-display-table'>
            <thead>
            <tr>
                <th>Order ID</th>
                <th>Dishe ID</th>
                <th>Quentity</th>
                <th>Total Amount</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
            </thead>";

// Initialize the grand total
$grandTotal = 0;

// Loop through the results and add rows to the table
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output .= "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["product_id"] . "</td>
                    <td>" . $row["quantity"] . "</td>
                    <td>" . $row["total_price"] . "</td>
                    <td>" . $row["created_at"] . "</td>
                    <td>" . $row["status"] . "</td>
                </tr>";
                if($row["status"] == "Collected"){
                    $grandTotal += $row["total_price"];
                }
    }
} else {
    $output .= "<tr><td colspan='2'>No orders found for the selected date</td></tr>";
}

// Add the grand total row
$output .= "<tr>
                <td><strong>Total Revenue</strong></td>
                <td><strong>$grandTotal</strong></td>
            </tr>
        </table>
        </div>";

// Close the database connection
$conn->close();

// Output the table
echo $output;