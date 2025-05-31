<?php
require('../dbconnection.php'); // Adjust path if needed
include('nav.php');

$sql = "SELECT * FROM users_tbl"; 
$result = $connection->query($sql);

echo "<h2>Product List</h2>";
if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Color</th><th>Created</th><th>Updated</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['user_id']}</td>
                <td>{$row['first_name']}</td>
                <td>{$row['last_name']}</td>
                <td>{$row['user_role']}</td>
                <td>{$row['email']}</td>
                <td>{$row['created_date']}</td>
                <td>{$row['updated_date']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No products found.";
}
?>
