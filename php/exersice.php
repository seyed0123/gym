<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $num_sets = $_POST['num_sets'];
    $description = $_POST['description'];
    $id = uniqid();

    $sql = "INSERT INTO exersise (id,title,num_sets,description) values('$id','$title',$num_sets,'$description');";

    if ($conn->query($sql) === TRUE) {
        $newURL = '../index.php';
        header('Location: '.$newURL);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>