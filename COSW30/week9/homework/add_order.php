<?php
require('../dbconnection.php');
include('nav.php');

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = !empty($_POST['product_id']) ? $_POST['product_id'] : null;
    $user_id = !empty($_POST['user_id']) ? $_POST['user_id'] : null;

    $sql = "INSERT INTO orders_tbl (product_id, user_id) VALUES (?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ii", $product_id, $user_id);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Order added successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
    }
}
?>

<h2>Add Order</h2>
<form method="post">
    <label for="product_id">Product ID:</label>
    <input type="number" name="product_id" id="product_id"><br><br>

    <label for="user_id">User ID:</label>
    <input type="number" name="user_id" id="user_id"><br><br>

    <input type="submit" value="Add Order">
</form>
