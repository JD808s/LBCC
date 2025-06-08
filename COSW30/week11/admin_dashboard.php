<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="dashboard">
<h1>Welcome, Admin!</h1>

<ul>
    <li><a href="user_manage.php">View/Add/Edit Users</a></li>
    <li><a href="product_list.php">Manage Products</a></li>
    <li><a href="orders_list.php">View Orders</a></li>
</ul>
</div>

<br>
 <a href="logout.php">Logout</a>
</body>
</html>