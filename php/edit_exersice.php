<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $num_sets = $_POST['num_sets'];
    $description = $_POST['description'];
    $id = $_POST['id'];

    $sql = "UPDATE exersise set title='$title',num_sets=$num_sets,description='$description' where id = '$id';";

    if ($conn->query($sql) === TRUE) {
        $newURL = '../new_program.php';
        header('Location: '.$newURL);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
    $_SESSION['exercise_results'] = [];
}
?>