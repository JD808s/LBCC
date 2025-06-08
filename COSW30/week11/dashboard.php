<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$role = $_SESSION['role'];

if ($role == 'admin') {
    header("Location: admin_dashboard.php");
} elseif ($role == 'employee') {
    header("Location: employee_dashboard.php");
} else {
    header("Location: customer_dashboard.php");
} 
exit;
