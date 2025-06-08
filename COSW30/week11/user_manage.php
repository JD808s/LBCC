<?php
session_start();
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'employee'])) {
    header("Location: login.php");
    exit;
}

require 'dbconnection.php';

// Handle add or edit user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first = mysqli_real_escape_string($connection, $_POST['first_name']);
    $last = mysqli_real_escape_string($connection, $_POST['last_name']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $status = $_POST['status'];
    $role = $_POST['role'];
    $image = '';
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $targetDir = "uploads/";
        $imageName = basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . time() . "_" . $imageName;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image = basename($targetFile);
        }
    }

    if (isset($_POST['edit_user_id'])) {
        // Edit existing user
        $id = intval($_POST['edit_user_id']);

        if ($image) {
            $stmt = mysqli_prepare($connection, "UPDATE users_tbl SET first_name = ?, last_name = ?, email = ?, password = ?, status = ?, user_role = ?, image = ? WHERE user_id = ?");
            mysqli_stmt_bind_param($stmt, "sssssssi", $first, $last, $email, $password, $status, $role, $image, $id);
        } else {
            $stmt = mysqli_prepare($connection, "UPDATE users_tbl SET first_name = ?, last_name = ?, email = ?, password = ?, status = ?, user_role = ? WHERE user_id = ?");
            mysqli_stmt_bind_param($stmt, "ssssssi", $first, $last, $email, $password, $status, $role, $id);
        }

        mysqli_stmt_execute($stmt);
    } else {
        // Add new user
        $stmt = mysqli_prepare($connection, "INSERT INTO users_tbl (first_name, last_name, email, password, status, user_role, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssssss", $first, $last, $email, $password, $status, $role, $image);
        mysqli_stmt_execute($stmt);
    }

    header("Location: user_manage.php");
    exit;
}

// Load users
$result = mysqli_query($connection, "SELECT * FROM users_tbl");

// Handle edit mode
$edit_mode = false;
$edit_user = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $stmt = mysqli_prepare($connection, "SELECT * FROM users_tbl WHERE user_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $edit_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $edit_user = mysqli_fetch_assoc($res);
    if ($edit_user) {
        $edit_mode = true;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Manage Users</h1>
 

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Status</th>
        <th>Role</th>
        <th>Image</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
            <td><?php echo htmlspecialchars($row['user_role']); ?></td>
            <td>
                <?php if (!empty($row['image'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" width="60" />
                <?php else: ?>
                    No image
                <?php endif; ?>
            </td>
            <td>
                <a href="user_manage.php?edit=<?php echo $row['user_id']; ?>">Edit</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<h2><?php echo $edit_mode ? "Edit User" : "Add New User"; ?></h2>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="first_name" placeholder="First Name" required value="<?php echo $edit_mode ? htmlspecialchars($edit_user['first_name']) : ''; ?>"><br><br>
    <input type="text" name="last_name" placeholder="Last Name" required value="<?php echo $edit_mode ? htmlspecialchars($edit_user['last_name']) : ''; ?>"><br><br>
    <input type="email" name="email" placeholder="Email" required value="<?php echo $edit_mode ? htmlspecialchars($edit_user['email']) : ''; ?>"><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <select name="status" required>
        <option value="">-- Status --</option>
        <option value="active" <?php echo ($edit_mode && $edit_user['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
        <option value="inactive" <?php echo ($edit_mode && $edit_user['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
    </select><br><br>
    <select name="role" required>
        <option value="">-- Role --</option>
        <option value="admin" <?php echo ($edit_mode && $edit_user['user_role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
        <option value="employee" <?php echo ($edit_mode && $edit_user['user_role'] == 'employee') ? 'selected' : ''; ?>>Employee</option>
        <option value="customer" <?php echo ($edit_mode && $edit_user['user_role'] == 'customer') ? 'selected' : ''; ?>>Customer</option>
    </select><br><br>
    <input type="file" name="image"><br><br>

    <?php if ($edit_mode): ?>
        <input type="hidden" name="edit_user_id" value="<?php echo $edit_user['user_id']; ?>">
    <?php endif; ?>

    <button type="submit"><?php echo $edit_mode ? "Update User" : "Add User"; ?></button>
    <?php if ($edit_mode): ?>
        <a href="user_manage.php">Cancel</a>
    <?php endif; ?>
</form>

<br>
<a href="<?php echo ($_SESSION['role'] === 'admin') ? 'admin_dashboard.php' : 'employee_dashboard.php'; ?>">← Back to Dashboard</a>
</body>
</html>
