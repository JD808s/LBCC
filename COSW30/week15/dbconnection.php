<?php
//Connect to the database
$host = "127.0.0.1"; 
$user = "upr8rpbfpevp7"; 
$pass = "cosw30!2025"; 
$db = "dbnevoguib2abt"; 
$port = 3306;

$dbc = mysqli_connect($host, $user, $pass, $db, $port);

if(mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_connect_error() . " (" .mysqli_connect_errno() . ")");
}


