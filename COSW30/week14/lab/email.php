<!doctype html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <title>Contact Me</title>

</head>

<body>

<h1>Contact Me</h1>

<?php # Script 11.1 - email.php

// Check for form submission:

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Minimal form validation:

    if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['comments']) ) {

        // Create the body:

        $body = "<p><strong>Name:</strong> {$_POST['name']}<br><strong>Email:</strong> {$_POST['email']}</p><p><strong>Comments:</strong> {$_POST['comments']}</p><p>This is a <a href='https://www.lbcc.edu'>live</a> link.</p>";

        // Make it no longer than 70 characters long:

        $body = wordwrap($body, 70);

        $headers = "MIME-Version: 1.0" . "\r\n";

        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        $headers .= 'From: <no-reply@webdevlearning.org>' . "\r\n";

        $headers .= 'Cc: alex@devfarms.com' . "\r\n";

        // Send the email:

        // mail('alex@webdevlearning.org', 'Contact Form Submission', $body, "From: {$_POST['email']}");

        mail('class@webdevlearning.org', 'Contact Form Submission', $body, $headers);

        // Print a message:

        echo '<p><em>Thank you for contacting me. I will reply some day.</em></p>';

        // Clear $_POST (so that the form's not sticky):

        $_POST = [];

    } else {

        echo '<p style="font-weight: bold; color: #C00">Please fill out the form completely.</p>';

    }

} // End of main isset() IF.

// Create the HTML form:

?>

<p>Please fill out this form to contact me.</p>

<form action="email.php" method="post">

    <p>Name: <input type="text" name="name" size="30" maxlength="60" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>"></p>

    <p>Email Address: <input type="email" name="email" size="30" maxlength="80" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"></p>

    <p>Comments: <textarea name="comments" rows="5" cols="30"><?php if (isset($_POST['comments'])) echo $_POST['comments']; ?></textarea></p>

    <p><input type="submit" name="submit" value="Send!"></p>

</form>

</body>

</html>