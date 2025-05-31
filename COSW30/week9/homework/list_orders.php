<?php
require('../dbconnection.php'); // Adjust path if needed
include('nav.php');

$sql = "SELECT * FROM orders"; 
$result = $connection->query($sql);

echo "<h2>Order List</h2>";
if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Color</th><th>Created</th><th>Updated</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['order_id']}</td>
                <td>{$row['product_id']}</td>
                <td>{$row['user_id']}</td>
                <td>{$row['order_status']}</td>
                <td>{$row['created_date']}</td>
                <td>{$row['last_updated']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No orders found.";
}
?>
