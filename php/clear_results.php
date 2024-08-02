<?php
session_start();

// Clear the session variable holding the search results
if (isset($_POST['clear'])) {
    unset($_SESSION[$_POST['clear']]);
}

// Redirect back to the page with the form
header("Location: ../new_program.php"); // Replace with the actual path to your page
exit();
?>
