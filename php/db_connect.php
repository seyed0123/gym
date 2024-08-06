<?php


//$isAdmin = $_SESSION['username'] === $admin_file_json->username;
//if (!$isAdmin) {
//    header('Location: index.php');
//    exit();
//}

$servername = "localhost";
$username = "seyed";
$password = "Seyed@5516";
$dbname = "gym";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
