<?php
include('db_connect.php');

$searchTerm = $_GET['term'];

// Prepare the SQL statement
$sql = $conn->prepare("SELECT username, name FROM users WHERE name LIKE ?");
$searchTerm = "%".$searchTerm."%";
$sql->bind_param("s", $searchTerm);

// Execute the statement
$sql->execute();

// Get the results
$result = $sql->get_result();
$usernames = [];
while ($row = $result->fetch_assoc()) {
    $usernames[] = ['username' => $row['username'], 'name' => $row['name']];
}

// Return the results as JSON
echo json_encode($usernames);

// Close connection
$conn->close();


