<?php
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
