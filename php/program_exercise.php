<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exercise_id = $_POST['exercise_id'];
    $program_id = $_POST['program_id'];

    $sql = "INSERT INTO exersise_program (exersise_id,program_id) values('$exercise_id','$program_id');";

    if ($conn->query($sql) === TRUE) {
        $newURL = '../index.php';
        header('Location: '.$newURL);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>