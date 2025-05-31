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

<h2>Add User</h2>
<form method="post">
      <label for="first_name">First Name:</label><br>
    <input type="text" name="first_name" id="first_name" required><br><br>

    <label for="last_name">Last Name:</label><br>
    <input type="text" name="last_name" id="last_name" required><br><br>

    <label for="email">Email:</label><br>
    <input type="email" name="email" id="email" required><br><br>

    <label for="role">Role:</label><br>
    <select name="role" id="role" required>
        <option value="">-- Select Role --</option>
        <option value="admin">Admin</option>
        <option value="customer">Customer</option>
        <option value="employee">Employee</option>
    </select><br><br>

    <input type="submit" value="Add User">
</form>
