<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $num_session = $_POST['num_session'];
    $title = $_POST['title'];
    $id = uniqid();

    $sql = "INSERT INTO program (id,title,num_session) values('$id','$title',$num_session);";

    if ($conn->query($sql) === TRUE) {
        $newURL = '../index.php';
        header('Location: '.$newURL);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>