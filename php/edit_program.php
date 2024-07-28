<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $num_session = $_POST['num_session'];
    $id = $_POST['id'];

    $sql = "UPDATE program set title='$title',num_session=$num_session where id = '$id';";
    echo $sql;
    if ($conn->query($sql) === TRUE) {
        $newURL = '../new_program.php';
        header('Location: '.$newURL);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>