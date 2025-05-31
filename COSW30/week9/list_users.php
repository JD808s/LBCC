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

$currentDir = __DIR__; // __DIR__ not _DIR_

$rootFolder = realpath($currentDir . '/../../'); // Adjust as necessary

require $rootFolder . '/dbconnection.php';

// SQL query to fetch all users
$sql = "SELECT id, first_name, last_name, email FROM users"; 
$result = $connection->query($sql);

// Check if there are results
if ($result->num_rows > 0) {

        echo '<table border="1">';
    
       echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th></tr>";

       while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["first_name"] . "</td>";
        echo "<td>" . $row["last_name"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";

} else {
    echo "No results found.";
}

?>

</body>

</html>