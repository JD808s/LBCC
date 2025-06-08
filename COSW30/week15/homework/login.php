<?php
ob_start();
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Need two helper files:
	require('includes/login_functions.inc.php');
	//require('/../mysqli_connect.php');
    //require(__DIR__ . '/../mysqli_connect.php');
    require(__DIR__ . '/../dbconnection.php');

	// Check the login:
	list ($check, $data) = check_login($dbc, $_POST['email'], $_POST['pass']);

	if ($check) { // OK!

		// Set the session data:
		session_start();
		$_SESSION['user_id'] = $data['user_id'];
		$_SESSION['first_name'] = $data['first_name'];
        $_SESSION['role'] = $data['user_role'];

		// Store the HTTP_USER_AGENT:
		$_SESSION['agent'] = sha1($_SERVER['HTTP_USER_AGENT']);

		// Redirect:
		redirect_user('loggedin.php');

	} else { // Unsuccessful!

		// Assign $data to $errors for login_page.inc.php:
		$errors = $data;

	}

	mysqli_close($dbc); // Close the database connection.

} // End of the main submit conditional.

if (!isset($check) || !$check) {
	include('includes/login_page.inc.php');
}
ob_end_flush();
?>