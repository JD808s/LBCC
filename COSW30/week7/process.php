<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    // Validate Name
    if (empty($_POST['name'])) {
        $errors[] = "Name is required.";
    }
    
    // Validate Email
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }
    
    // Validate Password
    if (empty($_POST['password'])) {
        $errors[] = "Password is required.";
    }
    
    // Validate Gender
    if (!isset($_POST['gender'])) {
        $errors[] = "Gender selection is required.";
    }
    
    // Validate Country
    if (empty($_POST['country'])) {
        $errors[] = "Country selection is required.";
    }

    // If no errors, process the form
    if (empty($errors)) {
        echo "<h2>Form Submitted Successfully</h2>";
        echo "<p>Name: " . htmlspecialchars($_POST['name']) . "</p>";
        echo "<p>Email: " . htmlspecialchars($_POST['email']) . "</p>";
        echo "<p>Gender: " . htmlspecialchars($_POST['gender']) . "</p>";
        echo "<p>Country: " . htmlspecialchars($_POST['country']) . "</p>";
        
        if (!empty($_POST['interests'])) {
            echo "<p>Interests: " . implode(", ", $_POST['interests']) . "</p>";
        }
        
        if (!empty($_POST['comments'])) {
            echo "<p>Comments: " . nl2br(htmlspecialchars($_POST['comments'])) . "</p>";
        }
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Errors</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="form-container">
        <h2>Form Errors</h2>
        <ul>
            <?php
            foreach ($errors as $error) {
                echo "<li>$error</li>";
            }
            ?>
        </ul>
        <a href="homework.php">Go Back</a>
    </div>
</body>
</html>