<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/dashbord.js"></script>
    <title>Document</title>
</head>
<body>
    <button id="new_session" onclick="new_session()">new session</button>
    <button id="new_program" onclick="new_program()">new program</button>
    <button id="new_exersise" onclick="new_exersice()">new exersise</button>
    <form method="post"> 
        <input type="submit" name="logout" value="logout"/> 
    </form>
    <?php
        if(isset($_POST['logout'])) { 
            session_destroy();
            $newURL = './index.php';
            header('Location: '.$newURL);
        } 
    ?> 
</body>
</html>