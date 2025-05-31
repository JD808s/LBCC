<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Connect to Database</title>

<style>
    body {
    font-family: Arial, sans-serif;
    padding: 20px;
    background: #f4f4f4;
}

h1 {
    text-align: center;
    color: #2e7d32; 
}

form {
    background: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    width: 400px;
    max-width: 90%;
    margin: auto;
}

input[type="text"],
input[type="email"],
input[type="password"],
input[type="submit"] {
    display: block;
    width: 100%;
    margin-bottom: 15px;
    padding: 10px;
    border: 1px solid #a5d6a7; 
    border-radius: 5px;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #2e7d32; 
    color: white;
    border: none;
    cursor: pointer;
    font-weight: bold;
}

input[type="submit"]:hover {
    background-color: #388e3c;
}

.form-error {
    color: #c62828; 
    font-weight: bold;
}

.form-success {
    color: #2e7d32; 
    font-weight: bold;
}
  </style>

</head>

<body>
<main>
<section>
<article>
<h1>Add User</h1>


<form action="add_user.php" method="post">
<input type="text" name="first-name" id="first-name" placeholder="First Name" value="<?php if (isset($_POST['first-name'])) { print htmlspecialchars($_POST['first-name']); } ?>">
<input type="text" name="last-name" id="last-name" placeholder="Last Name" value="<?php if (isset($_POST['last-name'])) { print htmlspecialchars($_POST['last-name']); } ?>">
<input type="email" name="email" id="email" placeholder="Email" value="<?php if (isset($_POST['email'])) { print htmlspecialchars($_POST['email']); } ?>"><br />
<input type="password" name="password" id="password" placeholder="password">
<input type="password" name="confirm-password" id="confirm-password" placeholder="password">
<input type="submit">

<?php

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $problem = false; // No problems so far. 

  // Check for each value...
  if (empty($_POST['first-name'])) {
    $problem = true;
    print '<p><span class="form-error">Please enter your first name.</span></p>';
   }

  if (empty($_POST['last-name'])) {
    $problem = true;
    print '<p><span class="form-error">Please enter your last name.</span></p>';
   }

  if (empty($_POST['email'])) {
    $problem = true;
    print '<p><span class="form-error">Please enter your email address.</span></p>';
  }

  if (empty($_POST['password'])) {
    $problem = true;
    print '<p><span class="form-error">Please enter a password!</span></p>';
  }

  if ($_POST['password'] != $_POST['confirm-password']) {
    $problem = true;
    print '<p><span class="form-error">Your password did not match your confirmed password!</span></p>';
   } 

  if (!$problem) { // If there weren't any problems...

    // Add user to database

    $firstname = $_POST['first-name'];
    $lastname = $_POST['last-name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    require('dbconnection.php');

    $sql = "INSERT INTO users_tbl (first_name, last_name, email, password)
    VALUES ('" . $firstname . "','" . $lastname . "','" . $email . "','" . $password . "')";

    if (mysqli_query($connection, $sql)) {
     echo '<p><span class="form-success">' . $firstname . ' ' . $lastname . ' added as a new user.</span></p>';
    } else {
     echo "Error: " . $sql . "<br>" . mysqli_error($connection);
     }

    mysqli_close($connection);   

    // Clear the posted values:
    $_POST = [];

  } else { // Forgot a field.
      print '<p><span class="form-error">Please try again!</span></p>';   
  }

} // End of handle form IF.

?>

</form>
</article>
</section>
</main>
</body>
<html>
