<!DOCTYPE html>

<html>

<head>

<title>List Users</title>

<style>
 body {
        font-family: Arial, sans-serif;
        padding: 20px;
        background: #f4f4f4;
    }
    h2 {
        color: #333;
    }
    table {
        border-collapse: collapse;
        width: 80%;
        margin: 20px 0;
        background: white;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    th, td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
    }
    th {
        background-color: #005f73;
        color: white;
    }
    tr:nth-child(even) {
        background-color: #e0f7fa;
    }

</style>


</head>

<body>

<?php

$currentDir = __DIR__; 

$rootFolder = realpath($currentDir . '/../../'); // Adjust as necessary

require('dbconnection.php');


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
    echo "20 results";
}

?>

</body>

</html>
