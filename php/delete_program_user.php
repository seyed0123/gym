<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $program_id = $_POST['program_id'];

    $sql = "DELETE FROM program_user where username = '$username' and program_id = '$program_id';";
    if ($conn->query($sql) === TRUE) {
        $newURL = '../new_program.php';
        header('Location: '.$newURL);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
    $_SESSION['program_user_results'] = [];
}
?>