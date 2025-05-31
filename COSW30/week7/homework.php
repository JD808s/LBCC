<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="form-container">
    <h2>Registration Form</h2>
    <form action="process.php" method="POST">
        
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label>Gender:</label>
        <div class="radio-group">
            <label><input type="radio" name="gender" value="male" required> Male</label>
            <label><input type="radio" name="gender" value="female" required> Female</label>
            <label><input type="radio" name="gender" value="other" required> Other</label>
        </div>

        <label>Interests:</label>
        <div class="checkbox-group">
            <label><input type="checkbox" name="interests[]" value="sports"> Sports</label>
            <label><input type="checkbox" name="interests[]" value="music"> Music</label>
            <label><input type="checkbox" name="interests[]" value="reading"> Reading</label>
        </div>

        <label for="country">Country:</label>
        <select id="country" name="country" required>
            <option value="">Select your country</option>
            <option value="us">United States</option>
            <option value="uk">United Kingdom</option>
            <option value="ca">Canada</option>
        </select>

        <label for="bio">Short Bio:</label>
        <textarea id="bio" name="bio" rows="4"></textarea>

        <input type="submit" value="Register">
    </form>
</div>

</body>
</html>
