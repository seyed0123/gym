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

if (isset($_POST['username'])) {
    $username = $_POST['username'];

    $query = $conn->prepare("DELETE FROM users WHERE username = ?");
    $query->bind_param("s", $username);

    if ($query->execute()) {
        echo "User deleted successfully";
    } else {
        echo "Error deleting user: " . $query->error;
    }
} else {
    echo "Invalid request.";
}
?>
