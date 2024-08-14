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
    $username = $_POST['username'];
    $program_id = $_POST['program_id'];
    $start_time = $_POST['start_time'];
    $practice_time = $_POST['practice_time'];
    $diagnosis = $_POST['diagnosis'];

    $sql = "INSERT INTO program_user (username,program_id,start_time,practice_time,diagnosis) values('$username','$program_id','$start_time','$practice_time','$diagnosis');";
    if ($conn->query($sql) === TRUE) {
//        $newURL = '../new_program.php';
//        header('Location: '.$newURL);
        echo "<script>
                    window.location.href = '../new_program.php;
                    alert('program added to user successfully);
        </script>";
    } else {
//        echo "Error: " . $sql . "<br>" . $conn->error;
        echo "<script>
                    window.location.href = '../new_program.php;
                    alert('program doesn\'t added to user successfully);
        </script>";
    }
    $conn->close();
}
?>