<?php
session_start();
require 'dbconnection.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = mysqli_prepare($connection, "SELECT * FROM users_tbl WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['user_role'];
            $_SESSION['first_name'] = $user['first_name'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Login</title>
<link rel="stylesheet" href="styles.css" />
<style>
  body {
    background: #fff8e1; 
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    font-family: Arial, sans-serif;
  }
  .login-container {
    background: #fff;
    border: 6px solid #f44336; 
    border-radius: 12px;
    padding: 30px 40px;
    box-shadow: 0 6px 10px rgba(0,0,0,0.15);
    width: 320px;
    text-align: center;
  }
  h2 {
    color: #1565c0; 
    margin-bottom: 20px;
    font-weight: 700;
    letter-spacing: 2px;
  }
  input[type="email"],
  input[type="password"] {
    width: 100%;
    padding: 12px 2px;
    margin: 10px 0 20px 0;
    border: 3px solid #fbc02d; 
    border-radius: 6px;
    font-size: 16px;
    transition: border-color 0.3s ease;
  }
  input[type="email"]:focus,
  input[type="password"]:focus {
    border-color: #1976d2; 
    outline: none;
  }
  button {
    background: #f44336;
    border: none;
    color: white;
    padding: 14px 0;
    width: 100%;
    font-size: 18px;
    font-weight: bold;
    border-radius: 8px;
    cursor: pointer;
    letter-spacing: 1px;
    transition: background 0.3s ease;
  }
  button:hover {
    background: #d32f2f;
  }
  p.error {
    color: #d32f2f;
    font-weight: bold;
    margin-top: 15px;
  }
</style>
</head>
<body>
  <div class="login-container">
    <h2>Welcome Back!</h2>
    <form method="POST" novalidate>
      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit">Login</button>
      <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    </form>
  </div>
</body>
</html>
