<?php
session_start();
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'employee'])) {
    header("Location: login.php");
    exit;
}
$dashboard = '';
if ($_SESSION['role'] === 'admin') {
    $dashboard = 'admin_dashboard.php';
} elseif ($_SESSION['role'] === 'employee') {
    $dashboard = 'employee_dashboard.php';
}

require 'dbconnection.php';

$query = "
    SELECT 
        o.order_id,
        u.first_name,
        u.last_name,
        u.email,
        p.product_name,
        p.cost
    FROM orders o
    JOIN users_tbl u ON o.user_id = u.user_id
    JOIN products p ON o.product_id = p.product_id
    ORDER BY o.order_id DESC
";

$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order List</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Orders</h1>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>Order ID</th>
        <th>Customer Name</th>
        <th>Email</th>
        <th>Product</th>
        <th>Cost</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?php echo $row['order_id']; ?></td>
            <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
            <td>$<?php echo number_format($row['cost'], 2); ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<br>
<a href="<?php echo $dashboard; ?>">← Back to Dashboard</a>
</body>
</html>
