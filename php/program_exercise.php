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
    $exercise_id = $_POST['exercise_id'];
    $program_id = $_POST['program_id'];

    $sql = "INSERT INTO exersise_program (exersise_id,program_id) values('$exercise_id','$program_id');";

    if ($conn->query($sql) === TRUE) {
//        $newURL = '../new_program.php';
//        header('Location: '.$newURL);

        echo "<script>
                    window.location.href = '../new_program.php;
                    alert('exercise added to program successfully');
                  </script>";
    } else {
//        echo "Error: " . $sql . "<br>" . $conn->error;
        echo "<script>
                    window.location.href = '../new_program.php;
                    alert('exercise doesn\'t added to program successfully');
                  </script>";
    }
    $conn->close();
}
?>