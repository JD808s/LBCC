<?php
// register.php

// Initialize variables for form fields and messages
$first_name = $last_name = $email = '';
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require(__DIR__ . '/../dbconnection.php'); 
    require('includes/header.html');

    // Get form values and sanitize
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $user_role = 'user';  // Default role on registration

    // Simple validation
    if (empty($first_name)) $errors[] = "First name is required.";
    if (empty($last_name)) $errors[] = "Last name is required.";
    if (empty($email)) $errors[] = "Email is required.";
    if (empty($password)) $errors[] = "Password is required.";

    if (empty($errors)) {
        // Escape inputs to prevent SQL injection
        $first_name_esc = mysqli_real_escape_string($dbc, $first_name);
        $last_name_esc = mysqli_real_escape_string($dbc, $last_name);
        $email_esc = mysqli_real_escape_string($dbc, $email);
         $password = mysqli_real_escape_string($dbc, $password);

        // Check if email already exists
        $check_email_query = "SELECT user_id FROM users_tbl WHERE email='$email_esc' LIMIT 1";
        $result = mysqli_query($dbc, $check_email_query);

        if (mysqli_num_rows($result) > 0) {
            $errors[] = "That email is already registered.";
        } else {
            // Insert new user
            $insert_query = "INSERT INTO users_tbl (first_name, last_name, email, password, user_role)
                             VALUES ('$first_name', '$last_name', '$email', '$password', '$user_role')";

            if (mysqli_query($dbc, $insert_query)) {
                $success = true;
                // Clear form values on success
                $first_name = $last_name = $email = '';
            } else {
                $errors[] = "Database error: " . mysqli_error($dbc);
            }
        }
    }

    mysqli_close($dbc);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
</head>
<body>

<h2>Register</h2>

<?php if ($success): ?>
    <p style="color:green;">Registration successful! You can now <a href="login.php">log in</a>.</p>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <ul style="color:red;">
        <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="register.php" method="post">
    <label>First Name: <input type="text" name="first_name" value="<?= htmlspecialchars($first_name) ?>"></label><br>
    <label>Last Name: <input type="text" name="last_name" value="<?= htmlspecialchars($last_name) ?>"></label><br>
    <label>Email: <input type="email" name="email" value="<?= htmlspecialchars($email) ?>"></label><br>
    <label>Password: <input type="password" name="password"></label><br>
    <button type="submit">Register</button>
</form>

</body>
</html>
