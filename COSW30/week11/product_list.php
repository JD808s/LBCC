<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
session_start();
$user_role = $_SESSION['role'] ?? null;
$dashboard_link = isset($_SESSION['user_id']) ? 'dashboard.php' : 'login.php';
//if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'employee'])) {
   // header("Location: login.php");
    //exit;
//}
$dashboard = '';
if ($_SESSION['role'] === 'admin') {
    $dashboard = 'admin_dashboard.php';
} elseif ($_SESSION['role'] === 'employee') {
    $dashboard = 'employee_dashboard.php';
}

require 'dbconnection.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = mysqli_prepare($connection, "DELETE FROM products WHERE product_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    header("Location: product_list.php");
    exit;
}

// Initialize variables for editing
$edit_mode = false;
$edit_product = null;

// Check if editing is requested
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $edit_id = intval($_GET['edit']);
    $stmt = mysqli_prepare($connection, "SELECT * FROM products WHERE product_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $edit_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $edit_product = mysqli_fetch_assoc($result);
    if (!$edit_product) {
        // Invalid ID, redirect back
        header("Location: product_list.php");
        exit;
    }
}

// Handle Add or Update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Common inputs
    $name = mysqli_real_escape_string($connection, $_POST['product_name']);
    $cost = floatval($_POST['cost']);
    $image = '';

    // Handle image upload (optional)
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $targetDir = "uploads/";
        $imageName = basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . time() . "_" . $imageName;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image = basename($targetFile);
        }
    }

    if (isset($_POST['edit_product_id'])) {
        // Update existing product
        $id = intval($_POST['edit_product_id']);

        if ($image) {
            // Update including new image
            $stmt = mysqli_prepare($connection, "UPDATE products SET product_name = ?, cost = ?, image = ? WHERE product_id = ?");
            mysqli_stmt_bind_param($stmt, "sdsi", $name, $cost, $image, $id);
        } else {
            // Update without changing image
            $stmt = mysqli_prepare($connection, "UPDATE products SET product_name = ?, cost = ? WHERE product_id = ?");
            mysqli_stmt_bind_param($stmt, "sdi", $name, $cost, $id);
        }
        mysqli_stmt_execute($stmt);

        header("Location: product_list.php");
        exit;

    } else if (isset($_POST['add_product'])) {
        // Insert new product
        $stmt = mysqli_prepare($connection, "INSERT INTO products (product_name, cost, image) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sds", $name, $cost, $image);
        mysqli_stmt_execute($stmt);

        header("Location: product_list.php");
        exit;
    }
}

// Fetch all products for listing
$query = "SELECT * FROM products";
$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Product List</h1>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Cost</th>
        <th>Image</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?php echo $row['product_id']; ?></td>
            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
            <td>$<?php echo number_format($row['cost'], 2); ?></td>
            <td>
                <?php if (!empty($row['image'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" width="100" />
                <?php else: ?>
                    No image
                <?php endif; ?>
            </td>
            <!--<td>
                <a href="product_list.php?edit=<?php echo $row['product_id']; ?>">Edit</a> |
                <a href="product_list.php?delete=<?php echo $row['product_id']; ?>" onclick="return confirm('Delete this product?');">Delete</a>
            </td>-->
            <td>
<?php if (in_array($user_role, ['admin', 'employee'])): ?>
    <a href="product_list.php?edit=<?php echo $row['product_id']; ?>">Edit</a> |
    <a href="product_list.php?delete=<?php echo $row['product_id']; ?>" onclick="return confirm('Delete this product?');">Delete</a>
<?php else: ?>
    <em>View only</em>
<?php endif; ?>
</td>

        </tr>
    <?php endwhile; ?>
</table>

<?php if (in_array($user_role, ['admin', 'employee'])): ?>
<h2><?php echo $edit_mode ? "Edit Product" : "Add New Product"; ?></h2>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="product_name" placeholder="Product Name" required value="<?php echo $edit_mode ? htmlspecialchars($edit_product['product_name']) : ''; ?>"><br><br>
    <input type="number" step="0.01" name="cost" placeholder="Cost" required value="<?php echo $edit_mode ? htmlspecialchars($edit_product['cost']) : ''; ?>"><br><br>
    <input type="file" name="image"><br><br>
    <?php if ($edit_mode): ?>
        <input type="hidden" name="edit_product_id" value="<?php echo $edit_product['product_id']; ?>">
    <?php else: ?>
        <input type="hidden" name="add_product" value="1">
    <?php endif; ?>
    <button type="submit"><?php echo $edit_mode ? "Update Product" : "Add Product"; ?></button>
    <?php if ($edit_mode): ?>
        <a href="product_list.php">Cancel</a>
    <?php endif; ?>
</form>
<?php endif; ?>

<br>
<!--<a href="<?php echo $dashboard; ?>">← Back to Dashboard</a>-->
<a href="<?php echo $dashboard_link; ?>">← Back to Dashboard</a>

</body>
</html>
