<?php
session_start();
$admin_file = fopen("../admin.json", "r") or die("Unable to open file!");
$admin_file_json = json_decode(fread($admin_file, filesize("../admin.json")));
fclose($admin_file);
$isAdmin = $_SESSION['username'] === $admin_file_json->username;
if (!$isAdmin) {
    header('Location: index.php');
    exit();
}
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $sql = "DELETE FROM exersise where id = '$id';";

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