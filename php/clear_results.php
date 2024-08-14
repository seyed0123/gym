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


// Clear the session variable holding the search results
if (isset($_POST['clear'])) {
    unset($_SESSION[$_POST['clear']]);
}

// Redirect back to the page with the form
header("Location: ../new_program.php"); // Replace with the actual path to your page
exit();
?>
