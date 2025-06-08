<?php
session_start();
$_SESSION = [];
session_destroy();
header("Location: login.php?message=You have been logged out.");
exit;
