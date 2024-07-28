<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exersise_id = $_POST['exersise_id'];
    $program_id = $_POST['program_id'];

    $sql = "DELETE FROM exersise_program where exersise_id = '$exersise_id' and program_id = '$program_id';";
    if ($conn->query($sql) === TRUE) {
        $newURL = '../new_program.php';
        header('Location: '.$newURL);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>