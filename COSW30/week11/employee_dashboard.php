<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="employee.css">
</head>
<body>
     <div class="dashboard">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['first_name']); ?>!</h1>
    <p>Role: Employee</p>

    <h2>Manage Site</h2>
    <ul>
        <li><a href="user_manage.php">View/Add/Edit Users</a></li>
        <li><a href="product_list.php">View/Add/Edit Products</a></li>
        <li><a href="orders_list.php">View Orders</a></li>
    </ul>

    <p><a href="logout.php">Logout</a></p>
</div>
</body>
</html>
