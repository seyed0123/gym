<?php
session_start();
include 'db_connect.php';

$admin_file = fopen("../admin.json", "r") or die("Unable to open file!");
$admin_file_json = json_decode(fread($admin_file,filesize("../admin.json")));
fclose($admin_file);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($admin_file_json->username == $username && password_verify($password, $admin_file_json->password)){
        $_SESSION['username'] = $username;
        $newURL = '../index.php';
        header('Location: '.$newURL);
    }else{
        $sql = "SELECT password FROM users WHERE username='$username'";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $username;
                $newURL = '../index.php';
                header('Location: '.$newURL);
            } else {
                echo "<script>
                    alert('Invalid password ');
                    window.location.href = '../index.php';
                  </script>";
            }
        } else {
            echo "<script>
                    alert('Invalid username');
                    window.location.href = '../index.php';
                  </script>";
        }
    
        $conn->close();
    }
}
?>
