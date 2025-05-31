<?php
require_once '../dbconnection.php'; // adjust path if needed

$sql = "SELECT * FROM orders";
$result = $connection->query($sql);

echo "<h1>Orders List</h1>";

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Order ID</th><th>Product ID</th><th>User ID</th><th>Status</th><th>Created Date</th><th>Last Updated</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['product_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['order_status']) . "</td>";
        echo "<td>" . htmlspecialchars($row['created_date']) . "</td>";
        echo "<td>" . htmlspecialchars($row['last_updated']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No orders found.";
}
?>
