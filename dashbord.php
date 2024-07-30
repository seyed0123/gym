<?php
session_start();
$admin_file = fopen("./admin.json", "r") or die("Unable to open file!");
$admin_file_json = json_decode(fread($admin_file,filesize("./admin.json")));
fclose($admin_file);
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
    <form method="post"> 
        <input type="submit" name="logout" value="logout"/> 
    </form>
    <?php

        if(isset($_POST['logout'])) { 
            session_destroy();
            $newURL = './index.php';
            header('Location: '.$newURL);
        }

        include('php/db_connect.php'); 
        
        if ($_SESSION['username'] === $admin_file_json->username)  {
            echo "<button id=\"new_session\" onclick=\"new_session()\">new session</button>
            <button id=\"new_program\" onclick=\"new_program()\">new program</button>
            <button id=\"search_user\" onclick=\"search_user()\">search user</button>";
            // Display search form
            echo "<form method=\"post\">
            <input type=\"text\" name=\"search_username\" placeholder=\"Enter username\" required>
            <button type=\"submit\">Search</button>
            </form>";
        }else {
            $session_username = $_SESSION['username'];
            echo "<form method=\"post\">
            <input type=\"text\" name=\"search_username\" readonly value=\"$session_username\" required>
            <button type=\"submit\">Search</button>
            </form>";
        }
        
            // Display filter form if a user is selected
            if (isset($_POST['search_username']) && !empty($_POST['search_username'])) {
                $search_username = $_POST['search_username'];
                // Fetch user details
                $user_query = $conn->prepare("SELECT * FROM users WHERE username = ?");
                $user_query->bind_param("s", $search_username);
                $user_query->execute();
                $user_result = $user_query->get_result();
        
                if ($user_result->num_rows > 0) {
                    $user = $user_result->fetch_assoc();
                    echo "<h3>User Details:</h3>";
                    echo "<table>";
                    echo "<tr><th>Field</th><th>Value</th></tr>";
                    echo "<tr><td>Name</td><td>" . $user['name'] . "</td></tr>";
                    echo "<tr><td>Address</td><td>" . $user['address'] . "</td></tr>";
                    echo "<tr><td>Height</td><td>" . $user['heigth'] . "</td></tr>";
                    echo "<tr><td>Weight</td><td>" . $user['weigth'] . "</td></tr>";
                    echo "<tr><td>Phone Number</td><td>" . $user['phone_number'] . "</td></tr>";
                    echo "<tr><td>Date of Birth</td><td>" . $user['date_of_birth'] . "</td></tr>";
                    echo "<tr><td>Job</td><td>" . $user['job'] . "</td></tr>";
                    echo "<tr><td>Gender</td><td>" . ($user['gender'] ? 'Male' : 'Female') . "</td></tr>";
                    echo "<tr><td>Way to Introduce</td><td>" . $user['way2intro'] . "</td></tr>";
                    echo "</table>";        
        
                    // Fetch user programs
                    $program_query = $conn->prepare("SELECT * FROM program_user JOIN program ON program_user.program_id = program.id WHERE program_user.username = ?");
                    $program_query->bind_param("s", $search_username);
                    $program_query->execute();
                    $program_result = $program_query->get_result();
        
                    echo "<h3>Programs:</h3>";
                    echo "<table>";
                    echo "<tr><th>Program</th><th>Start Time</th><th>Practice Time</th><th>Diagnosis</th></tr>";
                    while ($program = $program_result->fetch_assoc()) {
                        echo "<tr onclick='showExercises(\"" . $program['program_id'] . "\" , \"" . $program['title'] . "\")' style='cursor: pointer;'>";
                        echo "<td>" . $program['title'] . "</td>";
                        echo "<td>" . $program['start_time'] . "</td>";
                        echo "<td>" . $program['practice_time'] . "</td>";
                        echo "<td>" . $program['diagnosis'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "    <div id=\"exercise_details\"></div>";
                    // Display filter form
                    echo "<form method=\"post\">
                    <input type=\"hidden\" name=\"search_username\" value=\"$search_username\">
                    <input type=\"date\" name=\"start_date\" placeholder=\"Start Date\">
                    <input type=\"date\" name=\"end_date\" placeholder=\"End Date\">
                    <button type=\"submit\">Filter Sessions</button>
                    </form>";
        
                    // Fetch user sessions with optional date filter
                    if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
                        $start_date = $_POST['start_date'];
                        $end_date = $_POST['end_date'];
        
                        $session_query = $conn->prepare("SELECT * FROM session WHERE username = ? AND date BETWEEN ? AND ?");
                        $session_query->bind_param("sss", $search_username, $start_date, $end_date);
                    } else {
                        $session_query = $conn->prepare("SELECT * FROM session WHERE username = ?");
                        $session_query->bind_param("s", $search_username);
                    }
                    $session_query->execute();
                    $session_result = $session_query->get_result();
        
                    echo "<h3>Sessions:</h3>";
                    echo "<table>";
                    echo "<tr><th>Date</th><th>Total Time</th><th>Session Number</th><th>Time in Sauna</th><th>Time in Jacuzzi</th><th>Time in Hydrotherapy</th><th>Time in Massage</th></tr>";
                    while ($session = $session_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $session['date'] . "</td>";
                        echo "<td>" . $session['total_time'] . " minutes</td>";
                        echo "<td>" . $session['num_session'] . "</td>";
                        echo "<td>" . $session['time_sauna'] . " minutes</td>";
                        echo "<td>" . $session['time_jacuzzi'] . " minutes</td>";
                        echo "<td>" . $session['time_hydrotherapy'] . " minutes</td>";
                        echo "<td>" . $session['time_massage'] . " minutes</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No user found with username: $search_username";
                }
            }
        
    ?>

</body>
</html>