<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $program_id = $_POST['program_id'];
    $start_time = $_POST['start_time'];
    $practice_time = $_POST['practice_time'];
    $diagnosis = $_POST['diagnosis'];

    $sql = "UPDATE program_user set start_time='$start_time',practice_time='$practice_time',diagnosis='$diagnosis' where program_id = '$program_id' and username = '$username';";
    echo $sql;
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