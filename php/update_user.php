<?php
include('db_connect.php');

if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $height = (float)$_POST['height']; // Cast to float
    $weight = (float)$_POST['weight']; // Cast to float
    $phone_number = $_POST['phone_number'];
    $date_of_birth = $_POST['date_of_birth']; // Ensure date format is correct (YYYY-MM-DD)
    $job = $_POST['job'];
    $gender = $_POST['gender'] === 'Male' ? 1 : 0;
    $way2intro = $_POST['way2intro'];

    $query = $conn->prepare("UPDATE users SET name = ?, address = ?, heigth = ?, weigth = ?, phone_number = ?, date_of_birth = ?, job = ?, gender = ?, way2intro = ? WHERE username = ?");
    $query->bind_param("ssddssssss", $name, $address, $height, $weight, $phone_number, $date_of_birth, $job, $gender, $way2intro, $username);

    if ($query->execute()) {
        echo "User updated successfully";
    } else {
        echo "Error updating user: " . $query->error;
    }
} else {
    echo "Invalid request.";
}
?>
