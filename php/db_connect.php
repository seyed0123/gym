<?php
$servername = "localhost";
$username = "seyed";
$password = "Seyed@5516";
$dbname = "gym";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
