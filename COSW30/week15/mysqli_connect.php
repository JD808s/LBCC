<?php # Script 9.2 - mysqli_connect.php

// This file contains the database access information.
// This file also establishes a connection to MySQL,
// selects the database, and sets the encoding.

// Set the database access information as constants:
define('DB_USER', 'u5cvzomu5pwpb');
define('DB_PASSWORD', 'cosw30!2025');
define('DB_HOST', '127.0.0.0');
define('DB_NAME', 'dbu8zpdkawjv9e');

// Make the connection:
$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die('Could not connect to MySQL: ' . mysqli_connect_error() );

// Set the encoding...
mysqli_set_charset($dbc, 'utf8');