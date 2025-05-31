<?php
require('../dbconnection.php');
include('nav.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['product_name'];
    $color = $_POST['color'];

    $sql = "INSERT INTO products_tbl (product_name, color) VALUES (?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $name, $color);

    if ($stmt->execute()) {
        echo "Product added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<h2>Add Product</h2>
<form method="post">
    Product Name: <input type="text" name="product_name" required><br>
    Color: <input type="text" name="color" required><br>
    <input type="submit" value="Add Product">
</form>
