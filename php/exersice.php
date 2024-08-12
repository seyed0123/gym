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
    $title = $_POST['title'];
    $num_sets = $_POST['num_sets'];
    $description = $_POST['description'];
    $id = uniqid();

    $sql = "INSERT INTO exersise (id,title,num_sets,description) values('$id','$title',$num_sets,'$description');";

    if ($conn->query($sql) === TRUE) {
//        $newURL = '../new_program.php';
//        header('Location: '.$newURL);
        echo "<script>
                    window.location.href = '../new_program.php;
                    alert('exercise created successfully');
                  </script>";
    } else {
//        echo "Error: " . $sql . "<br>" . $conn->error;
        echo "<script>
                    window.location.href = '../new_program.php;
                    alert('exercise doesn\'t created successfully');
                  </script>";
    }
    $conn->close();
}
?>