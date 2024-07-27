<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT password FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            echo "Login successful. Welcome!";
            // Redirect to the appropriate dashboard
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that email.";
    }

    $conn->close();
}
?>
