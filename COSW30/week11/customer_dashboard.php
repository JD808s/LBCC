<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit;
}

require 'dbconnection.php';

$user_id = $_SESSION['user_id'];

// Fetch user info
$user_query = mysqli_prepare($connection, "SELECT first_name, last_name, email FROM users_tbl WHERE user_id = ?");
mysqli_stmt_bind_param($user_query, "i", $user_id);
mysqli_stmt_execute($user_query);
$user_result = mysqli_stmt_get_result($user_query);
$user = mysqli_fetch_assoc($user_result);

// Fetch user orders
$order_query = mysqli_prepare($connection,
    "SELECT o.order_id, p.product_name, p.cost 
     FROM orders o
     JOIN products p ON o.product_id = p.product_id
     WHERE o.user_id = ?");
mysqli_stmt_bind_param($order_query, "i", $user_id);
mysqli_stmt_execute($order_query);
$order_result = mysqli_stmt_get_result($order_query);

// Fetch all products
$product_result = mysqli_query($connection, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="customer.css">
</head>
<body>

 <div class="dashboard">
<h1>Welcome, <?php echo htmlspecialchars($_SESSION['first_name']); ?>!</h1>

<h2>Your Information</h2>
<ul>
    <li>Name: <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></li>
    <li>Email: <?php echo htmlspecialchars($user['email']); ?></li>
</ul>

<h2>Your Orders</h2>
<?php if (mysqli_num_rows($order_result) > 0): ?>
    <table border="1">
        <tr>
            <th>Order ID</th>
            <th>Product</th>
            <th>Cost</th>
        </tr>
        <?php while ($order = mysqli_fetch_assoc($order_result)) : ?>
            <tr>
                <td><?php echo $order['order_id']; ?></td>
                <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                <td>$<?php echo number_format($order['cost'], 2); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>You have no orders yet.</p>
<?php endif; ?>

<h2>Available Products</h2>
<table border="1">
    <tr>
        <th>Name</th>
        <th>Cost</th>
        <th>Image</th>
    </tr>
    <?php while ($product = mysqli_fetch_assoc($product_result)) : ?>
        <tr>
            <td><?php echo htmlspecialchars($product['product_name']); ?></td>
            <td>$<?php echo number_format($product['cost'], 2); ?></td>
            <td>
                <?php if (!empty($product['image'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" width="100" />
                <?php else: ?>
                    No image
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
                </div>
<br>
<p><a href="logout.php">Logout</a></p>
</body>
</html>
