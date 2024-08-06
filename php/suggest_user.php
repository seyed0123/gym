<?php
session_start();
$admin_file = fopen("../admin.json", "r") or die("Unable to open file!");
$admin_file_json = json_decode(fread($admin_file, filesize("./admin.json")));
fclose($admin_file);
$isAdmin = $_SESSION['username'] === $admin_file_json->username;
if (!$isAdmin) {
    header('Location: index.php');
    exit();
}
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


