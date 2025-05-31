<?php
require_once '../dbconnection.php'; // adjust path if needed

$sql = "SELECT * FROM products";
$result = $connection->query($sql);

echo "<h1>Products List</h1>";

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Color</th><th>Created Date</th><th>Last Updated</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['product_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['color']) . "</td>";
        echo "<td>" . htmlspecialchars($row['created_date']) . "</td>";
        echo "<td>" . htmlspecialchars($row['last_updated']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No products found.";
}
?>
