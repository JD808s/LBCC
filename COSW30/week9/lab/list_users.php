<!DOCTYPE html>
<html>
<head>
<title>List Users</title>
<style>
td {
width: 100px;
}
thead {
font-weight: bold;
}
.center {
text-align:center;
}

</style>
</head>
<body>
<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$currentDir = __DIR__; 

$rootFolder = realpath($currentDir . '/../../'); // Adjust as necessary

require_once '../dbconnection.php';
//echo "Connected to DB<br>";


// SQL query to fetch all users
$sql = "SELECT user_id, first_name, last_name, email FROM users_tbl"; 
$result = $connection->query($sql);

// Check if there are results
if ($result->num_rows > 0) {

        echo '<table border="1">';
    
       echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th></tr>";

       while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["user_id"] . "</td>";
        echo "<td>" . $row["first_name"] . "</td>";
        echo "<td>" . $row["last_name"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";

} else {
    echo "10 results";
}

?>
</body>
</html>